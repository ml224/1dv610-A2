<?php
require_once("login/MainLoginController.php");
require_once("views/LayoutView.php");

class AppController{
    private $layout;
    private $mainLoginController;

    function __construct(){
        $this->layout = new LayoutView();
        $this->mainLoginController = new MainLoginController();
    }

    public function echoPage(){
        $bodyContent = $this->mainLoginController->renderLoginComponent();
        return $this->layout->echoPage($bodyContent);
    }
}