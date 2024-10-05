<?php
require_once 'databaseConnect.php';
require_once 'user.php';


function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    
    $username = sanitize_input($_POST['username']);
    $email = sanitize_input($_POST['email']);
    $password = sanitize_input($_POST['password']);
    $auth_code = sanitize_input($_POST['auth_code']);

    
    if (empty($username) || empty($email) || empty($password) || empty($auth_code)) {
        echo "Please fill in all fields.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    if (strlen($auth_code) != 6 || !ctype_digit($auth_code)) {
        echo "Invalid 2FA code.";
        exit;
    }

    
    try {
        $database = new Database();
        $db = $database->getConnection();

        $user = new User($db);
        $user->username = $username;
        $user->email = $email;
        $user->password = $password;
        $user->auth_code = $auth_code;

       
        $result = $user->create();

        if ($result === true) {
            echo "User registered successfully!";
        } elseif ($result === "User already exists.") {
            echo "User with the same username or email already exists.";
        } else {
            echo "User registration failed.";
        }

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
