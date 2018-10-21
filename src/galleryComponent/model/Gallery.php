<?php

class Gallery{    
    private $pathToImages;

    function __construct($nav){
        $this->pathToImages = $nav->pathToImages();
    }

    public function getImages() : array {
        return array_diff(scandir($this->pathToImages), array('..', '.'));
    }

    public function getUserImages($user){
        //TODO add functionality to look for users images in db
        //compare db result with file names in getAll
    }

    public function deleteFile($filename) : void {
        //TODO add error handling functionality
        unlink( $this->pathToImages . "/" . $filename);
    }

}