<?php

class LoginView {

	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';	
	private static $keep = 'LoginView::KeepMeLoggedIn';
	
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $loginMessage = 'LoginView::Message';
	
	private $isLoggedIn;

	function __construct(){
		$this->unsetPreviousSessionVariables();
		$this->setSessionVariables();
	}

	private function unsetPreviousSessionVariables(){
		unset($_SESSION[self::$name]);
		unset($_SESSION[self::$password]);
		unset($_SESSION[self::$logout]);
		unset($_SESSION[self::$keep]);
	}

	private function setSessionVariables(){
		//TODO - set cookie in this class and dont share cookie name 
		$_SESSION[self::$cookieName] = self::$cookiePassword;

		if($this->loginAttempted()){
			$_SESSION[self::$name] = $_POST[self::$name];
			$_SESSION[self::$password] = $_POST[self::$password];
		} 
		if($this->logoutRequested()){
			$_SESSION[self::$logout] = $_POST[self::$logout];
		}
		if($this->keepRequested())
			$_SESSION[self::$keep] = $_POST[self::$keep];
	}

	public function loginAttempted(){
		return isset($_POST[self::$name]);
	}
	
	public function logoutRequested(){
		return isset($_POST[self::$logout]);
	}

	private function keepRequested(){
		return isset($_POST[self::$keep]);
	}


	public function render($isLoggedIn, $message) {
		if($isLoggedIn)
			return $this->generateLogoutButtonHTML($message);
		else
			return $this->generateLoginFormHTML($message);
	}

	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . self::$loginMessage . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}

	private function generateLoginFormHTML($message) {
		return '
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

	public function getInputName() {
		if(isset($_SESSION[self::$name])){
			return $_SESSION[self::$name];
		}
	}

	public function getInputPassword() {
		if(isset($_SESSION[self::$password])){
			return $_SESSION[self::$password];
		}
	}

	public function setInputName($name){
		$_SESSION[self::$name] = $name;
	}

	
	public function keepLoggedIn(){
		return isset($_SESSION[self::$keep]);
	}

	private function cookieSet(){
		return isset($_COOKIE[self::$cookiePassword]);
	}
	public function getCookiePassword(){
		if($this->cookieSet()){
			return $_COOKIE[self::$cookiePassword];
		}
	}

	public function clearCookie(){
		if($this->cookieSet()){
			unset($_COOKIE[self::$cookiePassword]);
			unset($_SESSION[self::$keep]);
		}
	}

	public function getCookieName(){
		if(isset($_SESSION[self::$cookieName])){
			//same as cookie password
			return $_SESSION[self::$cookieName];
		}
	}
}