<?php
//TODO change classname or break out session and cookie
class UserSession {
	private static $user = "USER";
	private static $ip = "REMOTE_ADDR";
	private static $agent = "HTTP_USER_AGENT";

	public function sessionSet() : bool { 
		return isset($_SESSION[self::$user]);
	}

	public function setUserSession($username) : void {
		$_SESSION[self::$user] = $username;
		$_SESSION[self::$ip] = $_SERVER[self::$ip];
		$_SESSION[self::$agent] = $_SERVER[self::$agent];
	}

	public function sessionNotAltered() : bool {
		return $_SESSION[self::$ip] === $_SERVER[self::$ip] 
		&& $_SESSION[self::$agent] === $_SERVER[self::$agent]; 
	}

	public function unsetUserSession() : void {
		unset($_SESSION[self::$user]);
		unset($_SESSION[self::$ip]);
		unset($_SESSION[self::$agent]);
		
	}

	public function getUsername() : string {
		return $_SESSION[self::$user];
	}
	
}