<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_input_code = trim($_POST['auth_code']);

    if (isset($_SESSION['2fa_code'])) {
        if ($user_input_code === $_SESSION['2fa_code']) {
            echo "2FA verification successful!";
            unset($_SESSION['2fa_code']); 
            unset($_SESSION['email']);
            
        } else {
            echo "Invalid 2FA code. Please try again.";
        }
    } else {
        echo "No 2FA code was generated. Please try again.";
    }
}
?>
