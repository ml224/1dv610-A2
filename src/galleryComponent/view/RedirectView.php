<?php 

class RedirectView{
    private $navigationView;

    function __construct($nav){
        $this->navigationView = $nav;
    }
    
    public function renderErrorHtml() : string {
        return $this->navigationView->getErrorMessageFromUrl() . $this->redirectLink();
    }

    public function renderSuccessHtml() : string {
        return $this->successMessage() .'<br>'. $this->redirectLink() . '<br>' . $this->imageTag();      
    }

    public function renderDeleteHtml() : string {
         return $this->deleteMessage() . '<br>' . $this->redirectLink();
    }

    private function successMessage() : string {
        return "Image uploaded successfully!";
    }

    private function deleteMessage() : string {
        return "Image deleted successfully!";
    }

    private function redirectLink() : string {
        return '<br><a href="/">back to gallery</a>';
    }

    private function imageTag() : string {
        return '<img src="'. $this->navigationView->newImagePath() .'">';
    }
}