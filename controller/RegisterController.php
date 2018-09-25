<?php

require_once('view/RegisterView.php');
require_once('model/DataBase.php');

class RegisterController{
    private $registerView;
    private $newUserName;
    private $newUserPassword;
    private $failOrSuccessMessage;
    private $db;

    function __construct(DataBase $db){
        $this->registerView = new RegisterView();
        $this->db = $db;
        if($this->registerView->registerNewUserRequested()){
            $this->newUserName = $this->registerView->getUsername();
            $this->newUserPassword = $this->registerView->getPassword();
        }
    }

    public function renderRegisterPageWithLayout(LayoutView $layout){
        if($this->registerView->registerNewUserRequested()){
              if($this->invalidInput()){
                $this->failOrSuccessMessage = $this->getMessage();
              }
              else {
                $this->db->registerUser($this->newUserName, $this->newUserPassword);
                $this->failOrSuccessMessage = "Success!";
              }
        }
            
        return $layout->render($this->registerView->render($this->failOrSuccessMessage), false);
    }

    private function invalidInput(){
        return $this->passwordsDontMatch() || $this->usernameTooShort() || $this->passwordTooShort();
    }

    private function getMessage(){
        if($this->passwordsDontMatch())
            return "Passwords do not match.";
        
        if($this->usernameTooShort())
            return "Username has too few characters, at least 3 characters.";                    
            
        if($this->passwordTooShort())
            return "Password has too few characters, at least 6 characters.";                    
    }

    private function passwordsDontMatch(){
        return !($this->registerView->getPassword() === $this->registerView->getRepeatPassword());
    }

    private function usernameTooShort(){
        return strlen($this->newUserName) < 3;
    }
    private function passwordTooShort(){
        return strlen($this->newUserPassword) < 6;
    }
}