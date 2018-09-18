<?php

namespace model;
session_start();

class UserStorage {
	private static $SESSION_KEY = __NAMESPACE__ . __CLASS__ .  "user";

    public function loadUser() {
		if (isset($_SESSION[self::$SESSION_KEY])) {
			return $_SESSION[self::$SESSION_KEY];
		} else {
            //create new user if not saved? 
			return new User();
		}
	}
	public function saveUser(User $toBeSaved) {
		$_SESSION[self::$SESSION_KEY] = $toBeSaved;
	}
}