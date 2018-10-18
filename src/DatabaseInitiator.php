<?php
class DatabaseInitiator{
    private $mysqli;

    function __construct($isDev){
        $this->connectDb($isDev);
    }

    private function connectDB($isDev){
        $this->mysqli = $isDev ?
        new mysqli("localhost", $_ENV["DEV_DB_USERNAME"], $_ENV["DEV_DB_PASSWORD"], $_ENV["DEV_DB_NAME"]):
        new mysqli("localhost", $_ENV["PROD_DB_USERNAME"], $_ENV["PROD_DB_PASSWORD"], $_ENV["PROD_DB_NAME"]);
        
        if ($this->mysqli->connect_error) {
            die("Connection failed: " . $this->mysqli->connect_error);
        }
    }

    public function getMysqli(){
        return $this->mysqli;
    }
}