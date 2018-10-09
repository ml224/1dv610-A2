<?php

require_once("DateTimeView.php");

class LayoutView {
  private $dateView;

  function __construct(){
    $this->dateView = new DateTimeView();
  }
  
  public function echoPage($loginComponent, $galleryComponent) {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <link rel="stylesheet" type="text/css" href="/css/style.css" />
          <meta charset="utf-8">
          <title>Login Assignment</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          <div class="container">
            <div class="login-component">
             ' . $loginComponent . '
            </div>
            <div class="gallery-component">
            ' . $galleryComponent . '
            </div>
            <div id="footer">
            <hr>
              ' . $this->dateView->show() . '
            </div>
          </div>
         </body>
      </html>
    ';
  }
}
