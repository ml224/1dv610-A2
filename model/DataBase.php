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

    public function comparePassword($name, $psw){
        //will throw exception if username not found
        return password_verify($psw, $this->correctPassword($name));
        //return $psw === $this->correctPassword($name); 
    }

    private function correctPassword($name){
        $dbObject = $this->mysqli->query("SELECT * FROM users WHERE username = '$name'");
        if($dbObject->num_rows > 0){
            return $dbObject->fetch_array()["password"];
        } else {
            throw new Exception("username does not exist");
        }
    }
}
