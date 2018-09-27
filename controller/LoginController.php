<?php

require_once("view/LayoutView.php");
require_once("view/LoginView.php");
require_once("view/MessageView.php");

require_once("model/ValidateInput.php");
require_once("model/User.php");
require_once("model/UserStorage.php");

session_start();


class LoginController
{
    //constructors
    //view
    private $loginView;
    private $messageView;

    //model
    private $validator;
    
    //controller
    private $userStorage;

    private $db;
    private $user;
    private $cookie;
    private $username;
    private $password;
    private $loginMessage;
    private $isLoggedIn;

    private static $message = "LoginController::LoginMessage";

    function __construct(DataBase $db){
        $this->db = $db;
        $this->loginView = new LoginView();
        $this->validator = new ValidateInput();
        $this->messageView = new MessageView();
        $this->userStorage = new UserStorage($db);
        
        $this->username = $this->loginView->getRequestUsername();
        $this->password = $this->loginView->getRequestPassword();

        if($this->nameAndPasswordProvided()){
            $this->user = new User($this->username, $this->password);
        }
        
        $this->cookie = $this->loginView->getCookiePassword();

        //unset login message before render - render sets new message if applicable
        unset($_SESSION[self::$message]);
    }

    public function renderLoginPageInLayout(LayoutView $layout){
        if($this->isLoggedIn()){
            $this->handleLoggedInUsers();
        } 
        else{
            if($this->nameAndPasswordProvided() && $this->successfulLoginAttempt()){
                $this->handleSuccessfulLogin();
            }
        }
       
        if($this->isLoggedIn() && $this->loginView->logoutRequested()){
            $this->handleLogout();    
        }           
        
        $page = $this->loginView->render($this->isLoggedIn, $this->loginMessage());
        return $layout->render($page, $this->isLoggedIn); 
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

    private function nameAndPasswordProvided(){
        return $this->username && $this->password;
    }

    private function successfulLoginAttempt(){
        if($this->user){
            return ($this->db->userExists($this->username) && $this->db->comparePassword($this->username, $this->password));
        }
    }

    private function handleLoggedInUsers(){
        $this->isLoggedIn = true;

            if($this->cookie && !$this->userStorage->userSessionSet()){
                $_SESSION[self::$message] = "Welcome back with cookie";
            }
    }

    private function handleSuccessfulLogin(){
        $this->isLoggedIn = true;
        $this->userStorage->setUserSession($this->user);          
        $_SESSION[self::$message] = $this->messageView->welcome();

        if($this->loginView->keepLoggedIn()){
                $this->userStorage->setCookiePassword($this->username, $this->loginView->getCookieName());
        }                     
    }
    private function handleLogout(){
        $_SESSION[self::$message] = $this->messageView->bye();
        $this->isLoggedIn = false;
            
        if($this->cookie){
            $this->userStorage->clearCookie($this->loginView->getCookieName(), $this->cookie);
        }
        if($this->userStorage->userSessionSet())
            $this->userStorage->unsetUserSession();
    }

    public function isLoggedIn(){
        if($this->cookie)
            return $this->db->cookieExists($this->cookie);
        
        
        return $this->userStorage->userSessionSet();
    }
}