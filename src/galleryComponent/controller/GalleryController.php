<?php
require_once("../src/galleryComponent/view/GalleryView.php");
require_once("../src/galleryComponent/model/Images.php");

class GalleryController{
    private $isLoggedIn;
    private $galleryView;
    private $imagesModel;

    function __construct($isLoggedIn){
        $this->isLoggedIn = $isLoggedIn;
        $this->galleryView = new GalleryView();
        $this->imagesModel = new Images();
    }

    public function renderGalleryComponent(){
        $images = $this->imagesModel->getAll();
        return $this->galleryView->renderImages($images);
    }

    
}