<?php
include '../config/db.php';

// Controlla la connessione al database
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Recupera gli esercizi
$result = $conn->query("SELECT * FROM esercizo");
if (!$result) {
    die("Error fetching exercises: " . $conn->error);
}
$exercises = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Scheda</title>
</head>
<body>
    <h1>Create a New Scheda</h1>
    <form method="POST" action="../handlers/addSchedaHandler.php">
        <label for="title">Scheda Title:</label>
        <input type="text" id="title" name="title" required>
        
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
        
        <label for="exercises">Select Exercises:</label>
        <select id="exercises" name="exercises[]" multiple required>
            <?php foreach ($exercises as $exercise): ?>
                <option value="<?= htmlspecialchars($exercise['id_esercizio']) ?>">
                    <?= htmlspecialchars($exercise['nome']) ?> - <?= htmlspecialchars($exercise['descrizione']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <button type="submit">Create Scheda</button>
    </form>
</body>
</html>
