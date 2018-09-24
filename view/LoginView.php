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

	private $usernameCorrect;
	private $passwordCorrect;

	function __construct(){
		$this->setSessionVariables();
	}


	public function render($isLoggedIn, $message) {
		if($isLoggedIn){
			
			return $this->generateLogoutButtonHTML($message);
		} else{
			return $this->generateLoginFormHTML($message);
		}
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
		if($this->loginAttempted()){
			$_SESSION[self::$name] = $_POST[self::$name];
			$_SESSION[self::$password] = $_POST[self::$password];
			unset($_SESSION[self::$logout]);
			unset($_POST[self::$logout]);
		} 
		if($this->logoutRequested()){
			//unset username and password first when logout requested
			$_SESSION[self::$logout] = $_POST[self::$logout];
			unset($_SESSION[self::$name]);
			unset($_SESSION[self::$password]);
		}
	}


	//public functions used in controller
	public function loginAttempted(){
		return isset($_POST[self::$name]);
	}

	public function logoutRequested(){
		return isset($_POST[self::$logout]);
	}

	
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
}


//so that loginattempted returns false when reloading page

		/*if(!isset($_SESSION[self::$name])){
			//header("Location: " . $_SERVER['REQUEST_URI']);
			   //exit();
			   
		}*/