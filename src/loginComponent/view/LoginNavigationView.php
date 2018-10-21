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

    public function registerViewRequested() : bool {
      return isset($_GET[self::$register]);
    }

    public function userRegistered() : bool {
      return isset($_GET[self::$newUser]);
    }

    public function getNewUsernameFromUrl() : string {
      return $_GET[self::$newUser];
    }

    public function redirectRegisteredUser($username) : void {
      header('Location: ' . $this->baseUrl . '/?' . self::$newUser . '=' . $username); 
    }
}