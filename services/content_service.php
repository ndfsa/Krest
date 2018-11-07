<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 07-Nov-18
 * Time: 10:42 AM
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once "../config/database.php";
include_once "../object/content.php";

$method = $_SERVER['REQUEST_METHOD'];

$database = new Database();
$db_connection = $database->getConnection();
$content = new Content($db_connection);

$stmt = $content->read();
$num = $stmt->rowCount();

if($num > 0){
    $content_array = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $c_item = array(
            "id_content" => $id_content,
            "title" => $title,
            "url" => $url,
            "state" => $state,
            "description" => $description
        );
        array_push($content_array, $c_item);
    }
    http_response_code(200);
    echo json_encode($content_array);
}else{
    http_response_code(201);
    echo json_encode(array("0" => "no content"));
}

