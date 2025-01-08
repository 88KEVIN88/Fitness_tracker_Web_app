<?php
include '../config/db.php';

session_start();

if ($_SESSION['role'] !== 'premium') {
    die("Access denied!");
}

$result = $conn->query("SELECT * FROM tips");
$tips = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Tips</title>
</head>
<body>
    <h1>Trainer Tips</h1>
    <ul>
        <?php foreach ($tips as $tip): ?>
            <li><strong><?= $tip['exercise'] ?>:</strong> <?= $tip['advice'] ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
