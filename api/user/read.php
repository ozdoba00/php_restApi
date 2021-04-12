<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');


include_once '../../config/Database.php';
include_once '../../models/User.php';


//Instantiate DB & connect

$database = new Database();

$db = $database->connect();


$user = new User($db);

$result = $user->read();

$num = $result->rowCount();



if($num > 0){
    $users_arr = array();
    $users_arr['data'] = array();

while($row = $result->fetch(PDO::FETCH_ASSOC)){
extract($row);

    $user_item = array(
        'id' => $id,
        'name' => $name,
        'last_name' => $last_name,
        'birth_date' => $birth_date
    );

    echo json_encode($user_item);

    //echo json_encode($users_arr);
}


}else{

}