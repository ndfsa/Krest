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
        break;
    case 'PUT':

        $data = json_decode(file_get_contents('php://input'), true);
        $user->name = $data['name'];
        $user->surname = $data['surname'];
        $user->username = $data['username'];
        $user->password = $data['password'];
        $user->type = $data['type'];
        $user->birth = $data['birth'];
        $user->create();
        $user->clean_attributes();
        http_response_code(200);

        break;
    default:
        http_response_code(500);
        echo json_encode(array("error" => "no content"));
        break;
}