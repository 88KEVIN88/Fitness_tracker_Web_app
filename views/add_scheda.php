<?php
include '../config/db.php';

// Controlla la connessione al database
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Recupera gli esercizi
$result = $conn->query("SELECT * FROM esercizo");
if (!$result) {
    die("Errore nel recupero degli esercizi: " . $conn->error);
}
$exercises = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Nuova Scheda</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optional: Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Crea una nuova scheda</h1>
        <a href="dashboard.php" class="btn btn-secondary">Torna alla Dashboard</a>
    </div>
        <form method="POST" action="../handlers/addSchedaHandler.php" class="p-4 border rounded shadow-sm bg-light">
            <div class="mb-3">
                <label for="title" class="form-label">Titolo della Scheda:</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descrizione:</label>
                <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="exercises" class="form-label">Seleziona Esercizi:</label>
                <select id="exercises" name="exercises[]" class="form-select" multiple required>
                    <?php foreach ($exercises as $exercise): ?>
                        <option value="<?= htmlspecialchars($exercise['id_esercizio']) ?>">
                            <?= htmlspecialchars($exercise['nome']) ?> - <?= htmlspecialchars($exercise['descrizione']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Crea Scheda</button>
        </form>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
