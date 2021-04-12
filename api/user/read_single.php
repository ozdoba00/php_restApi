<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');


include_once '../../config/Database.php';
include_once '../../models/User.php';


//Instantiate DB & connect

$database = new Database();

$db = $database->connect();


$user = new User($db);

$user->id = isset($_GET['id']) ? $_GET['id'] : die();



$result = $user->read_single_byId($user->id);

if($result->rowCount()>0){
    $data = $result->fetch(PDO::FETCH_ASSOC);

    extract($data);
    
    $user_item = array(
        'id' => $id,
        'name' => $name,
        'last_name' => $last_name,
        'birth_date' => $birth_date
    );
    
    echo json_encode($user_item);
}else{
    echo "There's no user with the given id...";
}



