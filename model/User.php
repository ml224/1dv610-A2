<?php

class User{
    private $username;
    private $psw;

    private static $user = 'User::loggedInUser';

    //private static $SESSION_KEY = __NAMESPACE__ . __CLASS__ . "user";
    
    public function User($name, $psw){
        $this->username = $name;
        $this->psw = $psw; 
    }

    public function isLoggedIn($requestingLogin){
         return $_SESSION[self::$user] === $requestingLogin;   
    }



    //could be broken out into session class
    public function logoutUser(){
        //clear cookies or session
    }

    public function loginUser($name, $psw){
        //find user in db, then set session
    }
}