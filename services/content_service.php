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

if($_SERVER['REMOTE_ADDR'] !== $_SERVER['SERVER_ADDR']){
    die("unauthorized: " . $_SERVER['REMOTE_ADDR'] . " != " . $_SERVER['SERVER_ADDR']);
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if(isset($_GET['search'])){
            $statement = $content->read(urldecode($_GET["search"]));
            $num = $statement->rowCount();
            if ($num > 0) {
                $content_array = array();
                while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    $c_item = array(
                        "id_content" => $row['id_content'],
                        "title" => $row['title'],
                        "url" => $row['url'],
                        "state" => $row['state'],
                        "ext" => $row['ext'],
                        "dateOf" => $row['dateOf'],
                        "description" => $row['description']
                    );
                    array_push($content_array, $c_item);
                }
                http_response_code(200);
                echo json_encode($content_array);
            }
        }else if (isset($_GET['id_content'])){
            $statement = $content->readOne($_GET["id_content"]);
            $num = $statement->rowCount();
            if ($num === 1) {
                $elem = $statement->fetch(PDO::FETCH_ASSOC);
                http_response_code(200);
                echo json_encode($elem);
            }
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $content->title = $data['title'];
        $content->url = $data['url'];
        $content->state = $data['state'];
        $content->ext = $data['ext'];
        $content->description = $data['description'];
        $content->create($data['id_user']);
        $content->clean_attributes();
        break;
    case 'DELETE':
        if(isset($_GET['id_content'])){
            $content->remove($_GET["id_content"]);
            http_response_code(200);
        }
        break;
    case 'PUT':
        if(isset($_GET['id_content'])){
            $data = json_decode(file_get_contents('php://input'), true);
            $content->title = $data['title'];
            $content->url = $data['url'];
            $content->state = $data['state'];
            $content->ext = $data['ext'];
            $content->description = $data['description'];
            $content->modify($_GET['id_content']);
            $content->clean_attributes();
        }
        break;
    default:
        http_response_code(500);
        echo json_encode(array("error" => "no content"));
        break;
}
