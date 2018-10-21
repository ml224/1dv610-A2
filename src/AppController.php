<?php
require_once("loginComponent/controller/MainLoginController.php");
require_once("galleryComponent/controller/GalleryController.php");
require_once("DatabaseInitiator.php");

require_once("layoutComponent/LayoutView.php");

class AppController{
    public function echoPage() : string {
        $layout = new LayoutView();
        $dbInitiator = new DatabaseInitiator($this->isDev());
        
        
        //initiating DB connection in root 
        //intending to add db functionality in Gallery component using same DB
        $mysqliConnection = $dbInitiator->getMysqli();
        $baseUrl = $this->getEnvUrl();
        $loginController = new MainLoginController($baseUrl, $mysqliConnection);
        $galleryController = new GalleryController($baseUrl);
        
        $loginComponent = $loginController->renderLoginComponent();
        $galleryComponent = $galleryController->renderGalleryComponent($loginController->isLoggedIn());
        
        return $layout->echoPage($loginComponent, $galleryComponent) || "";
    }

    private function getEnvUrl() : string {
        return $this->isDev() ? $_ENV["DEV_URL"] : $_ENV["PROD_URL"];
    }

    private function isDev() : bool {
        return $_ENV["CONFIG_ENV"] === "dev";
    }
}