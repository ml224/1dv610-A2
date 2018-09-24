<?php

require_once("model/UserStorage.php");
require_once("model/User.php");
require_once("model/DataBase.php");

class UserSessionController{
    private $storage;
    private $user;
    private $db;
    private $loginMessage;
    private $username;
    private $password;

    function __construct(){
        $this->storage = new UserStorage();
        $this->db = new DataBase();
    }

    public function userSet(){
        return $this->user;
    }

    public function setUser($name, $password){
        $this->user = new User($name, $password); 
        $this->username = $name;
        $this->password = $password;
    }

    public function isLoggedIn(){
        if($this->user){
            return $this->storage->isLoggedIn($this->user);
        } else{
            return false;
        }

    }

    public function credentialsCorrect(){
        if($this->db->userExists($this->username)){
            return $this->db->comparePassword($this->username, $this->password);
        }  else{
            return false;
        }
    }

    public function logIn(){
            $this->storeUser($this->user);
    }

    public function logOut(){
         $this->storage->unsetUserSession();
         $this->loginMessage = "Bye bye!";
    }
    public function passwordOrNameIncorrect(){
        return !$this->db->userExists($this->username) || !$this->db->comparePassword($this->username, $this->password);
    }

    private function storeUser(){
        $this->storage->storeUserSession($this->user);
    }

    private function unstoreUser(){
        $this->storage->unsetUserStorage();
    }

    public function getLoginMessage(){
        if($this->loginMessage){
            return $this->loginMessage;
        }
    }

   
}

