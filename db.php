<?php
$host = 'localhost';
$dbname = 'todo_db';
$user = 'root'; // Default for XAMPP
$pass = '';     // Default for XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>