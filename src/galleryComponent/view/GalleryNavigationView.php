<?php
class GalleryNavigationView{
    private static $newImage = 'new_image';
    private static $error = 'error_message';
    private static $delete = 'delete_image';

    private $baseUrl;    
    private $imagePath = "images";

    
    function __construct($baseUrl){
        $this->baseUrl = $baseUrl;
    }

    public function getImageUrl($newFileName) : string {
        return $this->baseUrl . '?'. self::$newImage .'='. $newFileName;
    }
    
    public function getDeleteUrl($filename){
        return $this->baseUrl . '?' . self::$delete . '=' . $filename;    
    }

    public function getErrorUrl($msg) : string {
        $urlMessage = str_replace(' ', '_', $msg);
        return $this->baseUrl . '/?' . self::$error . '=' . $urlMessage;  
    }

    public function getErrorMessageFromUrl() : string {
        return str_replace('_', ' ', $_GET[self::$error]);
    }

    public function newImagePath() : string {
        return $this->imagePath . '/' . $_GET[self::$newImage];
    }  
        
    public function getImagePath($filename) : string {
        return $this->imagePath . '/' . $filename; 
    }
    
    public function newFileLocation() : bool {
        return isset($_GET[self::$newImage]);
    }
    
    public function errorLocation() : bool {
        return isset($_GET[self::$error]);
    }

    public function deleteLocation() : bool {
        return isset($_GET[self::$delete]);
    }

    public function pathToImages(){
        return $this->imagePath;
    }
}