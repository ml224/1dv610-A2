<?php
require_once("loginComponent/controller/MainLoginController.php");
require_once("galleryComponent/controller/GalleryController.php");

require_once("layoutComponent/LayoutView.php");
require_once("layoutComponent/NavigationView.php");

class AppController{
    private $layout;
    private $mainLoginController;
    private $galleryController;

    function __construct(){
        $this->navigationView = new NavigationView();
        $this->layout = new LayoutView();
        $this->mainLoginController = new MainLoginController($this->navigationView);
        $this->galleryController = new GalleryController($this->mainLoginController->isLoggedIn());
        
    }

    public function echoPage(){
        $loginComponent = $this->mainLoginController->renderLoginComponent();
        $gallery = $this->galleryController->renderGalleryComponent();
        return $this->layout->echoPage($loginComponent, $gallery);
    }
}