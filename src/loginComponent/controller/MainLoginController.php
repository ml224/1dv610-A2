<?php
require_once("LoginController.php");
require_once("RegisterController.php");
require_once("../src/loginComponent/model/UserDatabase.php");
require_once("../src/loginComponent/view/LoginNavigationView.php");

class MainLoginController{

    private $loginController;
    private $registerController;
    private $navigationView;
    private $db;

    private $isLoggedIn;
    private $pageContent;

    function __construct($baseUrl, $mysqli){
        $this->navigationView = new LoginNavigationView($baseUrl);
        
        
        $db = new UserDatabase($mysqli);
        $this->loginController = new LoginController($db);
        $this->registerController = new RegisterController($db, $this->navigationView);
    }

    public function isLoggedIn(){
        return $this->loginController->userLoggedIn();
    }

    public function renderLoginComponent(){
        if($this->navigationView->registerViewRequested())
            return $this->registerController->getPageContent();
        
        return $this->loginController->getPageContent($this->navigationView);
    }

}