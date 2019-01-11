<?php
class Reviews{

    private $conn;
    private $tableName="reviews";

    public $reviewId;
    public $reviewersName;
    public $reviewersComment;
    public $recipesId;

    public function __construct($db){
        $this->conn = $db;
    }
}
?>