<?php
//TODO change classname or break out session and cookie
class UserSession {
	private static $user = "USER";
	private static $ip = "REMOTE_ADDR";
	private static $agent = "HTTP_USER_AGENT";

	private $db;

	function __construct(UserDatabase $db){
		$this->db = $db;
	}

	public function sessionSet(){ 
		return isset($_SESSION[self::$user]);
	}

	/*public function userSessionNotAltered(){
		return $_SESSION[self::$userSession] === $_COOKIE[self::$userSession];
	}*/

	public function setUserSession($username){
		$_SESSION[self::$user] = $username;
		$_SESSION[self::$ip] = $_SERVER[self::$ip];
		$_SESSION[self::$agent] = $_SERVER[self::$agent];
	}

	public function sessionNotAltered(){
		return $_SESSION[self::$ip] === $_SERVER[self::$ip] 
		&& $_SESSION[self::$agent] === $_SERVER[self::$agent]; 
	}

	public function unsetUserSession(){
		unset($_SESSION[self::$user]);
		unset($_SESSION[self::$ip]);
		unset($_SESSION[self::$agent]);
		
	}
	
}