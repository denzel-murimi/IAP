<?php
class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $email;
    public $password;
    public $auth_code;

   
    public function __construct($db) {
        $this->conn = $db;
    }

    
    public function userExists() {
        $query = "SELECT id FROM " . $this->table_name . " WHERE username = :username OR email = :email LIMIT 1";
        
        $stmt = $this->conn->prepare($query);

        
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));

        
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);

       
        $stmt->execute();

        
        if ($stmt->rowCount() > 0) {
            return true; // User exists
        }

        return false; 
    }

    
    public function create() {
       
        if ($this->userExists()) {
            return "User already exists."; 
        }

        $query = "INSERT INTO " . $this->table_name . " 
                  SET username = :username, email = :email, password = :password, auth_code = :auth_code";

        $stmt = $this->conn->prepare($query);

       
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->auth_code = htmlspecialchars(strip_tags($this->auth_code));

       
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);

        
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":auth_code", $this->auth_code);

        try {
            
            if ($stmt->execute()) {
                return true;
            }
        } catch (PDOException $e) {
            
            error_log("Database error: " . $e->getMessage());
        }

        return false;
    }

    
    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}
