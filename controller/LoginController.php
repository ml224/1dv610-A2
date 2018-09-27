<?php

require_once('view/LayoutView.php');
require_once('view/LoginView.php');
require_once('view/LoginMessage.php');

require_once("model/ValidateInput.php");
require_once("model/User.php");
require_once("model/UserStorage.php");

session_start();


class LoginController
{
    //constructors
    //view
    private $loginView;
    private $loginMessageView;

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
        $this->loginMessageView = new LoginMessage();
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
            $this->isLoggedIn = true;

            if($this->cookie){
                $_SESSION[self::$message] = "Welcome back with cookie";
            }
        }
        
        else{
            if($this->nameAndPasswordProvided() && $this->successfulLoginAttempt()){
                $this->isLoggedIn = true;
                $_SESSION[self::$message] = $this->loginMessageView->welcome();

                if($this->loginView->keepLoggedIn()){
                    $this->userStorage->setCookiePassword($this->username, $this->loginView->getCookieName());
                } else{
                    $this->userStorage->setUserSession($this->user);    
                }

            }
        }
       
        //bye bye not rendered if isLoggedIn... Not sure why
        if($this->isLoggedIn() && $this->loginView->logoutRequested()){
            $_SESSION[self::$message] = $this->loginMessageView->bye();
            $this->isLoggedIn = false;
            
            if($this->cookie){
                $this->userStorage->clearCookie($this->loginView->getCookieName(), $this->cookie);
            }else{
                $this->userStorage->unsetUserSession();    
            }
        }           
        

        //something seems to be wrong with isLoggedIn function... defining variable instead
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

    public function isLoggedIn(){
        if($this->cookie)
            return $this->db->cookieExists($this->cookie);
        
        
        return $this->userStorage->userSessionSet();
    }
}