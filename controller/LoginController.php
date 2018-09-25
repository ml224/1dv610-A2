<?php

require_once('view/LayoutView.php');
require_once('view/LoginView.php');
require_once('view/LoginMessage.php');

require_once("model/ValidateInput.php");

require_once('UserSessionController.php');

session_start();


class LoginController
{
    //constructors
    //view
    private $loginView;
    private $loginMessageView;

    //model
    private $validateInput;
    
    //controller
    private $userStorage;

    private $username;
    private $password;
    private $loginMessage;

    private static $message = "LoginController::LoginMessage";

    function __construct(DataBase $db){
        $this->loginView = new LoginView();
        $this->validator = new ValidateInput();
        $this->loginMessageView = new LoginMessage();
        //TODO take away userstorage and use model class directly!
        $this->userStorage = new UserSessionController($db);
        
        $this->username = $this->loginView->getRequestUsername();
        $this->password = $this->loginView->getRequestPassword();

        if($this->nameAndPasswordProvided()){
            $this->userStorage->setUser($this->username, $this->password);
        }

        //unset login message before render - render sets new message if applicable
        unset($_SESSION[self::$message]);
    }

    public function renderLoginPageInLayout(LayoutView $layout){
        if($this->nameAndPasswordProvided()){
            
            if($this->successfulLoginAttempt()){
                $this->userStorage->logIn();
                $_SESSION[self::$message] = $this->loginMessageView->welcome();
                
                //$this->loginMessage = $this->loginMessageView->welcome();
            }
        }


       
        //bye bye not rendered if isLoggedIn... Not sure why
        if($this->isLoggedIn() && $this->loginView->logoutRequested()){
            $_SESSION[self::$message] = $this->loginMessageView->bye();
            $this->userStorage->logOut();
        }           
        

        $isLoggedIn = $this->userStorage->isLoggedIn();
        $page = $this->loginView->render($isLoggedIn, $this->loginMessage());
        return $layout->render($page, $isLoggedIn); 
    }

    public function renderLogoutPageInLayout(Layoutview $layout){
        $page = $this->loginView->renderLogoutPage();
        return $layout->render($page, false); 

    }

    private function loginMessage(){
        /*if($this->loginMessage)
            return $this->loginMessage;
        */
        if(isset($_SESSION[self::$message]))
            return $_SESSION[self::$message];
        if($this->usernameMissing())
            return $this->loginMessageView->usernameMissing();
            
        if($this->passwordMissing())
            return $this->loginMessageView->passwordMissing();
                
        if($this->passwordOrNameIncorrect())
            return $this->loginMessageView->wrongNameOrPassword();
    }

    private function usernameMissing(){
        return $this->loginView->loginAttempted() && $this->validator->usernameMissing($this->username); 
    }

    private function passwordMissing(){
        return $this->loginView->loginAttempted() && $this->validator->passwordMissing($this->password); 
    }

    private function passwordOrNameIncorrect(){
        return $this->loginView->loginAttempted() && $this->userStorage->userSet() && $this->userStorage->passwordOrNameIncorrect();
    }

    private function nameAndPasswordProvided(){
        return $this->username && $this->password;
    }

    private function successfulLoginAttempt(){
        return !$this->userStorage->isLoggedIn() && $this->userStorage->credentialsCorrect();
    }

    public function isLoggedIn(){
        return $this->userStorage->isLoggedIn();
    }

}


    /*private function registerUser(){   
        if($this->username && $this->password){
            $this->db->registerUser($this->username, $this->password);
        } 
    }*/

    //$this->registerView = new RegisterUserView();