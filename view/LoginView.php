<?php

session_start();

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';	
	private static $keep = 'LoginView::KeepMeLoggedIn';
	
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $loginMessage = 'LoginView::Message';


	function __construct(){
		$this->setSessionVariables();
	}


	public function render($isLoggedIn) {		
		return $isLoggedIn ? 
		$this->generateLogoutButtonHTML() :
		$this->generateLoginFormHTML($_SESSION[self::$loginMessage]);
	}

	private function generateLogoutButtonHTML() {
		return '
			<form  method="post" >
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
				//<p id="' . self::$messageId . '">' . $message .'</p>

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

	private function loginMessage(){
		if(strlen($_POST[self::$name]) === 0){
			return "Username is missing";
		}
		if(strlen($_POST[self::$password]) === 0){
			return "Password is missing";
		}
		else{
			return "";
		}
	}

	private function setSessionVariables(){
		if($this->loginAttempted()){
			$_SESSION[self::$loginMessage] = $this->loginMessage();
			$_SESSION[self::$name] = $_POST[self::$name];
			$_SESSION[self::$password] = $_POST[self::$password];
		} 
	}

	private function loginAttempted(){
		return isset($_POST[self::$name]);
	}

	
	public function getRequestUsername() {
		if($this->loginAttempted()){
			return $_SESSION[self::$name];
		}
	}
	
	public function getRequestPassword() {
		if($this->loginAttempted()){
			return $_SESSION[self::$password];
		}
	}
	
}