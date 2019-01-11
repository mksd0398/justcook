<?php
class Subscription{

    private $conn;
    private $tableName="subscription";

    public $subId;
    public $subEmail;

    public function __construct($db){
        $this->conn = $db;
    }

    function create(){
        $query = "INSERT INTO
                    " . $this->tableName . " VALUES(:subId,:subEmail)";
     
        $stmt = $this->conn->prepare($query);
     
        $this->queryId=htmlspecialchars(strip_tags($this->subId));
        $this->nameOnQuery=htmlspecialchars(strip_tags($this->subEmail));
     
        $stmt->bindParam(":subId", $this->subId);
        $stmt->bindParam(":subEmail", $this->subEmail);
     
        // execute query
        if($stmt->execute()){
            return true;
        }
     
        return false;
         
    }
}
?>