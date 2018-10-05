<?php

require_once('view/RegisterView.php');
require_once('view/MessageView.php');
require_once('model/DataBase.php');

class RegisterController{
    private $db;
    private $inputValidator;
    private $messageView;
    private $registerView;
    private $nav;

    private $username;
    private $password;
    private $repeatPassword;
    private $failOrSuccessMessage;

    function __construct(DataBase $db, NavigationView $nav){
        $this->messageView = new MessageView();
        $this->registerView = new RegisterView();
        $this->db = $db;
        $this->nav = $nav;

        if($this->registerView->registerNewUserRequested()){
            $this->username = $this->registerView->getUsername();
            $this->password = $this->registerView->getPassword();
            $this->repeatPassword = $this->registerView->getRepeatPassword();

            $this->inputValidator = new ValidateInput($this->username, $this->password);
        }
    }

    public function getPageContent(){
        if($this->registerView->registerNewUserRequested()){

            if($this->invalidInput()){
                $html = $this->registerView->listMessagesHtml($this->getMessageArray());
                $this->failOrSuccessMessage = $html;

                if($this->inputValidator->invalidCharactersInUsername()){
                    $this->registerView->setUsername(strip_tags($this->username));
                }
            }

            else {
                try{
                    $this->db->registerUser($this->username, $this->password);
                    $this->nav->redirectRegisteredUser($this->username);
                } catch(Exception $e){
                    $this->failOrSuccessMessage = $this->messageView->userExists();
                }
            }
        }
            
        return $this->registerView->render($this->failOrSuccessMessage);
    }
  
    private function invalidInput(){
        $passwordsDontMatch = $this->inputValidator->passwordsDontMatch($this->repeatPassword);
        $usernameTooShort = $this->inputValidator->usernameTooShort();
        $passwordTooShort = $this->inputValidator->passwordTooShort();
        $invalidCharactersInUsername = $this->inputValidator->invalidCharactersInUsername();

        return $passwordsDontMatch || $usernameTooShort || $passwordTooShort || $invalidCharactersInUsername;
    }

    private function getMessageArray(){
        $messages = array();
        if($this->inputValidator->passwordsDontMatch($this->repeatPassword))
            array_push($messages, $this->messageView->passwordsDontMatch());
        
        if($this->inputValidator->usernameTooShort())
            array_push($messages, $this->messageView->usernameTooShort());

        if($this->inputValidator->passwordTooShort())
            array_push($messages, $this->messageView->passwordTooShort());
        
        if($this->inputValidator->invalidCharactersInUsername())
            array_push($messages, $this->messageView->invalidCharactersInUsername());
        
        return $messages;
    }
}