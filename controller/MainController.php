<?php
require_once("LoginController.php");
require_once("RegisterController.php");
require_once("view/LayoutView.php");
require_once("model/DataBase.php");
require_once("view/MessageView.php");

class MainController{

    private $loginController;
    private $registerController;
    private $layoutView;
    private $db;

    private $isLoggedIn;
    private $pageContent;

    function __construct(){
        $this->db = new DataBase();
        $this->loginController = new LoginController($this->db);
        $this->registerController = new RegisterController($this->db);
        $this->layoutView = new LayoutView();
    }

    public function renderLoginComponent(){
        if($this->layoutView->registerViewRequested()){
            $this->pageContent = $this->registerController->getPageContent($this->layoutView);
            $this->isLoggedIn = false;
        }
        else{
            $this->pageContent = $this->loginController->getPageContent($this->layoutView);
            $this->isLoggedIn = $this->loginController->userLoggedIn();
        }

        $this->layoutView->render($this->pageContent, $this->isLoggedIn);
    }

}