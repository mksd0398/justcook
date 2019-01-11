<?php
header("Access-Control_Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'C:/wamp64/www/justcook/api/config/database.php';
include_once 'C:/wamp64/www/justcook/api/objects/category.php';

$database = new Database();
$db = $database->getConnection();

$category = new Category($db);

$stmt = $category->read();
$num = $stmt->rowCount();

if($num>0){
    $category_arr=array();
    $category_arr["categories"]=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $category_item=array(
            "categoryId" => $categoryId,
            "name" => $categoryName,
            "categoryImageUrl" => $categoryImageUrl
        );
        array_push($category_arr["categories"], $category_item);
    }
    http_response_code(200);
    echo json_encode($category_arr);
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