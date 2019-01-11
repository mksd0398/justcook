<?php 
class Category{
    private $conn;
    private $tableName="category";

    public $categoryId;
    public $categoryName;
    public $categoryImageUrl;

    public function __construct($db){
        $this->conn = $db;
    }

    function read(){
        $query = "SELECT * FROM " . $this->tableName;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>