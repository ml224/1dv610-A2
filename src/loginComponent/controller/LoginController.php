<?php

require_once("../src/loginComponent/view/LoginView.php");
require_once("../src/loginComponent/view/MessageView.php");
require_once("../src/loginComponent/model/ValidateInput.php");
require_once("../src/loginComponent/model/UserSession.php");

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

    function __construct(UserDatabase $db, LoginNavigationView $nav){
        $this->db = $db;
        $this->navigationView = $nav;

        $this->loginView = new LoginView();
        $this->messageView = new MessageView();
        $this->userStorage = new UserSession($db);
        
        $this->username = $this->loginView->getInputName();
        $this->password = $this->loginView->getInputPassword();
        $this->isLoggedIn = $this->isLoggedIn();
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

    //TODO place in validator
    private function isLoggedIn(){
        if($this->loginView->cookieSet()){
            if($this->db->cookieExists($this->loginView->getCookie())){
                return true;
            } 
            else{
                $this->loginMessage =  $this->messageView->wrongInformationInCookie();
                return false;
            }
        }
        
        if($this->userStorage->sessionSet()){
            return $this->userStorage->sessionNotAltered();
        }
    }

    private function handleLoggedInUsers(){
        $this->isLoggedIn = true;

            if(!$this->userStorage->sessionSet()){
                $this->loginMessage = $this->messageView->welcomeBackWithCookie();
            }
    }

    //TODO place in validator
    private function nameAndPasswordProvided(){
        return $this->username && $this->password;
    }

    //TODO place in validator
    private function successfulLoginAttempt(){
        return ($this->db->userExists($this->username) && $this->db->passwordIsCorrect($this->username, $this->password));
    }

    private function handleSuccessfulLogin(){
        $this->isLoggedIn = true;
        $this->userStorage->setUserSession($this->username);          
        $this->loginMessage = $this->messageView->welcome();

        if($this->loginView->keepLoggedIn()){
            $random = $this->loginView->randomCookie();
            $this->loginView->setCookie($random);
    		$this->db->storeCookie($this->username, $random);
        }
    }

    
    private function handleLogout(){
        $this->loginMessage = $this->messageView->bye();
        $this->isLoggedIn = false;
            
        if($this->loginView->cookieSet()){
            $cookie = $this->loginView->getCookie();
            $this->db->clearCookie($cookie);
            $this->loginView->clearCookie();
        }
        if($this->userStorage->sessionSet()){
            $this->userStorage->unsetUserSession();
        }
    }

    private function handleSuccessfulRegistration(){    
        $this->loginMessage = $this->messageView->newUserRegistered();

        //setting username in loginview session, so that username is displayed in login field
        //after successful registration
        $this->loginView->setInputName($this->navigationView->getNewUsername());
    
    }

    //TODO  move to view & create model facade class to communicate with session and db
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

    
    //used in maincontroller 
    public function userLoggedIn(){
        return $this->isLoggedIn;
    }
}