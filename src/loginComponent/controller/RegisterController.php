<?php

require_once('../src/loginComponent/view/RegisterView.php');
require_once('../src/loginComponent/model/RegisterValidator.php');

class RegisterController{
    private $db;
    private $registerView;
    private $navigationView;
    private $validor;

    private $message = "";
    private $username;
    private $password;
    private $repeatPassword;

    function __construct(UserDatabase $db, LoginNavigationView $nav){
        $this->registerView = new RegisterView();
        $this->db = $db;
        $this->navigationView = $nav;
    }

    public function getPageContent() : string {
        if($this->registerView->registerRequested()){
            $this->setValidatorAndCredentials();
            $this->handleRegisterRequest();
        }

        return $this->registerView->renderRegisterForm($this->message);
    }

    private function setValidatorAndCredentials(): void {
        $this->username = $this->registerView->getUsername();
        $this->password = $this->registerView->getPassword();
        $this->repeatPassword = $this->registerView->getRepeatPassword();

        $this->validator = new RegisterValidator($this->username, $this->password);
    }

    private function handleRegisterRequest() : void {
        if($this->validator->invalidInput($this->repeatPassword)){
            $this->handleInvalidInput();
        }
        else {
            $this->tryRegister();
        }
    }

    private function handleInvalidInput() : void {
        $this->message = $this->registerView->getErrorsHtml($this->validator);
        if($this->validator->invalidInput($this->repeatPassword)){
            $this->registerView->stripUsername();
        }
    }

    private function tryRegister() : void {
        try{
            $this->db->registerUser($this->username, $this->password);
            $this->navigationView->redirectRegisteredUser($this->username);
        } catch(Exception $e){
            $this->message = $this->registerView->userExistsMessage();
        }
    }
}