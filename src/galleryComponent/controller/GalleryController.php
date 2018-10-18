<?php
require_once("../src/galleryComponent/view/GalleryView.php");
require_once("../src/galleryComponent/view/UploadView.php");
require_once("../src/galleryComponent/view/GalleryNavigationView.php");

require_once("../src/galleryComponent/model/Image.php");
require_once("../src/galleryComponent/model/GalleryDatabase.php");

class GalleryController{
    private $galleryView;
    private $navigationView;
    
    private $galleryModel;
    private $imageModel;
    private $galleryDatabase;

    private $isLoggedIn;

    function __construct($baseUrl, $db){
        $this->galleryView = new GalleryView();
        $this->navigationView = new GalleryNavigationView($baseUrl);
        $this->uploadView = new UploadView($this->navigationView);

        $this->db = new GalleryDatabase($db);

    }

    public function renderGalleryComponent() : string {    
        if($this->isLoggedIn){
            if($this->navigationView->errorLocation()){
                return $this->uploadView->renderErrorHtml();
            }
            if($this->navigationView->newFileLocation()){
                //TODO implement exception in case file does not exist
                return $this->uploadView->renderSuccessHtml();
            }
            if($this->galleryView->uploadRequested()){
                return $this->uploadView->uploadForm();
            }
            if($this->galleryView->deleteRequested()){
                //TODO implement delete functionality
                echo $this->galleryView->getImageId();
            } 
            if($this->uploadView->fileUploaded()){
                $this->trySaveFile();
            }
        }
        
        return $this->galleryView->renderGalleryView($this->isLoggedIn);
        
    }

    private function trySaveFile() : void {
        $image = new Image($this->uploadView->getFile());

        try{    
            $image->saveImage();
            $url = $this->navigationView->getImageUrl($image->getNewFileName());
            header('Location: ' . $url);
        }catch(Exception $e){
            $url = $this->uploadView->getErrorUrl($e->getMessage());
            header('Location: ' . $url);;
        }
    }
}