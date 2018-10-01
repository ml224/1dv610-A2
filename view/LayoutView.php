<?php

require_once("DateTimeView.php");

class LayoutView {
  private $dateView;
  private $isLoggedIn;

  private static $register = "register";
  private static $logout = "logout";
  private static $newUser = "new_user";

  private static $relativeLogoutUrl = "?logout=true";
  private static $relativeRegisterUrl = "?register=true";
  
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
          
		          ' . $this->getLink($isLoggedIn) .'
              ' . $page . '
              
              ' . $this->dateView->show() . '
          </div>
         </body>
      </html>
    ';
  }

  private function loginMessage($isLoggedIn) {
    if ($isLoggedIn)
      return '<h2>Logged in</h2>';
    
    return '<h2>Not logged in</h2>';
  }

  private function getLink($isLoggedIn){
    if($this->registerViewRequested() && !$isLoggedIn)
      return '<a href="/">Back to login</a>';

    if(!$isLoggedIn)
      return '<a href="'. self::$relativeRegisterUrl .'">Register a new user</a>';
  } 

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
