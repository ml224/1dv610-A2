<?php

class UploadView{
    private static $imageFile = "UploadView::ImageFile";
    
    public function uploadForm(){
        return '<form method="post" enctype="multipart/form-data" action="/">
                Select image to upload:
                <input type="file" name="'. self::$imageFile .'" id="'. self::$imageFile .'">
                <input type="submit" value="upload image" name="'. self::$imageFile .'">
                </form>';
        
    }

    public function noFileMessage(){
        return "Image not uploaded. No file chosen, image not uploaded";
    }

    public function invalidSizeMessage(){
        return "Image not uploaded. Invalid size. Image cannot exceed 2MB";
    } 

    public function invalidTypeMessage(){
        return "Image not uploaded. Invalid file type. File must be jpg/jpeg";
    }

    public function unknownErrorMessage(){
        return "Image not uploaded. Something went wrong";
    }
    
    public function getFilename(){
        return $_FILES[self::$imageFile]['name'];
    }
    
    public function getTmpName(){
        return $_FILES[self::$imageFile]['tmp_name'];
    }

    public function fileUploaded(){
        return isset($_POST[self::$imageFile]);
    }
}