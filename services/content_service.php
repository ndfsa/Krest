<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 07-Nov-18
 * Time: 10:42 AM
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Accept: application/json");

include_once "../config/database.php";
include_once "../object/content.php";

$database = new Database();
$db_connection = $database->getConnection();
$content = new Content($db_connection);

switch ($_SERVER['REQUEST_METHOD']){
    case 'GET':
        $statement = $content->read($_GET["search"]);
        $num = $statement->rowCount();

        if($num > 0){
            $content_array = array();
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
                $c_item = array(
                    "id_content" => $row['id_content'],
                    "title" => $row['title'],
                    "url" => $row['url'],
                    "state" => $row['state'],
                    "description" => $row['description']
                );
                array_push($content_array, $c_item);
            }
            http_response_code(200);
            echo json_encode($content_array);
        }
        break;
    case 'PUT':

    default:
        http_response_code(500);
        echo json_encode(array("error" => "no content"));
        break;
}
