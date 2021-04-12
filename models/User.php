<?php

class User{
    //DB stuff
    private $conn;
    private $table = 'users';

    // User properties
    public $id;

    public $name;
    public $last_name;
    public $birth_date;

    //Constructor with DB

    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function read(){
        $query = "SELECT * FROM `users` WHERE 1";


        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }


    public function read_single_byId($id){

        $query = "SELECT * FROM `users` WHERE id=$id";

        $stmt = $this->conn->prepare($query);


        $stmt->execute();

        return $stmt;
    }
}