<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once 'C:/wamp64/www/justcook/api/config/database.php';
include_once 'C:/wamp64/www/justcook/api/objects/queries.php';
 
$database = new Database();
$db = $database->getConnection();
 
$query = new Queries($db);

if(
    !empty($_POST['name']) &&
    !empty($_POST['email']) &&
    !empty($_POST['subject']) &&
    !empty($_POST['message'])
){
    $query->queryId = time();
    $query->nameOnQuery = $_POST['name'];
    $query->emailOnQuery = $_POST['email'];
    $query->subjectOnQuery = $_POST['subject'];
    $query->reviewOnQuery = $_POST['message'];
    
    if($query->create()){
        http_response_code(201);
        echo json_encode(array("message" => "OK"));
    }
    else{
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create query."));
    }
}
else{
    http_response_code(400);
    echo json_encode(array("message"=>"Unable to create query. Data is incomplete."));
}
?>