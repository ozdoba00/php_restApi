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


    //Post request -> creating new user
    function create(){
        // insert query

        $query = "INSERT INTO " . $this->table_name . "
            SET
                firstname = :firstname,
                lastname = :lastname,
                email = :email,
                password = :password";
 
    // prepare the query
        $stmt = $this->conn->prepare($query);


        // santizie
        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));


        //bind the values
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":email", $this->email);
        //Hash the password
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(":password", $password_hash);

        if($stmt->execute()){
            return true;
        }

        return false;
    }


    public function update(){
        //if password needs to be udpated

        $password_set=!empty($this->password) ? ", password =:password" : "";

        $query = "UPDATE " . $this->table_name . "
                SET
                    firstname = :firstname,
                    lastname = :lastname,
                    email = :email
                    {$password_set}
                WHERE id = :id";

         $stmt = $this->conn->prepare($query);

        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $this->email=htmlspecialchars(strip_tags($this->email));

        // echo json_encode(array(
        //     "message" => $stmt
        // ));
                
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":email", $this->email);

        if(!empty($this->password)){
            $this->password=htmlentities(strip_tags($this->password));
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            $stmt->bindParam(":password", $password_hash);
        }

        $stmt->bindParam(":id", $this->id);

        if($stmt->execute())
            return true;

        return false;

    }

    //Check if given email exists in the database
    function emailExists(){
        $query = "SELECT id, firstname, lastname, password
                FROM " . $this->table_name . "
                WHERE email = ?
                LIMIT 0,1";

        //prepare query

        $stmt = $this->conn->prepare($query);
        //sanitize
        $this->email=htmlspecialchars(strip_tags($this->email));

        $stmt->bindParam(1, $this->email);

        $stmt->execute();

        $num = $stmt->rowCount();


        //if email exists, assign values
        if($num>0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $row['id'];
            $this->firstname = $row['firstname'];
            $this->lastname = $row['lastname'];
            $this->password = $row['password'];
            //return true cause email exsists in db
            
            return true;
        }
        //Return false if email does not exist in db
        
        return false;

    }
}