<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 

include_once "config/database.php";
include_once "objects/user.php";

include_once 'config/core.php';
include_once 'libs/vendor/firebase/php-jwt/src/BeforeValidException.php';
include_once 'libs/vendor/firebase/php-jwt/src/ExpiredException.php';
include_once 'libs/vendor/firebase/php-jwt/src/SignatureInvalidException.php';
include_once 'libs/vendor/firebase/php-jwt/src/JWT.php';
use \Firebase\JWT\JWT;

$database = new Database();

$db = $database->getConnection();

$user = new User($db);

$data = json_decode(file_get_contents('php://input'));

$user->email = $data->email;
$email_extists = $user->emailExists();

if($email_extists && password_verify($data->password, $user->password)){
    $token = array(
        "iat" => $issued_at,
        "exp" => $expiration_time,
        "iss" => $issuer,
        "data" => array(
            "id" => $user->id,
            "firstname" => $user->firstname,
            "lastname" => $user->lastname,
            "email" => $user->email
        )
        );


        $jwt = JWT::encode($token, $key);
        echo json_encode(array(
            "message" => "Login success",
            "jwt" => $jwt
        ));
}else{
    echo json_encode(array(
        "message" => "Login failed"
    ));
}