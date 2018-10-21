<?php

class LoginNavigationView{
    private $isDev;

    private static $register = "register";
    private static $logout = "logout";
    private static $newUser = "new_user";

    private $baseUrl;  
  
    function __construct($baseUrl){
      $this->baseUrl = $baseUrl;
    }

    public function registerViewRequested(){
      return isset($_GET[self::$register]);
    }

    public function userRegistered(){
      return isset($_GET[self::$newUser]);
    }

    public function getNewUsernameFromUrl(){
      return $_GET[self::$newUser];
    }

    public function redirectRegisteredUser($username){
      header('Location: ' . $this->baseUrl . '/?' . self::$newUser . '=' . $username); 
    }
}