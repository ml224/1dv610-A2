<?php

require_once("view/LayoutView.php");
require_once("view/LoginView.php");
require_once("view/MessageView.php");
require_once("model/ValidateInput.php");
require_once("model/UserStorage.php");

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

    function __construct(DataBase $db){
        $this->db = $db;
        $this->loginView = new LoginView();
        $this->validator = new ValidateInput();
        $this->messageView = new MessageView();
        $this->userStorage = new UserStorage($db);
        
        $this->username = $this->loginView->getRequestUsername();
        $this->password = $this->loginView->getRequestPassword();
        
        $this->cookie = $this->loginView->getCookiePassword();
    }

    public function userLoggedIn(){
        return $this->isLoggedIn;
    }

    public function getPageContent($layout){
        if($this->isLoggedIn())
            $this->handleLoggedInUsers();
        
        if(!$this->isLoggedIn() && $this->nameAndPasswordProvided() && $this->successfulLoginAttempt())
            $this->handleSuccessfulLogin();
        
       
        if($this->isLoggedIn && $this->loginView->logoutRequested()){
            $this->handleLogout();    
        }     

        if($layout->userRegistered()){
            $this->handleSuccessfulRegistration($layout);
        }
        
        return $this->loginView->render($this->isLoggedIn, $this->getLoginMessage());
    }

    public function isLoggedIn(){
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

    private function handleSuccessfulRegistration($layout){    
        $this->loginMessage = $this->messageView->newUserRegistered();

        //setting username in loginview session, so that username is displayed in login field
        //after successful registration
        $this->loginView->setUsername($layout->getNewUsername());
    
    }

    private function getLoginMessage(){
        if($this->loginMessage)
            return $this->loginMessage;

        if($this->usernameMissing())
            return $this->messageView->usernameMissing();
            
        if($this->passwordMissing())
            return $this->messageView->passwordMissing();
                
        if($this->passwordOrNameIncorrect())
            return $this->messageView->wrongNameOrPassword();
    }

    private function usernameMissing(){
        return $this->loginView->loginAttempted() && $this->validator->usernameMissing($this->username); 
    }

    private function passwordMissing(){
        return $this->loginView->loginAttempted() && $this->validator->passwordMissing($this->password); 
    }

    private function passwordOrNameIncorrect(){
        return $this->loginView->loginAttempted() && $this->nameAndPasswordProvided() && $this->db->nameOrPasswordIncorrect($this->username, $this->password);
    }
}