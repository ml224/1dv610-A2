<?php

class User{
    private $requestUsername;
    
    private $mysqli;
    private $dbUserObject;

    public function User($name){
        $this->requestUsername = $name;
        
        $this->connectDB();
        $this->dbUserObject = $this->setUser();
    }

    private function connectDB(){
        $this->mysqli = new mysqli("localhost", "root", "", "users");
        
        if ($this->mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        } 
    }

    private function setUser(){
        $this->dbObject = $this->mysqli->query("SELECT * FROM users WHERE username = '$this->requestUsername'");
    }

    private function userExists(){
        if($this->dbUserObject){
            return true;
        } else{
            return false;
        }
    }
    
    private function getPassword(){
           if($this->userExists()){
                $user = $this->mysqli_fetch_array($this->dbUserObject, MUSQLI_ASSOC);
                return $dbArray["password"];
           }
    }

    //compare with request password
    public function checkIfPasswordCorrect($psw){
        return $this->getPassword() === $psw; 
    }
}


    //if false-
    //throw new Exception('Username incorrect');
//private static $userSession = 'User::loggedInUser';
    

    //private static $SESSION_KEY = __NAMESPACE__ . __CLASS__ . "user";
    

/*
    public function logIn(){
        
    }

    public function correctCredentials(){

    }

    public function isLoggedIn($requestedLogin){
         return $_SESSION[self::$user] === $requestedLogin;   
    }



    //could be broken out into session class
    public function logoutUser(){
        //clear cookies or session
    }

    public function loginUser($name, $psw){
        //find user in db, then set session
    }*/