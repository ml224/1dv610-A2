<?php


class RegisterView{
    private static $createUser = 'RegisterView::Create';
    private static $username = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $message = 'RegisterView::Message';

    function __construct(){
			$this->setSessionVariables();
    }

    public function render($message){
		$_SESSION[self::$message] = $message;
		return $this->registerForm();
	}

	private function registerForm(){
		return '
		
		<form method="post"> 
				<fieldset>
					<legend>Sign up - enter Username and password</legend>
					<p id="'. self::$message .'">'. $_SESSION[self::$message] .'</p>
					<label for="' . self::$username . '">Username :</label>
					<input type="text" id="' . self::$username . '" name="' . self::$username . '" value="'. $this->getUsername() .'" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />
					<label for="' . self::$passwordRepeat . '">Repeat password :</label>
					<input type="password" id="' . self::$passwordRepeat . '" name="' . self::$passwordRepeat . '" />

					<input type="submit" name="' . self::$createUser . '" value="create" />
				</fieldset>
			</form>
		';
	}
		
    public function getUsername() {
			if(isset($_SESSION[self::$username]))
				return $_SESSION[self::$username];
    }
    
    public function getPassword(){
		if(isset($_SESSION[self::$password]))
			return $_SESSION[self::$password];		
	}

	public function getRepeatPassword(){
		if(isset($_SESSION[self::$passwordRepeat]))
			return $_SESSION[self::$passwordRepeat];		
	}

	public function setUsername($name){
		$_SESSION[self::$username] = $name;
	}
    
	private function setSessionVariables(){
		if($this->registerNewUserRequested()){
			$_SESSION[self::$username] = $_POST[self::$username];
			$_SESSION[self::$password] = $_POST[self::$password];
			$_SESSION[self::$passwordRepeat] = $_POST[self::$passwordRepeat];
		} 
    }

    public function registerNewUserRequested(){
		return isset($_POST[self::$username]);
	}

	public function listMessagesHtml($messages){
		$str = "";
		foreach($messages as $message){
            $str .= $message . '<br>';
        }
        return $str;
	}
}