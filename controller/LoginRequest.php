<?php
require_once('view/LoginView.php');

class LoginRequest
{
   /* private $loginView;
    private $user;
    
    public function LoginRequest(\Model\User $toBeValidated){
        $this->loginView = new LoginView();
        $this->user = $toBeValidated;
    }

    public function isLoggedIn(){
        if($this->loginView->loginAttempted()){
            //$this->user->validCredentials();
        } else{
            return false;
        }
    }

    private function validateUser(){
        //validate user
        return $this->user === $this->loginView->user
    }

    public function setUserSession(){
        //set cookie if user successfully logged in?
    }
*/}