<?php
require_once 'databaseConnect.php';
require_once 'user.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $auth_code = trim($_POST['auth_code']);

    if (empty($username) || empty($email) || empty($password) || empty($auth_code)) {
        echo "Please fill in all fields.";
        exit;
    }

    if (strlen($auth_code) != 6 || !ctype_digit($auth_code)) {
        echo "Invalid 2FA code.";
        exit;
    }

    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $user->username = $username;
    $user->email = $email;
    $user->password = $password;
    $user->auth_code = $auth_code;

    if ($user->create()) {
        echo "User registered successfully!";
    } else {
        echo "User registration failed.";
    }
}
?>
