<?php
class LoginMessage{

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

}