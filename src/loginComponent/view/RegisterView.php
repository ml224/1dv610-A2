<?php

class RegisterView{
    private static $createUser = 'RegisterView::Create';
    private static $username = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $message = 'RegisterView::Message';

	private $strippedUsername;

    public function render($message) : string {
		return $this->registerForm($message);
	}

	private function registerForm($message) : string {
		return '
		<a href="/">Back to login</a>
		<form method="post"> 
				<fieldset>
					<legend>Sign up - enter Username and password</legend>
					<p id="'. self::$message .'">'. $message .'</p>
					<label for="' . self::$username . '">Username :</label>
					<input type="text" id="' . self::$username . '" name="' . self::$username . '" value="'. $this->getInputName() .'" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />
					<label for="' . self::$passwordRepeat . '">Repeat password :</label>
					<input type="password" id="' . self::$passwordRepeat . '" name="' . self::$passwordRepeat . '" />

					<input type="submit" name="' . self::$createUser . '" value="create" />
				</fieldset>
			</form>
		';
	}

	private function getInputName(){
		if($this->registerRequested()){
			return $this->strippedUsername ? $this->strippedUsername : $this->getUsername();	
		}else{
			return "";
		}
	}

    public function registerRequested() : bool {
		return isset($_POST[self::$username]);
	}

	public function stripUsername() : void {
		$this->strippedUsername = strip_tags($_POST[self::$username]);
	}

    public function getUsername() : string {
		return $_POST[self::$username];
    }
    
    public function getPassword() : string {
		return $_POST[self::$password];		
	}

	public function getRepeatPassword() : string {
		return $_POST[self::$passwordRepeat];	
	}

	public function getErrorsHtml($validator) : string {
		$errorArray = $this->errorArray($validator);
		return $this->listErrorsHtml($errorArray);
	}

	private function errorArray($validator) : array {
		$repeat = $_POST[self::$passwordRepeat];
		$arr = array();

		if($validator->usernameTooShort()){
			$msg = "Username has too few characters, at least 3 characters.";
			array_push($arr, $msg);
		}
		if($validator->passwordTooShort()){
			$msg = "Password has too few characters, at least 6 characters.";
			array_push($arr, $msg);
		}
		if($validator->invalidCharacters()){
			$msg = "Username contains invalid characters.";
			array_push($arr, $msg);
		}
		if($validator->passwordsDontMatch($repeat)){
			$msg = "Passwords do not match.";
			array_push($arr, $msg);
		}

		return $arr;
	}

	private function listErrorsHtml($messages) : string {
		$str = 'Errors found! <br>';
		foreach($messages as $message){
            $str .= $message . '<br>';
        }
        return $str;
	}

	public function userExistsMessage() : string {
		return "User exists, pick another username.";
	}
}