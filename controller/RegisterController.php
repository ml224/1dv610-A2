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
    private $messages = array();
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

    public function renderRegisterPageWithLayout(LayoutView $layout){
        if($this->registerView->registerNewUserRequested()){
              if($this->invalidInput()){
                $this->failOrSuccessMessage = $this->messagesToHtml();
              }
              else {
                  try{
                    $this->db->registerUser($this->newUserName, $this->newUserPassword);
                  } catch(Exception $e){
                    $this->failOrSuccessMessage = $this->messageView->userExists();
                  }
              }
        }
            
        return $layout->render($this->registerView->render($this->failOrSuccessMessage), false);
    }

    private function invalidInput(){
        return $this->passwordsDontMatch() || $this->usernameTooShort() || $this->passwordTooShort();
    }

    private function populateMessageArray(){
        if($this->passwordsDontMatch())
            array_push($this->messages, $this->messageView->passwordsDontMatch());
        
        if($this->usernameTooShort())
            array_push($this->messages, $this->messageView->usernameTooShort());

        if($this->passwordTooShort())
            array_push($this->messages, $this->messageView->passwordTooShort());
        
        if($this->invalidCharactersInUsername())
            array_push($this->messages, $this->messageView->invalidCharactersInUsername());
    }

    private function messagesToHtml(){
        $this->populateMessageArray();

        $str= "";
        foreach($this->messages as $message){
            $str .= $message . '<br>';
        }

        return $str;
    }

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
}