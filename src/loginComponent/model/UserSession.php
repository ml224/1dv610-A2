<?php
//TODO change classname or break out session and cookie
class UserSession {
	private static $userSession = "Model::UserSession";
	private $db;

	function __construct(DataBase $db){
		$this->db = $db;
	}

	public function userSessionSet(){ 
		return isset($_SESSION[self::$userSession]);
	}

	public function userSessionNotAltered(){
		return $_SESSION[self::$userSession] === $_COOKIE[self::$userSession];
	}

	public function setUserSession($username){
		$random = $this->randomStringForCookie();
		$_SESSION[self::$userSession] = $username . $random;

		//cookie will be compared with session to ensure session not altered
		//will be secure in production, where safe and httponly will be specified
		//no way to steel or alter cookie if httponly and safe
		setcookie(self::$userSession, $username . $random, 0, '/');
	}

	public function userSessionCorrect($session){
		return $_SESSION[self::$userSession] === $session; 
	}

	public function unsetUserSession(){
		if(isset($_SESSION[self::$userSession])){
			unset($_SESSION[self::$userSession]);
		}
	}

	//will throw exception if user does not exist
	public function setCookiePassword($username, $cookieName){
		$random = $this->randomStringForCookie();

		//setting cookie that expires in 15 minutes
		setcookie($cookieName, $random, time() + (60 * 15), '/');
		$this->db->storeCookie($username, $random);
	}

	public function clearCookie($cookieName, $cookie){
		$this->db->clearCookie($cookie);
		setcookie($cookieName, false, time() + (60 * 15), '/');
	}

	private function randomStringForCookie(){
		return uniqid(php_uname('n'), true);
	}
	
}