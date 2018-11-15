<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 09-Nov-18
 * Time: 1:17 PM
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Accept: application/json");

include_once "../config/database.php";
include_once "../object/user.php";

$database = new Database();
$db_connection = $database->getConnection();
$user = new User($db_connection);

switch ($_SERVER['REQUEST_METHOD']){
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if(isset($data["new_user"])){
            $data = json_decode(file_get_contents('php://input'), true);
            $user->name = $data['name'];
            $user->surname = $data['surname'];
            $user->password = $data['password'];
            $user->username = $data['username'];
            $user->type = $data['type'];
            $user->birth = $data['birth'];
            $user->create();
            $user->clean_attributes();
            http_response_code(200);
        }else{
            $statement = $user->verify_sign_in($data['username'], $data['password']);
            $num = $statement->rowCount();
            if($num > 0){
                $row = $statement->fetch(PDO::FETCH_ASSOC);
                $response = array(
                    'id_user' => $row['id_user'],
                    'name' => $row['name'],
                    'surname' => $row['surname'],
                    'username' => $row['username'],
                    'type' => $row['type'],
                    'birth' => $row['birth']
                );
                http_response_code(200);
                echo json_encode($response);
            }
        }
        break;
    case 'PUT':
        if(isset($_GET["id_user"])){
            $data = json_decode(file_get_contents('php://input'), true);

            if($data["password_change"]){
                $user->username = $data['username'];
                $user->password = $data['password'];
                $user->update_password($_GET["id_user"]);
                $user->clean_attributes();
            }else{
                $user->name = $data['name'];
                $user->surname = $data['surname'];
                $user->type = $data['type'];
                $user->birth = $data['birth'];
                $user->update($_GET["id_user"]);
                $user->clean_attributes();
                http_response_code(200);
            }
        }else{
            http_response_code(500);
        }
        break;
    case 'DELETE':
        if(isset($_GET['id_user'])){
            $user->remove($data['id_user']);
            http_response_code(200);
        }
        break;
    case 'GET':
        $statement = $user->get_user($_GET['id_user']);
        $num = $statement->rowCount();
        if($num > 0) {
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            $response = array(
                'name' => $row['name'],
                'surname' => $row['surname'],
                'username' => $row['username'],
                'type' => $row['type'],
                'birth' => $row['birth']
            );
            http_response_code(200);
            echo json_encode($response);
        }
        break;
    default:
        http_response_code(500);
        echo json_encode(array("error" => "no content"));
        break;
}