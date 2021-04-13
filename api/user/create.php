<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/Database.php';
include_once '../../models/User.php';


//Instantiate DB & connect

$database = new Database();

$db = $database->connect();


$user = new User($db);


// get posted data

$data = json_decode(file_get_contents('php://input'));


//check is data not empty
if(
!empty($data->name) &&
!empty($data->last_name) &&
!empty($data->birth_date)
){
    
$user->name = $data->name;
$user->last_name = $data->last_name;
$user->birth_date = $data->birth_date;

if($user->create()){
    echo json_encode(array("message" => "User was created."));
}else{
    echo json_encode(array("message"=> "Unable to create user."));
}


}else{
    echo json_encode(array("message"=> "Data is no complete"));
}