<?php
include '../config/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];

try {
    // Recupera le schede dell'utente
    $stmt = $conn->prepare("SELECT id_scheda, titolo FROM scheda WHERE id_utente = :userId");
    $stmt->execute([':userId' => $userId]);
    $schede = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Recupera gli esercizi
    $stmtExercises = $conn->query("SELECT id_esercizio, nome FROM esercizo");
    $exercises = $stmtExercises->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registra Esercizio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
<div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Registra esercizio</h1>
        <a href="dashboard.php" class="btn btn-secondary">Torna alla Dashboard</a>
    </div>
    <form method="POST" action="../handlers/logExerciseHandler.php">
        <div class="mb-3">
            <label for="id_scheda" class="form-label">Seleziona Scheda:</label>
            <select name="id_scheda" id="id_scheda" class="form-select" required>
                <?php foreach ($schede as $scheda): ?>
                    <option value="<?= htmlspecialchars($scheda['id_scheda']) ?>">
                        <?= htmlspecialchars($scheda['titolo']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="id_esercizio" class="form-label">Seleziona Esercizio:</label>
            <select name="id_esercizio" id="id_esercizio" class="form-select" required>
                <?php foreach ($exercises as $exercise): ?>
                    <option value="<?= htmlspecialchars($exercise['id_esercizio']) ?>">
                        <?= htmlspecialchars($exercise['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="data_esecuzione" class="form-label">Data di Esecuzione:</label>
            <input type="date" id="data_esecuzione" name="data_esecuzione" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="carico_utilizzato" class="form-label">Carico Utilizzato (kg):</label>
            <input type="number" id="carico_utilizzato" name="carico_utilizzato" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="ripetizioni_eseguite" class="form-label">Ripetizioni Eseguite:</label>
            <input type="number" id="ripetizioni_eseguite" name="ripetizioni_eseguite" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Registra Esercizio</button>
    </form>
</body>
</html>