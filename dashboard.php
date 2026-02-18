<?php
session_start();
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Handle Form Submissions (Creating Projects/Tasks)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['project_name'])) {
        $stmt = $pdo->prepare("INSERT INTO projects (user_id, name) VALUES (?, ?)");
        $stmt->execute([$user_id, $_POST['project_name']]);
    } elseif (isset($_POST['task_desc'])) {
        $stmt = $pdo->prepare("INSERT INTO tasks (project_id, task_description) VALUES (?, ?)");
        $stmt->execute([$_POST['project_id'], $_POST['task_desc']]);
    }
    header("Location: dashboard.php");
    exit();
}

//Handle Deleting a Project
if (isset($_GET['delete_project'])) {
    $p_id = $_GET['delete_project'];
    // Because we used ON DELETE CASCADE in our SQL, 
    // deleting a project automatically deletes its tasks!
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ? AND user_id = ?");
    $stmt->execute([$p_id, $user_id]);
    header("Location: dashboard.php");
    exit();
}

//Handle deleting a task
if (isset($_GET['delete_task'])) {
    $t_id = $_GET['delete_task'];
    // We verify the task belongs to a project owned by this user for security
    $stmt = $pdo->prepare("DELETE tasks FROM tasks 
                           JOIN projects ON tasks.project_id = projects.id 
                           WHERE tasks.id = ? AND projects.user_id = ?");
    $stmt->execute([$t_id, $user_id]);
    header("Location: dashboard.php");
    exit();
}

// Get Projects and their Tasks
$projectStmt = $pdo->prepare("SELECT * FROM projects WHERE user_id = ?");
$projectStmt->execute([$user_id]);
$projects = $projectStmt->fetchAll();

// Include the visual layout file
include 'dashboard_view.php';
?>