<?php

require_once('view/RegisterView.php');
require_once('view/MessageView.php');
require_once('model/DataBase.php');

class RegisterController{
    private $registerView;
    private $newUserName;
    private $newUserPassword;
    private $failOrSuccessMessage;
    private $db;
    private $messageView;

    function __construct(DataBase $db){
        $this->messageView = new MessageView();
        $this->registerView = new RegisterView();
        $this->db = $db;

        if($this->registerView->registerNewUserRequested()){
            $this->newUserName = $this->registerView->getUsername();
            $this->newUserPassword = $this->registerView->getPassword();
        }
    }

    public function getPageContent(LayoutView $layout){
        if($this->registerView->registerNewUserRequested()){

            if($this->invalidInput()){
                $html = $this->registerView->listMessagesHtml($this->getMessageArray());
                $this->failOrSuccessMessage = $html;
                
                if($this->invalidCharactersInUsername()){
                    $this->registerView->setUsername(strip_tags($this->newUserName));
                }
            }

            else {
                try{
                    $this->db->registerUser($this->newUserName, $this->newUserPassword);
                    $layout->redirectRegisteredUser($this->newUserName);
                } catch(Exception $e){
                    $this->failOrSuccessMessage = $this->messageView->userExists();
                }
            }
        }
            
        return $this->registerView->render($this->failOrSuccessMessage);
    }

    //validator?
    private function passwordsDontMatch(){
        return !($this->registerView->getPassword() === $this->registerView->getRepeatPassword());
    }

    private function usernameTooShort(){
        return strlen($this->newUserName) < 3;
    }
    private function passwordTooShort(){
        return strlen($this->newUserPassword) < 6;
    }

    private function invalidCharactersInUsername(){
        return !ctype_alnum($this->newUserName);
    }
  
    private function invalidInput(){
        return $this->passwordsDontMatch() || $this->usernameTooShort() || $this->passwordTooShort() || $this->invalidCharactersInUsername();
    }

    private function getMessageArray(){
        $messages = array();
        if($this->passwordsDontMatch())
            array_push($messages, $this->messageView->passwordsDontMatch());
        
        if($this->usernameTooShort())
            array_push($messages, $this->messageView->usernameTooShort());

        if($this->passwordTooShort())
            array_push($messages, $this->messageView->passwordTooShort());
        
        if($this->invalidCharactersInUsername())
            array_push($messages, $this->messageView->invalidCharactersInUsername());
        
        return $messages;
    }
}