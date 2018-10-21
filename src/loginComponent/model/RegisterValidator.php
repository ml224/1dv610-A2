<?php

class RegisterValidator{
  private $password;
  private $username;

  function __construct($name, $password){
    $this->username = $name;
    $this->password = $password;
  }

  public function invalidInput($repeat) : bool {
    return $this->usernameTooShort() || $this->passwordTooShort() 
    || $this->invalidCharacters()  || $this->passwordsDontMatch($repeat);
  }

  public function usernameTooShort() : bool {
    return strlen($this->username) < 3;
  }

  public function passwordTooShort() : bool {
    return strlen($this->password) < 6;
  }

  public function invalidCharacters() : bool {
    if(!empty($this->username)){
      return !ctype_alnum($this->username);
    }
  }
 
  public function passwordsDontMatch($repeatedPassword) : bool {
    return !($this->password === $repeatedPassword);
  }
}