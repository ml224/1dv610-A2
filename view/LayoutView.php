<?php


class LayoutView {

  private $isLoggedIn;

  public function LayoutView($isLoggedIn){
    $this->isLoggedIn = $isLoggedIn;
  }
  
  public function render(LoginView $loginView, DateTimeView $dtv, $message) {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Assignment</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->loginMessage($this->isLoggedIn) . '
          
          <div class="container">
              ' . $loginView->render($this->isLoggedIn, $message) . '
              
              ' . $dtv->show() . '
          </div>
         </body>
      </html>
    ';
  }
  
  private function loginMessage() {
    if ($this->isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }
}
