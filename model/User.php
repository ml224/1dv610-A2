<?php

class User{
    private $username;
    private $password;
    private $userSession;

    function __construct($name, $password){
        $this->username = $name;
        $this->password = $password;
    }

    public function getPassword(){
        return $this->password;
    }
    
    public function getUsername(){
        return $this->username;
    }

}