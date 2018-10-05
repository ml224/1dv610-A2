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
        <body>
          <h1>Assignment 2</h1>
    
          <div class="container">
    
             ' . $pageContent . '
              
              <div id="footer">
              ' . $this->dateView->show() . '
              </div>
          </div>
         </body>
      </html>
    ';
  }
}
