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
		$this->setSessionVariables();
	}


	public function render($isLoggedIn, $message) {
		if($isLoggedIn)
			return $this->generateLogoutButtonHTML($message);
		else
			return $this->generateLoginFormHTML($message);
	}

	public function renderLogoutPage(){
		$message = "Bye bye!";
		return '
				<p id="' . self::$loginMessage . '">' . $message .'</p>';
		
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
		$username = $this->getRequestUsername();
		return '
		<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$loginMessage . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="'. $username .'" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}

	private function setSessionVariables(){
		//clear all session variables..
		//$_SESSION[self::$cookieName] = self::$cookiePassword;
		//session_unset();
		unset($_SESSION[self::$name]);
		unset($_SESSION[self::$password]);
		unset($_SESSION[self::$logout]);
		unset($_SESSION[self::$keep]);

		//always set cookie name 
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


	
	private function keepRequested(){
		return isset($_POST[self::$keep]);
	}

	public function loginAttempted(){
		return isset($_POST[self::$name]);
	}

	public function logoutRequested(){
		return isset($_POST[self::$logout]);
	}



	//session variables
	
	public function getRequestUsername() {
		if(isset($_SESSION[self::$name])){
			return $_SESSION[self::$name];
		}
	}
	
	public function getRequestPassword() {
		if(isset($_SESSION[self::$password])){
			return $_SESSION[self::$password];
		}
	}

	//cookie stuff
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

	public function keepLoggedIn(){
		return isset($_SESSION[self::$keep]);
	}
}