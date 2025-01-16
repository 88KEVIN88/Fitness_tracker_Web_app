<?php
include '../config/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$schedaId = $_GET['id'];

try {
    $stmt = $conn->prepare("SELECT * FROM scheda WHERE id_scheda = :schedaId");
    $stmt->execute([':schedaId' => $schedaId]);
    $scheda = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$scheda) {
        die("Scheda non trovata.");
    }

    // Recupera gli esercizi associati alla scheda
    $stmtExercises = $conn->prepare("SELECT e.id_esercizio, e.nome FROM carico c JOIN esercizo e ON c.id_esercizio = e.id_esercizio WHERE c.id_scheda = :schedaId");
    $stmtExercises->execute([':schedaId' => $schedaId]);
    $currentExercises = $stmtExercises->fetchAll(PDO::FETCH_ASSOC);

    // Recupera tutti gli esercizi disponibili
    $stmtAllExercises = $conn->query("SELECT id_esercizio, nome FROM esercizo");
    $allExercises = $stmtAllExercises->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Errore nel recupero della scheda: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Scheda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
<div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Modifica Scheda</h1>
        <a href="dashboard.php" class="btn btn-secondary">Torna alla Dashboard</a>
    </div>
    <form method="POST" action="../handlers/modifySchedaHandler.php">
        <input type="hidden" name="id_scheda" value="<?= htmlspecialchars($scheda['id_scheda']) ?>">
        <div class="mb-3">
            <label for="title" class="form-label">Titolo della Scheda:</label>
            <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($scheda['titolo']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descrizione:</label>
            <textarea id="description" name="description" class="form-control" rows="3" required><?= htmlspecialchars($scheda['descrizione']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="exercises" class="form-label">Esercizi Attuali: (Check the boxes to remove)</label>
            <ul class="list-group">
                <?php foreach ($currentExercises as $exercise): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <input type="checkbox" name="remove_exercises[]" value="<?= htmlspecialchars($exercise['id_esercizio']) ?>">
                        <?= htmlspecialchars($exercise['nome']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="mb-3">
            <label for="add_exercises" class="form-label">Aggiungi Esercizi:</label>
            <select id="add_exercises" name="add_exercises[]" class="form-select" multiple>
                <?php foreach ($allExercises as $exercise): ?>
                    <option value="<?= htmlspecialchars($exercise['id_esercizio']) ?>"><?= htmlspecialchars($exercise['nome']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Salva Modifiche</button>
    </form>
</body>
</html>