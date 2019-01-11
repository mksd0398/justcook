<?php
header("Access-Control_Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'C:/wamp64/www/justcook/api/config/database.php';
include_once 'C:/wamp64/www/justcook/api/objects/items.php';

$database = new Database();
$db = $database->getConnection();

$items = new Items($db);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->itemsCategoryId)){
    $stmt = $items->read($data->itemsCategoryId);
    $num = $stmt->rowCount();

    if($num>0){
        $items_arr=array();
        $items_arr["items"]=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $items_item=array(
                "itemId" => $itemsId,
                "itemName" => $itemsName,
                "itemsUrl" => $itemsUrl
            );
            array_push($items_arr["items"], $items_item);
        }
        http_response_code(200);
        echo json_encode($items_arr);
    }
    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No products found.")
        );
    }
}
else{
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create query. Data is incomplete."));
}
$db = null;
$database->closeConnection();
?>