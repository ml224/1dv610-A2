<?php
require_once("Image.php");

class Gallery{    
    public function getImages(){
        return array_diff(scandir("images"), array('..', '.'));
    }

    public function getUserImages($user){
        //TODO add functionality to look for users images in db
        //compare db result with file names in getAll
    }

}