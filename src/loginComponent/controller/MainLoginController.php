<?php
require_once("LoginController.php");
require_once("RegisterController.php");
require_once("../src/loginComponent/model/UserDatabase.php");
require_once("../src/loginComponent/view/LoginNavigationView.php");

class MainLoginController{

    private $loginController;
    private $registerController;
    private $navigationView;

    function __construct($baseUrl, $mysqli){
        $this->navigationView = new LoginNavigationView($baseUrl);
        
        $db = new UserDatabase($mysqli);
        $this->loginController = new LoginController($db);
        $this->registerController = new RegisterController($db, $this->navigationView);
    }

    public function renderLoginComponent() : string {
        if($this->navigationView->registerViewRequested()){
            return $this->registerController->getPageContent();
        } else{
            return $this->loginController->getPageContent($this->navigationView);
        }
    }
    
    //used by gallery component
    public function isLoggedIn() : bool {
        return $this->loginController->userLoggedIn();
    }
}