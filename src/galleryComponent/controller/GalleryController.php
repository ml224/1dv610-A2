<?php
require_once("../src/galleryComponent/view/GalleryView.php");

class GalleryController{
    private $galleryView;
    private $imagesModel;

    function __construct(){
        $this->galleryView = new GalleryView();
    }

    public function renderGalleryComponent($isLoggedIn){
        return $this->galleryView->renderGalleryView($isLoggedIn);
    }

    
}