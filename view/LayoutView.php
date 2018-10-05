<?php

require_once("DateTimeView.php");

class LayoutView {
  private $dateView;

  function __construct(){
    $this->dateView = new DateTimeView();
  }
  
  public function render($pageContent, $isLoggedIn) {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Assignment</title>
        </head>
          <h1>Assignment 2</h1>
          '.$this->loginMessage($isLoggedIn).'
          
          <div class="container">
          
             ' . $pageContent . '
              
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
}
