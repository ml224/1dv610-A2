<?php

require_once('view/LayoutView.php');
require_once('view/DateTimeView.php');
require_once('view/LoginView.php');
require_once('view/RegisterUserView.php');
require_once('view/LoginMessage.php');

require_once("model/ValidateInput.php");

require_once('UserSessionController.php');

session_start();


class LoginController
{
    //constructors
    //view
    private $loginView;
    private $dateView;
    private $loginMessage;

    //model
    private $validateInput;
    
    //controller
    private $userStorage;

    private $username;
    private $password;
    private $returnWelcome;
    private $returnBye;

    function __construct(){
        $this->loginView = new LoginView();
        $this->dateView = new DateTimeView();
        $this->validator = new ValidateInput();
        $this->loginMessage = new LoginMessage();
        $this->userStorage = new UserSessionController();
        
        $this->username = $this->loginView->getRequestUsername();
        $this->password = $this->loginView->getRequestPassword();
    }

    public function renderPage(){
        if($this->nameAndPasswordProvided()){
            $this->userStorage->setUser($this->username, $this->password);

            if(!$this->userStorage->isLoggedIn() && $this->userStorage->credentialsCorrect()){
                $this->userStorage->logIn();
                $this->returnWelcome = true;
            }
        }

        if($this->loginView->logoutRequested()){
            $this->userStorage->logOut();
            $this->returnBye = true;
            
        }

        $layout = new LayoutView($this->userStorage->isLoggedIn()); 
        $layout->render($this->loginView, $this->dateView, $this->loginMessage());
    }

    private function loginMessage(){
        //user storage class handles db requests, e.g. for wrong username/psw
        if($this->returnWelcome){
            return $this->loginMessage->welcome();
        }
        if($this->returnBye){
            return $this->loginMessage->bye();
        }
        
        if($this->loginView->loginAttempted()){
            if($this->validator->usernameMissing($this->username)){
                return $this->loginMessage->usernameMissing();
            }
            if($this->validator->passwordMissing($this->password)){
                return $this->loginMessage->passwordMissing();
            }
            
            if($this->userStorage->userSet() && $this->userStorage->passwordOrNameIncorrect()){
                return $this->loginMessage->wrongNameOrPassword();
            }
        } else{
            return "";
        }
    }

    private function nameAndPasswordProvided(){
        return $this->username && $this->password;
    }

}


    /*private function registerUser(){   
        if($this->username && $this->password){
            $this->db->registerUser($this->username, $this->password);
        } 
    }*/

    //$this->registerView = new RegisterUserView();