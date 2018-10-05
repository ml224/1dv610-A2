<?php
require_once("LoginController.php");
require_once("RegisterController.php");
require_once("model/login/DataBase.php");
require_once("view/login/NavigationView.php");
require_once("view/login/LayoutView.php");

class MainController{

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
        $this->layoutView = new LayoutView();
    }

    public function renderLoginComponent(){
        if($this->navigationView->registerViewRequested()){
            $this->pageContent = $this->registerController->getPageContent($this->navigationView);
            $this->isLoggedIn = false;
        }
        else{
            $this->pageContent = $this->loginController->getPageContent($this->navigationView);
            $this->isLoggedIn = $this->loginController->userLoggedIn();
        }

        $this->layoutView->render($this->pageContent, $this->isLoggedIn);
    }

}