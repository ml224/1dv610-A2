<?php

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';	
	private static $cookieTime = 'LoginView::CookieTime';	
	private static $keep = 'LoginView::KeepMeLoggedIn';	
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $loginMessage = 'LoginView::Message';
	
	private $customizedInputName;

	public function render($isLoggedIn, $message) : string {
		if($isLoggedIn)
			return $this->generateLogoutButtonHTML($message);
		else
			return $this->generateLoginFormHTML($message);
	}

	private function generateLogoutButtonHTML($message) : string {
		return '
			<h2>Logged in</h2>
			<form  method="post" >
				<p id="' . self::$loginMessage . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}

	private function generateLoginFormHTML($message) : string {
		return '
		<h2>Not logged in</h2>
		<a href="?register=true">Register a new user</a>
		<form method="post" action="/"> 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$loginMessage . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="'. $this->getInputName() .'" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}

	public function getInputName() : string {
		if($this->customizedInputName){
			return $this->customizedInputName;
		}
		return $this->loginAttempted() ? $_POST[self::$name] : "";
	}
	
	public function loginAttempted() : bool {
		return isset($_POST[self::$name]);
	}

	public function setInputName($name) : void {
		$this->customizedInputName = $name;
	}

	public function getInputPassword() : string {
		return $_POST[self::$password];
	}
	
	public function keepLoggedIn() : bool {
		return isset($_POST[self::$keep]);
	}

	public function cookieSet() : bool {
		return isset($_COOKIE[self::$cookiePassword]);
	}
	
	public function logoutRequested() : bool {
		return isset($_POST[self::$logout]);
	}

	public function setCookie($cookie) : void {
		setcookie(self::$cookiePassword, $cookie, time()+60*60*24*30, '/');
	}
	
	public function clearCookie() : void {
		setcookie(self::$cookiePassword, false, time()+60*60*24*30, '/');
	}

	public function randomCookie() : string {
		return uniqid(php_uname('n'), true);
	}

	public function getCookie() : string {
		return $_COOKIE[self::$cookiePassword];
	}

	public function nameOrPasswordMissing() : bool {
		return empty($_POST[self::$username]) || empty($_POST[self::$password]);
	}

	public function getMessageIfError(UserDatabase $db) : string {
		if($this->loginAttempted()){
			$name = $_POST[self::$name];
			$psw = $_POST[self::$password];

			if(empty($name)){
				return "Username is missing";
			}
			if(empty($psw)){
				return "Password is missing";
			}
			if($db->nameOrPasswordIncorrect($name, $psw)){
				return "Wrong name or password";
			}
		}
		
		if($this->cookieSet() && !$db->cookieExists($this->getCookie())){
			return "Wrong information in cookies";				
		}

		return "";
	}

	public function welcomeMessage() : string {
        return "Welcome";
	}
	
	public function cookieLoginMessage() : string {
        return "Welcome back with cookie";
	}

    public function byeMessage() : string {
        return "Bye bye!";
	}
	
	public function newUserMessage(){
        return "Registered new user.";
    }
}