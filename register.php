<?php
require_once 'databaseConnect.php';
require_once 'user.php';
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($email) || empty($password)) {
        echo "Please fill in all fields.";
        exit;
    }

    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $user->username = $username;
    $user->email = $email;

    if ($user->userExists()) {
        echo "User with this username or email already exists.";
        exit;
    }

    $user->password = $password;

    $auth_code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    $user->auth_code = $auth_code; 

    if ($user->create()) {
        
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->SMTPDebug = 0;  

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'denzelerrands@gmail.com';
        $mail->Password = 'fderaecjljibswrz'; 
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('denzelerrands@gmail.com', 'Denzel Errands');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your 2FA Code';
        $mail->Body = "Your 2FA code is: {$user->auth_code}"; 

        try {
            $mail->send();
            header('Location: /2FA/2fa.php'); 
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "User registration failed.";
    }
}
?>
