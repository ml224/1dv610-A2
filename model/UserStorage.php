<?php

class UserStorage {
	private static $SESSION_KEY =  "Model::User";

	public function storeUserSession(User $toBeSaved) {
		$_SESSION[self::$SESSION_KEY] = $toBeSaved;
	}

	public function isLoggedIn(User $user){
		if(isset($_SESSION[self::$SESSION_KEY])){
			return $user == $_SESSION[self::$SESSION_KEY];			
		} else{
			return false;
		}
	} 

	public function storageSet(){
		return isset($_SESSION[self::$SESSION_KEY]);
	}

	public function unsetUserSession(){
		if(isset($_SESSION[self::$SESSION_KEY])){
			unset($_SESSION[self::$SESSION_KEY]);
		}
	}
}