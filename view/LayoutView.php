<?php

require_once("DateTimeView.php");

class LayoutView {
  private $dateView;
  private $isLoggedIn;

  private static $register = "register";
  private static $logout = "logout";
  private static $success = "new_user";

  private static $logoutUrl = "?logout=true";
  private static $registerUrl = "?register=true";
  private static $backToLoginUrl = "/";
  
  private $baseUrl = "http://localhost:8000";
  private $successUrl =  "http://localhost:8000/?new_user=";


  function __construct(){
    $this->dateView = new DateTimeView();
  }
  
  public function render($page, $isLoggedIn) {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Assignment</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          '.$this->loginMessage($isLoggedIn).'
          
          <div class="container">
          
		          ' . $this->registerLink($isLoggedIn) .'
              ' . $page . '
              
              ' . $this->dateView->show() . '
          </div>
         </body>
      </html>
    ';
  }

  public function registerViewRequested(){
    return isset($_GET[self::$register]);
  }

  public function loginViewRequested(){
    return isset($_GET);
  }

  public function successfulRegistration(){
    return isset($_GET[self::$success]);
  }

  public function getNewUsername(){
    return $_GET[self::$success];
  }

  public function getSuccessUrl(){
    return $this->successUrl;
  }


  private function registerLink($isLoggedIn){
    if($this->registerViewRequested() && !$isLoggedIn)
      return '<a href="'. self::$backToLoginUrl .'">Back to login</a>';
    if($this->loginViewRequested() && !$isLoggedIn)
      return '<a href="'. self::$registerUrl .'">Register a new user</a>';
  } 
  
  private function loginMessage($isLoggedIn) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }
}
