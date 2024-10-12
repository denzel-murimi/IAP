<?php
require_once 'databaseConnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $auth_code = trim($_POST['auth_code']); 

    if (empty($auth_code)) {
        echo "Please fill in all fields.";
        exit;
    }

    $database = new Database();
    $db = $database->getConnection();

    
    error_log("Auth code received: '{$auth_code}'");

    
    $query = "SELECT * FROM users WHERE auth_code = :auth_code LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':auth_code', $auth_code);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
       
        error_log("User found. Auth code in database: '{$user['auth_code']}'");

       
        echo "2FA verification successful! You are now logged in.";
        
    } else {
        echo "Invalid 2FA code. Please try again."; 
    }
}
?>
