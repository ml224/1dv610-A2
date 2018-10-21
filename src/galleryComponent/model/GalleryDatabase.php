<?php
class GalleryDatabase{
    private $mysqli;

    function __construct($mysqli){
        $this->mysqli = $mysqli;
    }
    

    public function addImage($username, $imageId) : void {
        $stmt = $this->mysqli->prepare("INSERT INTO gallery (id, username) VALUES(?, ?)");
        $stmt->bind_param("ss", $imageId, $username);

        if(!$stmt->execute())
            throw new Exception("image information not added to database");
        
        $stmt->close();
    }

}