<?php
class MessageView{

    public function passwordMissing(){
		return "Password is missing";
    }
	
    public function usernameMissing(){
        return "Username is missing";
    }

    public function wrongNameOrPassword(){
        return "Wrong name or password";
    }

    public function welcome(){
        return "Welcome";
    }

    public function bye(){
        return "Bye bye!";
    }

    public function passwordsDontMatch(){
        return "Passwords do not match.";
    }

    public function usernameTooShort(){
        return "Username has too few characters, at least 3 characters.";                    
    }

    public function passwordTooShort(){
        return "Password has too few characters, at least 6 characters.";                    

    }

    public function userExists(){
        return "User exists, pick another username.";
    }

    public function invalidCharactersInUsername(){
        return "Username contains invalid characters.";
    }

    public function wrongInformationInCookie(){
        return "Wrong information in cookies";
    }

}