<?php


class LayoutView {

  private $isLoggedIn;
  private $loginView;

  public function LayoutView(bool $isLoggedIn){
    $this->isLoggedIn = $isLoggedIn;
  }
  
  public function render(LoginView $v, DateTimeView $dtv) {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Assignment</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->renderIsLoggedIn($this->isLoggedIn) . '
          
          <div class="container">
              ' . $v->render($this->isLoggedIn) . '
              
              ' . $dtv->show() . '
          </div>
         </body>
      </html>
    ';
  }
  
  private function renderIsLoggedIn($isLoggedIn) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }
}
