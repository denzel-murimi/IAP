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

       
        return $stmt->rowCount() > 0;
    }

    
    public function create() {
        if ($this->userExists()) {
            return "User already exists."; 
        }
    
        
        $this->auth_code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT); // Generate a 6-digit code
        $query = "INSERT INTO " . $this->table_name . " 
                  SET username = :username, email = :email, password = :password, auth_code = :auth_code";
    
        $stmt = $this->conn->prepare($query);
    
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
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
?>
