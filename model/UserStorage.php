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

	public function setUserSession(User $user){
		$_SESSION[self::$userSession] = $user;
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