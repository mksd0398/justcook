<?php 
class Queries{

    private $conn;
    private $tableName="queries";

    public $queryId;
    public $nameOnQuery;
    public $emailOnQuery;
    public $subjectOnQuery;
    public $reviewOnQuery;
    
    
    public function __construct($db){
        $this->conn = $db;
    }

    function create(){
        $query = "INSERT INTO
                    " . $this->tableName . " VALUES(:queryId,:nameOnQuery,:emailOnQuery,:subjectOnQuery,:reviewOnQuery)";
     
        $stmt = $this->conn->prepare($query);
     
        $this->queryId=htmlspecialchars(strip_tags($this->queryId));
        $this->nameOnQuery=htmlspecialchars(strip_tags($this->nameOnQuery));
        $this->emailOnQuery=htmlspecialchars(strip_tags($this->emailOnQuery));
        $this->subjectOnQuery=htmlspecialchars(strip_tags($this->subjectOnQuery));
        $this->reviewOnQuery=htmlspecialchars(strip_tags($this->reviewOnQuery));
     
        $stmt->bindParam(":queryId", $this->queryId);
        $stmt->bindParam(":nameOnQuery", $this->nameOnQuery);
        $stmt->bindParam(":emailOnQuery", $this->emailOnQuery);
        $stmt->bindParam(":subjectOnQuery", $this->subjectOnQuery);
        $stmt->bindParam(":reviewOnQuery", $this->reviewOnQuery);
     
        // execute query
        if($stmt->execute()){
            return true;
        }
     
        return false;
         
    }
}
?>