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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optional: Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Create a New Scheda</h1>
        <form method="POST" action="../handlers/addSchedaHandler.php" class="p-4 border rounded shadow-sm bg-light">
            <div class="mb-3">
                <label for="title" class="form-label">Scheda Title:</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="exercises" class="form-label">Select Exercises:</label>
                <select id="exercises" name="exercises[]" class="form-select" multiple required>
                    <?php foreach ($exercises as $exercise): ?>
                        <option value="<?= htmlspecialchars($exercise['id_esercizio']) ?>">
                            <?= htmlspecialchars($exercise['nome']) ?> - <?= htmlspecialchars($exercise['descrizione']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Create Scheda</button>
        </form>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
