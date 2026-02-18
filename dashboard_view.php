<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Welcome, <?= htmlspecialchars($username) ?>!</h1>
        <a href="logout.php">Logout</a>
    </header>

    <div class="container">
        <div class="auth-box">
            <h2>New Project</h2>
            <form method="POST">
                <input type="text" name="project_name" placeholder="Project Title" required>
                <button type="submit">Add Project</button>
            </form>
        </div>

        <?php foreach ($projects as $project): ?>
            <div class="auth-box" style="margin-top: 20px;">
                <h3>📂 <?= htmlspecialchars($project['name']) ?></h3>
                
                <form method="POST" style="flex-direction: row; gap: 5px;">
                    <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                    <input type="text" name="task_desc" placeholder="Add task..." required>
                    <button type="submit" style="padding: 5px 15px;">+</button>
                </form>

                <ul style="text-align: left; width: 80%;">
                    <?php
                    $taskStmt = $pdo->prepare("SELECT * FROM tasks WHERE project_id = ?");
                    $taskStmt->execute([$project['id']]);
                    while ($task = $taskStmt->fetch()):
                    ?>
                        <li><?= htmlspecialchars($task['task_description']) ?></li>
                    <?php endwhile; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>