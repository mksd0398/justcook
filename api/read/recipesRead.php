<?php
header("Access-Control_Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'C:/wamp64/www/justcook/api/config/database.php';
include_once 'C:/wamp64/www/justcook/api/objects/recipes.php';

$database = new Database();
$db = $database->getConnection();

$recipes = new Recipes($db);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->categorySearch)){
    $stmt = $recipes->read($data->categorySearch , 0);
    dataRetrival($stmt);
}
else{
    $stmt  = $recipes->read(" " , 1);
    dataRetrival($stmt);
}

$db = null;
$database->closeConnection();

function dataRetrival($stmt){
    $num = $stmt->rowCount();
    if($num>0){
        $recipes_arr=array();
        $recipes_arr["recipes"]=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $recipes_item=array(
                "recipesId" => $recipesId,
                "recipesName" => $recipesName,
                "recipesImageUrl" => $recipesImageUrl,
                "recipesDetail" => $recipesDetail,
                "recipesIngridents" => $recipesIngridents
            );
            array_push($recipes_arr["recipes"], $recipes_item);
        }
        http_response_code(200);
        echo json_encode($recipes_arr);
    }
    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No products found.")
        );
    }
}
?>