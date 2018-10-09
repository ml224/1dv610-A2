<?php

class GalleryView{

    public function renderImages($images){
        $imagesHtml = "";
        foreach($images as $image){
            $imagesHtml .= '<img src="images/' . $image .'">';
        }

        return $imagesHtml;
    }

    public function uploadButton(){
        return '
        <button type="button"> upload image </button>
        ';
    }

    public function deleteButton(){
        return '
        <button type="button"> delete image </button>
        ';
    }


}