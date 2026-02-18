<?php
require 'db.php'; // This connects to your database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    // We hash the password so it's not readable if the DB is ever leaked
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);
        echo "Registration successful! <a href='index.html'>Login here</a>";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Error code for duplicate entry
            echo "Error: Email already exists.";
        } else {
            echo "Registration failed: " . $e->getMessage();
        }
    }
}
?>