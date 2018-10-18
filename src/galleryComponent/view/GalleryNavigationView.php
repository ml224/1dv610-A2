<?php
class GalleryNavigationView{
    private $baseUrl;

    private static $newImage = 'new_image';
    private static $error = 'error_message';
    
    function __construct($baseUrl){
        $this->baseUrl = $baseUrl;
    }
    
    public function newFileLocation(){
        return isset($_GET[self::$newImage]);
    }
    
    public function errorLocation(){
        return isset($_GET[self::$error]);
    }

    public function newImagePath(){
        return "images/" . $_GET[self::$newImage];
    }  
        
    public function createErrorUrl($msg){
        $urlMessage = str_replace(' ', '_', $msg);
        return $this->baseUrl . '/?' . self::$error . '=' . $urlMessage;  
    }

    public function getErrorMessageFromUrl() : string {
        return str_replace('_', ' ', $_GET[self::$error]);
    }
        
    public function getImageUrl($newFileName){
        return $this->baseUrl . '?'. self::$newImage .'='. $newFileName;
    }   
}