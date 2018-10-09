<?php
class GalleryDatabase{
    private $mysqli;

    function __construct(){
        $this->connectDatabase();
    }
    
    private function connectDatabase(){
        $this->mysqli = new mysqli("localhost", "root", "", "gallery");
        
        if ($this->mysqli->connect_error) {
            die("Connection failed: " . $this->mysqli->connect_error);
        }
    }

    public function addImage($username, $imageId){
        $stmt = $this->mysqli->prepare("INSERT INTO gallery (id, username) VALUES(?, ?)");
        $stmt->bind_param("ss", $imageId, $username);

        if(!$stmt->execute())
            throw new Exception("image information not added to database");
        
        $stmt->close();
    }

    public function deleteImage($username, $imageId){

    }

    private function getImageDetails($imageId){
        $stmt = $this->mysqli->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row;
    }

}