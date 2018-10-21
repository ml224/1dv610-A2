<?php
require_once("../src/galleryComponent/model/Gallery.php");


class GalleryView{
    private static $uploadRequest = 'GalleryView::UploadRequest';
    private static $imageUploaded = 'GalleryView::ImageUploaded';
    private static $imageFile = "GalleryView::ImageFile";
    private static $delete = "GalleryView::Delete";
    private static $fileName = "GalleryView::FileName";

    private $navigationView;
    private $isLoggedIn;

    public function renderGalleryView($isLoggedIn, GalleryNavigationView $nav) : string {
        $this->isLoggedIn = $isLoggedIn;
        $this->navigationView = $nav;

        $gallery = new Gallery($nav);
        $images = $gallery->getImages();        

        $html = $this->uploadOptions();
        foreach($images as $image){
            $html .= $this->imageHtml($image);
        }
        return $html;
    }

    private function uploadOptions() : string {
        if($this->isLoggedIn){
            return '	
            <hr>
            <form  method="post" >
                <input type="submit" name="' . self::$uploadRequest . '" value="upload"/>
            </form>';
        } else{
            return "";
        }
    }

    private function imageHtml($image) : string {
        $imgTag = $this->imageTag($image);
        if($this->isLoggedIn){
            return '<div class="image-wrapper">' . $imgTag .'<br>'. $this->deleteButton($image) .'</div>'; 
        } else{
            return $imgTag;
        }
    }

    private function imageTag($image) : string {
        $imgPath = $this->navigationView->getImagePath($image);
        return '<img src="'. $imgPath .'">';
    }

    private function deleteButton($image) : string {
        return '
        <form method="post">
            <input type="hidden" name="'. self::$fileName .'" value="'. $image .'"/>
            <input type="submit" name="'. self::$delete .'" value="delete"/> 
        </form>
        ';
    }

    public function uploadRequested() : bool {
        return isset($_POST[self::$uploadRequest]);
    }

    public function deleteRequested() : bool {
        return isset($_POST[self::$delete]);
    }

    public function getFilename() : string {
        return $_POST[self::$fileName];
    }
}