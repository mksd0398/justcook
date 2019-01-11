<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once 'C:/wamp64/www/justcook/api/config/database.php';
include_once 'C:/wamp64/www/justcook/api/objects/subscription.php';
 
$database = new Database();
$db = $database->getConnection();
 
$subscribing = new Subscription($db);

if( !empty($_POST['email']) ){
    $subscribing->subId = time();
    $subscribing->subEmail = $_POST['email'];
    
    if($subscribing->create()){
        http_response_code(201);
        echo json_encode(array("message" => "OK"));
    }
    else{
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create subscribing."));
    }
}
else{
    http_response_code(400);
    echo json_encode(array("message"=>"Unable to create subscribing. Data is incomplete."));
}
?>