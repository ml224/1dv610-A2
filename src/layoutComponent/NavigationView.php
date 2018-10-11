<?php
class NavigationView{
    private $isDev;

    private static $register = "register";
    private static $logout = "logout";
    private static $newUser = "new_user";
    private static $gallery = "gallery";
  
    private static $relativeGalleryUrl = "?gallery=true";

    private $baseUrl;  
    private $newUserExtension = "/?new_user=";
    private $galleryExtension =  "/?gallery=";
  
    function __construct(){
      $this->isDev = $_ENV["CONFIG_ENV"] === "dev" ? true : false;
      $this->baseUrl = $this->isDev ? $_ENV["DEV_URL"] : $_ENV["PROD_URL"];
    }

    public function registerViewRequested(){
      return isset($_GET[self::$register]);
    }

    public function galleryViewRequested(){
      return isset($_GET[self::$gallery]);
    }

    public function userRegistered(){
      return isset($_GET[self::$newUser]);
    }

    public function getNewUsername(){
      return $_GET[self::$newUser];
    }

    public function redirectRegisteredUser($username){
      header('Location: ' . $this->newUserExtension . $username); 
    }

    public function isDev(){
      return $this->isDev;
    }
}