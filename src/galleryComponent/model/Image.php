<?php

class Image{
    private static $imageUploaded = "Image::ImageUploaded";

    private $fileName;
    private $fileSize;
    private $tmpName;

    function __construct($file){
        $this->fileName = $file['name'];
        $this->fileSize = $file['size'];
        $this->tmpName = $file['tmp_name'];
    }

    public function saveImage(){
        $this->setImageSession();

        //TODO check to see if you can create your own error types instead of 
        //relying on messagess
        if($this->invalidFileType()){
            throw new Exception("invalid file type");
        } 
        if($this->invalidSize()){
            throw new Exception("invalid size");
        }
        else{
            $targetPath = "images/" . basename($this->fileName);

            if(!move_uploaded_file($this->tmpName, $targetPath)){
                throw new Exception("unknown error");
            }
        }
    }

    public function fileSessionSet($fileName){
        $currentSession = $_SESSION[self::$imageUploaded];
        
        if(isset($currentSession)){
            return $currentSession === $fileName;
        }
    }

    public function invalidFileType(){
        //TODO: add functionality to test if jpg/jpeg
        return false;
    }

    public function invalidSize(){
        //img not saved in tmp if too large, therefor size 0
        return $this->fileSize === 0;
    }

    private function setImageSession(){
        echo $this->fileName;
        $_SESSION[self::$imageUploaded] = $this->fileName;
    }
}