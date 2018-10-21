<?php

class UserDatabase{
    private $mysqli;

    function __construct($mysqli){
        $this->mysqli = $mysqli;    
    }
    
    public function registerUser($name, $password) : void {
        if($this->userExists($name)){
            throw new Exception("Username already exists");
        }
        
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $this->mysqli->prepare("INSERT INTO users (username, password) VALUES(?, ?)");
        $stmt->bind_param("ss", $name, $hashed);
        
        if(!$stmt->execute())
            throw new Exception("Cookie not updated, something went wrong.");
        
        $stmt->close();
    }

    public function userExists($name) : bool {
        if($this->getUserArray($name)){
            return true;
        }
        
        return false;
    }

    private function getUserArray($name) {
        $stmt = $this->mysqli->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row;
    }

    public function cookieExists($cookie) : bool {
        $stmt = $this->mysqli->prepare("SELECT cookie FROM users WHERE cookie = ?");
        $stmt->bind_param("s", $cookie);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        if($row){
            return true;
        }
        
        return false;
    }

    public function storeCookie($name, $cookie) : void {
        if(!$this->userExists($name)){
            throw new Exception("User does not exist");
        }

        $stmt = $this->mysqli->prepare("UPDATE users SET cookie = ? WHERE username = ?");
        $stmt->bind_param("ss", $cookie, $name);
        if(!$stmt->execute()){
            throw new Exception("Cookie not updated, something went wrong.");
        }
        
        $stmt->close();
    }

    public function clearCookie($cookie) : void {
        $stmt = $this->mysqli->prepare("UPDATE users SET cookie = ? WHERE cookie = ?");
        $n = null;
        $stmt->bind_param("ss", $n, $cookie);
        if(!$stmt->execute()){
            throw new Exception("Cookie not replaced with null value, something went wrong.");
        }
        
        $stmt->close();
    }
    
    public function nameOrPasswordIncorrect($name, $password) : bool {
        return !$this->userExists($name) || !$this->passwordIsCorrect($name, $password); 
    }

    public function passwordIsCorrect($name, $psw) : bool {
        return password_verify($psw, $this->correctPassword($name));
    }

    private function correctPassword($name) : string {
        $userArray = $this->getUserArray($name);
        if($userArray){
            return $userArray["password"];
        } else {
            throw new Exception("username does not exist");
        }
    }
    
}
