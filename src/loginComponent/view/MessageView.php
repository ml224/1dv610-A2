<?php
class MessageView{

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

}