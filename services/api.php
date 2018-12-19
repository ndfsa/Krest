<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 16-Dec-18
 * Time: 12:46 PM
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Accept: application/json");

include_once "../config/database.php";
include_once "../object/content.php";

$database = new Database();
$db_connection = $database->getConnection();
$content = new Content($db_connection);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['search'])) {
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
    } else if (isset($_GET['id_content'])) {
        $statement = $content->readOne($_GET["id_content"]);
        $num = $statement->rowCount();
        if ($num === 1) {
            $elem = $statement->fetch(PDO::FETCH_ASSOC);
            http_response_code(200);
            echo json_encode($elem);
        }
    } else {
        $statement = $content->getAll();
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
    }
}