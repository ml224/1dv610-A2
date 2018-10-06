<?php
require_once("LoginController.php");
require_once("RegisterController.php");
require_once("models/login/DataBase.php");
require_once("views/login/NavigationView.php");

class MainLoginController{

    private $loginController;
    private $registerController;
    private $layoutView;
    private $db;
    private $navigationView;

    private $isLoggedIn;
    private $pageContent;

    function __construct(){
        $this->db = new DataBase();
        $this->navigationView = new NavigationView();

        $this->loginController = new LoginController($this->db, $this->navigationView);
        $this->registerController = new RegisterController($this->db, $this->navigationView);
    }

    public function renderLoginComponent(){
        if($this->navigationView->registerViewRequested())
            return $this->registerController->getPageContent();
        
        return $this->loginController->getPageContent();
    }

}