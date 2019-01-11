<?php
class ItemsCategory{

    private $conn;
    private $tableName="itemscategory";

    public $itemsCategoryId;
    public $itemsName;

    public function __construct($db){
        $this->conn = $db;
    }

    public function read(){
        $query = "SELECT * FROM " . $this->tableName;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>