<?php
class NavigationView{
    private static $register = "register";
    private static $logout = "logout";
    private static $newUser = "new_user";
  
    private static $relativeLogoutUrl = "?logout=true";
    private static $relativeRegisterUrl = "?register=true";
    
    private $successUrl =  "http://localhost:8000/?new_user=";
  
    

  public function registerViewRequested(){
    return isset($_GET[self::$register]);
  }

  public function userRegistered(){
    return isset($_GET[self::$newUser]);
  }

  public function getNewUsername(){
    return $_GET[self::$newUser];
  }

  public function redirectRegisteredUser($username){
    header('Location: ' . $this->successUrl . $username); 
  }
}