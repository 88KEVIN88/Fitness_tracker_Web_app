<?php
include '../config/db.php';

session_start();

if ($_SESSION['role'] !== 'premium') {
    die("Access denied!");
}

try {
    $stmt = $conn->query("SELECT * FROM tips");
    $tips = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
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
            <li><strong><?= htmlspecialchars($tip['exercise']) ?>:</strong> <?= htmlspecialchars($tip['advice']) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>