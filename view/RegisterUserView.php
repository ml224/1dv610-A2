<?php


class RegisterUserView{
    private static $createUser = 'NewUser::Create';
    private static $username = 'NewUser::Username';
    private static $password = 'NewUser::Password';

    function RegisterUserView(){
			$this->setSessionVariables();
    }

    public function render(){
        echo '
		
		<form method="post" > 
				<fieldset>
					<legend>Sign up - enter Username and password</legend>
					
					<label for="' . self::$username . '">Username :</label>
					<input type="text" id="' . self::$username . '" name="' . self::$username . '" value="'. $this->getRequestUsername() .'" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<input type="submit" name="' . self::$createUser . '" value="create" />
				</fieldset>
			</form>
		';
		}
		
    public function getRequestUsername() {
			if($this->createUserRequested()){
				$newUser = $_SESSION[self::$username];
				unset($_SESSION[self::$username]);
				return $newUser;
			}
    }
    
    public function getRequestPassword(){
			if($this->createUserRequested()){
				$newUser = $_SESSION[self::$password];
				unset($_SESSION[self::$password]);
				return $newUser;
				}
			}
    
	private function setSessionVariables(){
		if($this->createUserRequested()){
			$_SESSION[self::$username] = $_POST[self::$username];
			$_SESSION[self::$password] = $_POST[self::$password];
		} 
    }

    private function createUserRequested(){
		return isset($_POST[self::$username]);
	}
}