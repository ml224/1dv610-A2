<?php

require_once("../src/galleryComponent/model/Image.php");

class UploadView{
    private static $imageFile = "UploadView::ImageFile";
    
    private $navigationView;

    function __construct($nav){
        $this->navigationView = $nav;
    }
    
    public function uploadForm(){
        return '<form method="post" enctype="multipart/form-data" action="/">
                Select image to upload:
                <input type="file" name="'. self::$imageFile .'" id="'. self::$imageFile .'">
                <input type="submit" value="upload image" name="'. self::$imageFile .'">
                </form>';
        
    }

    public function renderErrorHtml() : string{
        return $this->navigationView->getErrorMessageFromUrl() . $this->redirectLink();
    }

    public function renderSuccessHtml(){
        return $this->successMessage() . $this->redirectLink() . '<br>' . $this->imageTag();      
    }

    private function successMessage(){
        return "Image uploaded successfully!";
    }

    private function redirectLink(){
        return '<a href="/">back to gallery</a>';
    }

    private function imageTag(){
        return '<img src="'. $this->navigationView->newImagePath() .'">';
    }

    public function getErrorUrl($exceptionMessage){
        $urlMessage = $this->getErrorMessage($exceptionMessage);
        return $this->navigationView->createErrorUrl($urlMessage);
    }

    private function getErrorMessage($exceptionMessage){
        switch($exceptionMessage){
            case "request already processed":
                return "";
            case "no file":
                return "Image not uploaded. No file chosen, image not uploaded";
            case "invalid file type":
                return "Image not uploaded. Invalid file type. File must be jpg/jpeg";
            break;
            case "invalid size":
                return "Image not uploaded. Invalid size. Image cannot exceed 2MB";
            break;
            case "unknown error":
                return "Image not uploaded. Something went wrong";
            break;
        }
    }
    
    public function getFile(){
        if($this->fileUploaded()){
            return $_FILES[self::$imageFile];
        } else{
            throw new Exception("No file uploaded!");
        }
    }
    public function fileUploaded(){
        return isset($_POST[self::$imageFile]);
    }
}