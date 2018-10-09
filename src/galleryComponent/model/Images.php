<?php
class Images{
    
    public function getAll(){
        return array_diff(scandir("images"), array('..', '.'));
    }
}