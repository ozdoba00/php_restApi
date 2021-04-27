<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/php_restApi_jwt_auth/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once "config/database.php";
include_once "objects/user.php";


//database connection
$database = new Database();

$db = $database->getConnection();

$user = new User($db);

//get posted data

$data = json_decode(file_get_contents("php://input"));


//set product property values
$user->firstname = $data->firstname;
$user->lastname = $data->lastname;
$user->email = $data->email;
$user->password = $data->password;

if(
    !empty($user->firstname) &&
    !empty($user->email) &&
    !empty($user->password)
){
    if(
        !$user->emailExists()&&
         $user->create()
    ){
            echo json_encode(array("message"=>"User was created."));
    }else{
            echo json_encode(array("message"=> "This email is already taken!"));
    }
    

}else{
    echo json_encode(array("message"=>"Make sure that forms are not empty!"));
}

// !$user->emailExists() &&
//     $user->create()