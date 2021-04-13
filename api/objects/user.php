<?php

//user object

class User{
    //db connection and table name
    private $conn;
    private $table_name = "users_jwt";

    //object prop 

    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $password;

    public function __construct($db)
    {
        $this->conn = $db;
    }
}