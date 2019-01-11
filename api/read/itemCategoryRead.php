<?php
header("Access-Control_Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'C:/wamp64/www/justcook/api/config/database.php';
include_once 'C:/wamp64/www/justcook/api/objects/itemsCategory.php';

$database = new Database();
$db = $database->getConnection();

$itemCategory = new ItemsCategory($db);

$stmt = $itemCategory->read();
$num = $stmt->rowCount();

if($num>0){
    $itemCategory_arr=array();
    $itemCategory_arr["items_category"]=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $itemCategory_item=array(
            "itemsCategoryId" => $itemsCategoryId,
            "itemsName" => $itemsName
        );
        array_push($itemCategory_arr["items_category"], $itemCategory_item);
    }
    http_response_code(200);
    echo json_encode($itemCategory_arr);
}
else{
    http_response_code(404);
    echo json_encode(
        array("message" => "No products found.")
    );
}
$db = null;
$database->closeConnection();
?>