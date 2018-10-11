<?php
require_once("loginComponent/controller/MainLoginController.php");
require_once("galleryComponent/controller/GalleryController.php");

require_once("layoutComponent/LayoutView.php");
require_once("layoutComponent/NavigationView.php");

class AppController{
    private $layout;
    private $mainLoginController;

    function __construct(){
        $this->layout = new LayoutView();
        $this->mainLoginController = new MainLoginController(new NavigationView());
        $this->galleryController = new GalleryController();
    }

    public function echoPage(){
        $loginComponent = $this->mainLoginController->renderLoginComponent();
        $galleryComponent = $this->galleryController->renderGalleryComponent($this->mainLoginController->isLoggedIn());
        
        return $this->layout->echoPage($loginComponent, $galleryComponent);
    }
}