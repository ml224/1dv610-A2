<?php
require_once("LoginController.php");
require_once("RegisterController.php");
require_once("view/LayoutView.php");
require_once("model/DataBase.php");

class MainController{

    private $loginController;
    private $registerController;
    private $layoutView;
    private $db;

    function __construct(){
        $this->db = new DataBase();
        $this->loginController = new LoginController($this->db);
        $this->registerController = new RegisterController($this->db);
        $this->layoutView = new LayoutView();
    }

    public function renderPage(){
        return $this->getPage();
    }

    public function getPage(){
        if($this->layoutView->registerViewRequested())
            return $this->registerController->renderRegisterPageWithLayout($this->layoutView);
        if($this->layoutView->logoutViewRequested())
            return $this->loginController->renderLogoutPageInLayout($this->layoutView); 
        else
            return $this->loginController->renderLoginPageInLayout($this->layoutView);  
    }
}