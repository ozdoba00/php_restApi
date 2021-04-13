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

    public function read_single_byName($name){

        $query = "SELECT * FROM `users` WHERE name='$name'";

        $stmt = $this->conn->prepare($query);


        $stmt->execute();

        return $stmt;
    }


    public function create(){
        $query = "INSERT INTO " .$this->table . "
        SET
            name= :name,
            last_name= :last_name,
            birth_date = :birth_date";


        $stmt = $this->conn->prepare($query);

        //sanitize 
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->last_name=htmlspecialchars(strip_tags($this->last_name));
        $this->birth_date=htmlspecialchars(strip_tags($this->birth_date));

        
        //bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":birth_date", $this->birth_date);
        if($stmt->execute())
        return true;
        
        return false;
    }
}