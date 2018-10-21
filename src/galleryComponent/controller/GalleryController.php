<?php
require_once("../src/galleryComponent/view/GalleryView.php");
require_once("../src/galleryComponent/view/UploadView.php");
require_once("../src/galleryComponent/view/RedirectView.php");
require_once("../src/galleryComponent/view/GalleryNavigationView.php");
require_once("../src/galleryComponent/model/File.php");
require_once("../src/galleryComponent/model/Gallery.php");

class GalleryController{
    private $galleryView;
    private $navigationView;
    private $gallery;

    private $pageContent;

    function __construct($baseUrl){
        $this->galleryView = new GalleryView();
        $this->navigationView = new GalleryNavigationView($baseUrl);
        $this->uploadView = new UploadView();
        $this->redirectView = new RedirectView($this->navigationView);
        $this->gallery = new Gallery($this->navigationView);
    }

    public function renderGalleryComponent($isLoggedIn) : string {
        if($isLoggedIn){
            $this->handleLoggedInUsers();
        }
        if(!$this->pageContent){
            $this->pageContent = $this->galleryView->renderGalleryView($isLoggedIn, $this->navigationView);
        }
        
        return $this->pageContent;
    }

    private function handleLoggedInUsers() : void {
        if($this->navigationView->errorLocation()){
            $this->pageContent = $this->redirectView->renderErrorHtml();
        }
        if($this->navigationView->newFileLocation()){
            $this->pageContent = $this->redirectView->renderSuccessHtml();
        }
        if($this->galleryView->uploadRequested()){
            $this->pageContent = $this->uploadView->uploadForm();
        }
        if($this->galleryView->deleteRequested()){
            $this->deleteFile();
        }
        if($this->navigationView->deleteLocation()){
            $this->pageContent = $this->redirectView->renderDeleteHtml();
        } 
        if($this->uploadView->fileUploaded()){
            $this->trySaveFile();
        }
    }

    private function deleteFile() : void{
        $filename = $this->galleryView->getFilename();
        try{
            $this->gallery->deleteFile($filename);
            $url = $this->navigationView->getDeleteUrl($filename);
            header('Location: ' . $url);
        }
        catch(Exception $e){
            //TODO implement! Not throwing an exception currently...
            echo $e->getMessage();
        }
    }

    private function trySaveFile() : void {
        $file = new File($this->uploadView->getFilename(), $this->uploadView->getTmpName());

        try{    
            $file->saveFile();
            //TODO add to DB once functionality to get current user is implemented

            $url = $this->navigationView->getImageUrl($file->getNewFilename());
            header('Location: ' . $url);
        }
        catch(InvalidArgumentException $e){
            $msg = $this->uploadView->noFileMessage();
            $url = $this->navigationView->getErrorUrl($msg);
            header('Location: ' . $url);
        }
        catch(UnderflowException $e){
            $msg = $this->uploadView->invalidSizeMessage();
            $url = $this->navigationView->getErrorUrl($msg);
            header('Location: ' . $url);
        }
        catch(DomainException $e){
            $msg = $this->uploadView->invalidTypeMessage();
            $url = $this->navigationView->getErrorUrl($msg);
            header('Location: ' . $url);
        }
        catch(Exception $e){
            $msg = $this->uploadView->unknownErrorMessage();
            $url = $this->navigationView->getErrorUrl($msg);
            header('Location: ' . $url);
        }
    }
}