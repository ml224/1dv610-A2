<?php 

class RedirectView{
    private $navigationView;

    function __construct($nav){
        $this->navigationView = $nav;
    }
    
    public function renderErrorHtml() : string{
        return $this->navigationView->getErrorMessageFromUrl() . $this->redirectLink();
    }

    public function renderSuccessHtml(){
        return $this->successMessage() .'<br>'. $this->redirectLink() . '<br>' . $this->imageTag();      
    }

    public function renderDeleteHtml(){
         return $this->deleteMessage() . '<br>' . $this->redirectLink();
    }

    private function successMessage(){
        return "Image uploaded successfully!";
    }

    private function deleteMessage(){
        return "Image deleted successfully!";
    }

    private function redirectLink(){
        return '<br><a href="/">back to gallery</a>';
    }

    private function imageTag(){
        return '<img src="'. $this->navigationView->newImagePath() .'">';
    }
}