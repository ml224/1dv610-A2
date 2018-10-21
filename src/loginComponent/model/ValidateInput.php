<?php

class ValidateInput{
  private $password;
  private $username;

  function __construct($name, $password){
    $this->username = $name;
    $this->password = $password;
  }
  
  public function usernameMissing(){
		return strlen($this->username) === 0;
  }
    
  public function passwordMissing(){
		return strlen($this->password) === 0;
  }

  
  public function usernameTooShort(){
    return strlen($this->username) < 3;
  }

  public function passwordTooShort(){
    return strlen($this->password) < 6;
  }

  public function invalidCharactersInUsername(){
    if(!$this->usernameMissing())
      return !ctype_alnum($this->username);
  }
 
  public function passwordsDontMatch($repeatedPassword){
    return !($this->password === $repeatedPassword);
  }

  public function credentialsCorrect($db){
    $this->db->nameOrPasswordIncorrect($this->username, $this->password);
  }
}