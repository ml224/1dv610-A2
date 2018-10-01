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

}