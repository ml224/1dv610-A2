<?php

class File{
    private static $imageStored = "Image::ImageStored";

    private $filename;
    private $tmp_name;
    private $newFilename;
    private $fileId;


    function __construct($filename, $tmp){
        $this->filename = $filename;
        $this->tmp_name = $tmp;
    }

    public function saveFile() : void {         
            $this->throwExceptionIfInvalid();

            $this->fileId = $this->newId();
            $this->newFilename = $this->createNewFileName($this->fileId);
            $path = "images/" . $this->newFilename;

            if(move_uploaded_file($this->tmp_name, $path)){
                $this->resizeImage($path);
            } else{
                throw new Exception("unknown error");
            }
    }

    private function throwExceptionIfInvalid(){
        if(!$this->filename){
            throw new InvalidArgumentException("No file received");
        }
        if(!$this->tmp_name){ //img not saved in tmp if too large
            throw new UnderflowException("Invalid file size, file not received");
        }
        if($this->invalidFileType()){
            throw new DomainException("invalid file type");
        }
    }

    private function invalidFileType(){
        $fileType = getimagesize($this->tmp_name)['mime'];
        return $fileType !== "image/jpeg";
    }

    private function newId(){
        return round(microtime(true));
    }

    private function createNewFileName($name){
        $temp = explode(".", $this->filename);
        return $name . '.' . end($temp);
    }

    private function resizeImage($filePath){
    //TODO: IMPLEMENT! 
    }

    public function getNewFilename(){
        return $this->newFilename;
    }
}