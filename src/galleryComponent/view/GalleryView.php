<?php

require_once("../src/galleryComponent/model/Images.php");
require_once("../src/galleryComponent/model/Image.php");

class GalleryView{
    private $images;
    private $message;

    private static $uploadRequest = 'GalleryView::UploadRequest';
    private static $imageUploaded = 'GalleryView::ImageUploaded';
    private static $image = 'GalleryView::Image';

    function __construct(){
        $this->images = new Images();
    }

    public function renderGalleryView($isLoggedIn){
        if(!$isLoggedIn){
            return $this->renderImages();
        } else{
            return $this->renderImagesWithOptions();
        }
    }

    private function renderImages(){
        $imagesHtml = "";
        foreach($this->images->getAll() as $image){
            $imagesHtml .= $this->imageTag($image);
        }

        return $imagesHtml;
    }    

    private function renderImagesWithOptions(){
        if($this->uploadRequested()){
            return $this->uploadForm();
        } else{
            $this->trySaveFile();

            $imagesHtml = '<hr>' . $this->uploadButton() . '<div id="message">'. $this->message .'</div>';

            foreach($this->images->getAll() as $image){
                $imagesHtml .= '<div class="image-wrapper">' . $this->imageTag($image) .'<br>'. $this->deleteButton($image) .'</div>';
             }

            return $imagesHtml;
        }
    }

    private function uploadButton(){
        return '	
        <form  method="post" >
            <input type="submit" name="' . self::$uploadRequest . '" value="upload"/>
        </form>
    ';
    }

    private function imageTag($image){
        return '<img id="'. $image .'" src="images/' . $image .'">';
    }

    private function uploadRequested(){
        return isset($_POST[self::$uploadRequest]);
    }

    private function uploadForm(){
        return '<form method="post" enctype="multipart/form-data" action="/">
                    Select image to upload:
                    <input type="file" name="'. self::$image .'" id="'. self::$image .'">
                    <input type="submit" value="Upload Image" name="'. self::$imageUploaded .'">
                </form>';
    }

    private function deleteButton($image){
        return '
        <button type="button" class="delete" id="'. $image .'"> delete image </button>
        ';
    }

    private function imageSent(){
        return isset($_POST[self::$imageUploaded]);
    }

    private function trySaveFile(){
        if($this->imageSent()){
            $formImage = $_FILES[self::$image];
            $image = new Image($formImage);       
            $newImageRequest = $image->fileSessionSet($formImage['name']) ? false : true;

            if($newImageRequest){
                try{
                    $image->saveImage();
                    $this->message = "image uploaded!";
                 
                } catch(Exception $e){
                    $this->message = $this->getErrorMessage($e->getMessage());
                }
            } 
        }
    }

    private function getErrorMessage($exceptionMessage){
        switch($exceptionMessage){
            case "invalid file type":
                return "Invalid file type. File must be jpg/jpeg";
            break;
            case "invalid size":
                return "Invalid size. Image cannot exceed 2MB";
            break;
            case "unknown error":
                return "Something went wrong";
            break;
        }
    } 
    
}