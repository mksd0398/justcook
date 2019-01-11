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

if(!empty($data->recipeId)){
    $stmt = $recipes->read($data->recipeId , 2);
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
                "recipesIngridents" => $recipesIngridents,
                "timeTaken" =>$timeTaken,
                "likes" => $likes
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
else{
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create query. Data is incomplete."));
}
$db = null;
$database->closeConnection();
?>