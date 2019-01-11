<?php
class Items{

    private $conn;
    private $tableName="items";

    public $itemsId;
    public $itemsName;
    public $itemsUrl;
    public $itemsCategoryId;

    public function __construct($db){
        $this->conn = $db;
    }

    public function read($categoryId){
        $query = "SELECT itemsId,itemsName,itemsUrl FROM " . $this->tableName . " WHERE itemsCatergoryId = ".$categoryId;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>