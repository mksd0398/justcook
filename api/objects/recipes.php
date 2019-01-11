<?php
class Recipes{

    private $conn;
    private $tableName="recipes";

    public $recipesId;
    public $recipesName;
    public $recipesImageUrl;
    public $recipesDetail;
    public $recipesingridents;
    public $categoryId;
    
    
    public function __construct($db){
        $this->conn = $db;
    }

    public function read($id , $idType){
        $query="";
        switch($idType) {
            case 0 : $query = "SELECT * FROM " . $this->tableName . " WHERE categoryId = " . $id;break;
            case 1 : $query = "SELECT * FROM " . $this->tableName;break;
            case 2 : $query = "SELECT * FROM " . $this->tableName. " WHERE recipesId = " . $id;break;
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

}
?>