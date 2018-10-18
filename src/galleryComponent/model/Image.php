<?php

class Image{
    private static $imageStored = "Image::ImageStored";

    private $file;
    private $fileName;
    private $newFileName;
    private $fileSize;
    private $tmpName;


    function __construct($file){
        $this->fileName = $file['name'];
        $this->fileSize = $file['size'];
        $this->tmpName = $file['tmp_name'];
    }

    public function saveImage() : void {         
            $this->throwExceptionIfInvalid();

            $this->newFileName = $this->createNewName();
            $newImagePath = "images/" . $this->newFileName;

            if(move_uploaded_file($this->tmpName, $newImagePath)){
                $this->resizeImage($newImagePath);
            } else{
                throw new Exception("unknown error");
            }
    }

    private function throwExceptionIfInvalid(){
        //TODO create own error types instead of 
        //relying on messages?
        if(!$this->fileName){
            throw new Exception("no file");
        }
        if($this->invalidSize()){
            throw new Exception("invalid size");
        }
        if($this->invalidFileType()){
            throw new Exception("invalid file type");
        }
    }

    private function invalidSize(){
        //img not saved in tmp if too large, therefor size 0
        return $this->fileSize === 0;
    }

    private function invalidFileType(){
        $fileType = getimagesize($this->tmpName)['mime'];
        return $fileType !== "image/jpeg";
    }

    private function createNewName(){
        $temp = explode(".", $this->fileName);
        return round(microtime(true)) . '.' . end($temp);
    }

    private function resizeImage($filePath){
    //TODO: IMPLEMENT! 
    }

    public function getNewFileName(){
        return $this->newFileName;
    }
}