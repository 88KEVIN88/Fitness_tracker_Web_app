<?php
include '../config/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];

// Recupera le schede dell'utente
$stmt = $conn->prepare("SELECT id_scheda, titolo FROM scheda WHERE id_utente = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$schede = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Recupera gli esercizi
$stmtExercises = $conn->prepare("SELECT id_esercizio, nome FROM esercizo");
$stmtExercises->execute();
$exercises = $stmtExercises->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Exercise</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h1 class="mb-4">Log Exercise</h1>
    <form method="POST" action="../handlers/logExerciseHandler.php">
        <div class="mb-3">
            <label for="id_scheda" class="form-label">Select Scheda:</label>
            <select name="id_scheda" id="id_scheda" class="form-select" required>
                <?php foreach ($schede as $scheda): ?>
                    <option value="<?= htmlspecialchars($scheda['id_scheda']) ?>">
                        <?= htmlspecialchars($scheda['titolo']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="id_esercizio" class="form-label">Select Exercise:</label>
            <select name="id_esercizio" id="id_esercizio" class="form-select" required>
                <?php foreach ($exercises as $exercise): ?>
                    <option value="<?= htmlspecialchars($exercise['id_esercizio']) ?>">
                        <?= htmlspecialchars($exercise['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="data_esecuzione" class="form-label">Execution Date:</label>
            <input type="date" name="data_esecuzione" id="data_esecuzione" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="carico_utilizzato" class="form-label">Weight Used (kg):</label>
            <input type="number" name="carico_utilizzato" id="carico_utilizzato" class="form-control" step="0.1" required>
        </div>

        <div class="mb-3">
            <label for="ripetizioni_eseguite" class="form-label">Reps Completed:</label>
            <input type="number" name="ripetizioni_eseguite" id="ripetizioni_eseguite" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Log Exercise</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>