<?php

class DataBase{
    private $mysqli;


    public function DataBase(){
        $this->connectDB();
    }
    
    private function connectDB(){
        $this->mysqli = new mysqli("localhost", "root", "", "users");
        
        if ($this->mysqli->connect_error) {
            die("Connection failed: " . $this->mysqli->connect_error);
        } 
    }

    public function registerUser($name, $password){
        $this->verifyNewCredentials($name, $password);

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $this->mysqli->query("INSERT IGNORE INTO users (username, password) VALUES('$name', '$hashed')");
    }
    
    public function userExists($name){
        try{
            $psw = $this->correctPassword($name);
            return true;
        } catch(Exception $e){
            return false;
        }
    }

    public function storeCookie($name, $cookie){
        if(!$this->getUser($name))
            throw new Exception("User does not exist");

        $this->mysqli->query("INSERT INTO users WHERE username = '$name' (cookie) VALUES ('$cookie')");
    }

    public function cookieExists($cookie){
        $dbCookie = $this->mysqli->query("SELECT cookie FROM users WHERE cookie = '$cookie'");
        if($dbCookie){
            return true;
        } else{
            return false;
        }
    }

    public function clearCookie($cookie){
        //clear cookie from db
        $this->mysqli->query("INSERT INTO users WHERE cookie = '$cookie' (cookie) VALUES (NULL)");
    }

    public function comparePassword($name, $psw){
        //will throw exception if username not found
        return password_verify($psw, $this->correctPassword($name));
    }

    private function verifyNewCredentials($name, $password){
        //TODO put logic in validator
        if(strlen($name) < 4){
            throw new Exception("username must be more than 4 characters long");
        }
        if(strlen($password) < 4){
            throw new exception("password must be more than 4 characters long");
        }
    }

    private function correctPassword($name){
        $dbObject = $this->getUser($name);
        if($dbObject->num_rows > 0){
            return $dbObject->fetch_array()["password"];
        } else {
            throw new Exception("username does not exist");
        }
    }

    private function getUser($name){
        return $this->mysqli->query("SELECT * FROM users WHERE username = '$name'");
    }

    public function nameOrPasswordIncorrect($name, $password){
        return !$this->userExists($name) || !$this->comparePassword($name, $password); 
    }
}
