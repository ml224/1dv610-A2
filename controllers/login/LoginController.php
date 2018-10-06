<?php

require_once("views/login/LoginView.php");
require_once("views/login/MessageView.php");
require_once("models/login/ValidateInput.php");
require_once("models/login/UserSession.php");

session_start();


class LoginController
{
    private $loginView;
    private $messageView;
    private $validator;
    private $userStorage;

    private $db;
    private $cookie;
    private $username;
    private $password;
    private $loginMessage;
    private $isLoggedIn;

    function __construct(DataBase $db, NavigationView $nav){
        $this->db = $db;
        $this->navigationView = $nav;

        $this->loginView = new LoginView();
        $this->messageView = new MessageView();
        $this->userStorage = new UserSession($db);
        
        $this->username = $this->loginView->getInputName();
        $this->password = $this->loginView->getInputPassword();
        $this->cookie = $this->loginView->getCookiePassword();
        $this->isLoggedIn = $this->isLoggedIn();
    }

    //used in maincontroller 
    public function userLoggedIn(){
        return $this->isLoggedIn;
    }

    public function getPageContent(){
        if($this->isLoggedIn)
            $this->handleLoggedInUsers();
        
        if(!$this->isLoggedIn && $this->nameAndPasswordProvided() && $this->successfulLoginAttempt())
            $this->handleSuccessfulLogin();
        
       
        if($this->isLoggedIn && $this->loginView->logoutRequested()){
            $this->handleLogout();    
        }     

        if($this->navigationView->userRegistered()){
            $this->handleSuccessfulRegistration();
        }
        
        return $this->loginView->render($this->isLoggedIn, $this->getLoginMessage());
    }

    private function isLoggedIn(){
        if($this->cookie){
            if($this->db->cookieExists($this->cookie))
                return true;
            else{
                $this->loginMessage =  $this->messageView->wrongInformationInCookie();
                return false;
            }
        }
        
        if($this->userStorage->userSessionSet()){
            return $this->userStorage->userSessionNotAltered();
        }
    }

    private function handleLoggedInUsers(){
        $this->isLoggedIn = true;

            if(!$this->userStorage->userSessionSet()){
                $this->loginMessage = $this->messageView->welcomeBackWithCookie();
            }
    }

    private function nameAndPasswordProvided(){
        return $this->username && $this->password;
    }

    private function successfulLoginAttempt(){
        return ($this->db->userExists($this->username) && $this->db->passwordIsCorrect($this->username, $this->password));
    }

    private function handleSuccessfulLogin(){
        $this->isLoggedIn = true;
        $this->userStorage->setUserSession($this->username);          
        $this->loginMessage = $this->messageView->welcome();

        if($this->loginView->keepLoggedIn())
            $this->userStorage->setCookiePassword($this->username, $this->loginView->getCookieName());
    }
    
    private function handleLogout(){
        $this->loginMessage = $this->messageView->bye();
        $this->isLoggedIn = false;
            
        if($this->cookie){
            $this->userStorage->clearCookie($this->loginView->getCookieName(), $this->cookie);
        }
        if($this->userStorage->userSessionSet()){
            $this->userStorage->unsetUserSession();
        }
    }

    private function handleSuccessfulRegistration(){    
        $this->loginMessage = $this->messageView->newUserRegistered();

        //setting username in loginview session, so that username is displayed in login field
        //after successful registration
        $this->loginView->setInputName($this->navigationView->getNewUsername());
    
    }

    private function getLoginMessage(){
        if($this->loginMessage)
            return $this->loginMessage;

        if($this->loginView->loginAttempted()){
            $inputValidator = new ValidateInput($this->username, $this->password);

            if($inputValidator->usernameMissing())
                return $this->messageView->usernameMissing();
            
            if($inputValidator->passwordMissing())
                return $this->messageView->passwordMissing();
                
            if($this->db->nameOrPasswordIncorrect($this->username, $this->password))
                return $this->messageView->wrongNameOrPassword();
        }
    }
}