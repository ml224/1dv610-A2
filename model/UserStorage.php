<?php

class UserStorage {
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