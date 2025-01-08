<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Exercise</title>
</head>
<body>
    <h1>Add a New Exercise</h1>
    <?php
    include '../config/db.php';

    // Recupera i tipi di esercizio dalla tabella tipo_esercizio
    $resultTypes = $conn->query("SELECT id_tipo, nome_tipo FROM tipo_esercizio");
    if (!$resultTypes) {
        die("Error fetching exercise types: " . $conn->error);
    }
    $types = $resultTypes->fetch_all(MYSQLI_ASSOC);

    // Recupera le descrizioni degli esercizi dalla tabella esercizi_descrizione
    $resultDescriptions = $conn->query("SELECT id_descrizione, nome_esercizio FROM esercizi_descrizione");
    if (!$resultDescriptions) {
        die("Error fetching exercise descriptions: " . $conn->error);
    }
    $descriptions = $resultDescriptions->fetch_all(MYSQLI_ASSOC);
    ?>
    <form method="POST" action="../handlers/addExerciseHandler.php">
        <label for="exercise_name">Exercise Name:</label>
        <input type="text" id="exercise_name" name="exercise_name" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="series">Default Series:</label>
        <input type="number" id="series" name="series" required min="1">

        <label for="repetitions">Default Repetitions:</label>
        <input type="number" id="repetitions" name="repetitions" required min="1">

        <label for="type_id">Exercise Type:</label>
        <select id="type_id" name="type_id" required>
            <?php foreach ($types as $type): ?>
                <option value="<?= htmlspecialchars($type['id_tipo']) ?>">
                    <?= htmlspecialchars($type['nome_tipo']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="description_id">Detailed Description:</label>
        <select id="description_id" name="description_id">
            <option value="">-- Add New Description --</option>
            <?php foreach ($descriptions as $description): ?>
                <option value="<?= htmlspecialchars($description['id_descrizione']) ?>">
                    <?= htmlspecialchars($description['nome_esercizio']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="new_description">New Detailed Description (if not listed above):</label>
        <textarea id="new_description" name="new_description"></textarea>

        <button type="submit">Add Exercise</button>
    </form>
</body>
</html>