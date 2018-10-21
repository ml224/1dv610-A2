<?php

require_once("../src/loginComponent/view/LoginView.php");
require_once("../src/loginComponent/model/UserSession.php");

session_start();


class LoginController
{
    private $loginView;
    private $userSession;
    private $db;

    private $username;
    private $password;
    private $loginMessage;
    private $isLoggedIn;

    function __construct(UserDatabase $db){
        $this->db = $db;
        $this->loginView = new LoginView();
        $this->userSession = new UserSession();
        
        $this->isLoggedIn = $this->isLoggedIn();

        if($this->loginView->loginAttempted()){
            $this->username = $this->loginView->getInputName();
            $this->password = $this->loginView->getInputPassword();
        }
    }
    
    private function isLoggedIn() : bool {
        if($this->loginView->cookieSet()){
            $cookie = $this->loginView->getCookie();
            return $this->db->cookieExists($cookie);
        } 

        if($this->userSession->sessionSet()){
            return $this->userSession->sessionNotAltered();
        }
        return false;
    }

    public function getPageContent(LoginNavigationView $nav) : string {
        if($this->isLoggedIn){
            $this->handleLoggedInUsers();
        }
        if($this->successfulLoginAttempt()){
            $this->handleSuccessfulLogin();
        }     
        if($nav->userRegistered()){
            $this->handleSuccessfulRegistration($nav);
        }
        
        return $this->loginView->render($this->isLoggedIn, $this->getLoginMessage());
    }

    private function handleLoggedInUsers(){
        $this->isLoggedIn = true;

        if(!$this->userSession->sessionSet()){
            $this->loginMessage = $this->loginView->cookieLoginMessage();
        }
        if($this->loginView->logoutRequested()){
            $this->handleLogout();    
        }
    }

    private function handleLogout() : void {
        $this->loginMessage = $this->loginView->byeMessage();
        $this->isLoggedIn = false;
            
        if($this->loginView->cookieSet()){
            $this->db->clearCookie($this->loginView->getCookie());
            $this->loginView->clearCookie();
        }
        if($this->userSession->sessionSet()){
            $this->userSession->unsetUserSession();
        }
    }

    private function successfulLoginAttempt() : bool {
        return !$this->isLoggedIn && $this->loginView->loginAttempted() && $this->credentialsCorrect();
    }

    private function credentialsCorrect() : bool {
        return ($this->db->userExists($this->username) && $this->db->passwordIsCorrect($this->username, $this->password));
    }

    private function handleSuccessfulLogin() : void {
        $this->isLoggedIn = true;
        $this->userSession->setUserSession($this->username);          
        $this->loginMessage = $this->loginView->welcomeMessage();

        if($this->loginView->keepLoggedIn()){
            $random = $this->loginView->randomCookie();
            $this->loginView->setCookie($random);
    		$this->db->storeCookie($this->username, $random);
        }
    }

    private function handleSuccessfulRegistration(LoginNavigationView $nav) : void {    
        $this->loginMessage = $this->loginView->newUserMessage();
        $this->loginView->setInputName($nav->getNewUsernameFromUrl());
    }

    private function getLoginMessage() : string {
        return $this->loginMessage ? $this->loginMessage : $this->loginView->getMessageIfError($this->db);
    }
    
    //will be used by components dependent on login state 
    public function userLoggedIn() : bool {
        return $this->isLoggedIn;
    }
}