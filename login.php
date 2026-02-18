<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['login_email'];
    $password = $_POST['login_password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Success! Save user info in the session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        
        // Send them to their dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Invalid email or password. <a href='index.html'>Try again</a>";
    }
}
?>