<?php

class ValidateInput{

    public function usernameMissing($name){
		return strlen($name) === 0;
    }
    
    public function passwordMissing($psw){
		return strlen($psw) === 0;
    }

}