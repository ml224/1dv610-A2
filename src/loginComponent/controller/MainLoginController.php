<?php
require_once("LoginController.php");
require_once("RegisterController.php");
require_once("../src/loginComponent/model/DataBase.php");

class MainLoginController{

    private $loginController;
    private $registerController;
    private $layoutView;
    private $db;
    private $navigationView;

    private $isLoggedIn;
    private $pageContent;

    function __construct($navigationView){
        $this->navigationView = $navigationView;
        $this->db = new DataBase($navigationView->isDev());

        $this->loginController = new LoginController($this->db, $navigationView);
        $this->registerController = new RegisterController($this->db, $navigationView);
    }

    public function isLoggedIn(){
        return $this->loginController->userLoggedIn();
    }

    public function renderLoginComponent(){
        if($this->navigationView->registerViewRequested())
            return $this->registerController->getPageContent();
        
        return $this->loginController->getPageContent();
    }

}