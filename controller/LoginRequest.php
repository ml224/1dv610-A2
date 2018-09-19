<?php

require_once('view/LayoutView.php');
require_once('view/DateTimeView.php');
require_once('view/LoginView.php');

require_once('model/User.php');

class LoginRequest
{
    private $loginView;
    private $user;
    private $dateView;

    private $requestUsername;
    private $requestPassword;

    
    
    public function LoginRequest(){
        $this->loginView = new LoginView();
        $this->dateView = new DateTimeView();

        $this->requestUsername = $this->loginView->getRequestUsername();
        $this->requestPassword = $this->loginView->getRequestPassword();

        $this->user = new User($this->requestUsername);
    }

    public function renderPage(){
        //return true if request password is correct
            $isPasswordCorrect = $this->user->checkIfPasswordCorrect($this->requestPassword);
            //TODO setUserSession(correctPassword)

            $layout = new LayoutView($isPasswordCorrect);

            
            $layout->render($this->loginView, $this->dateView);
        
    }
    
   
}

/* public function isLoggedIn(){
        ($this->loginView->loginAttempted()){
            //$this->user->validCredentials();
        } else{
            return false;
        }
    }


    public function setUserSession($correctPassword){
        if($correctPassword){
            //store session..
        }
    }
 */