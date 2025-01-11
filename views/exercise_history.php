<?php
include '../config/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];

// Recupera lo storico degli esercizi dell'utente
$stmt = $conn->prepare(
    "SELECT s.titolo AS scheda, e.nome AS esercizio, se.data_esecuzione, se.carico_utilizzato, se.ripetizioni_eseguite 
     FROM storico_esercizi se
     JOIN scheda s ON se.id_scheda = s.id_scheda
     JOIN esercizo e ON se.id_esercizio = e.id_esercizio
     WHERE se.id_utente = ?
     ORDER BY se.data_esecuzione DESC"
);
$stmt->bind_param("i", $userId);
$stmt->execute();
$history = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storico Esercizi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Storico Esercizi</h1>
        <a href="dashboard.php" class="btn btn-secondary">Torna alla Dashboard</a>
    </div>

    <?php if (!empty($history)): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Scheda</th>
                    <th>Esercizio</th>
                    <th>Carico Utilizzato (kg)</th>
                    <th>Ripetizioni Eseguite</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($history as $record): ?>
                    <tr>
                        <td><?= htmlspecialchars($record['data_esecuzione']) ?></td>
                        <td><?= htmlspecialchars($record['scheda']) ?></td>
                        <td><?= htmlspecialchars($record['esercizio']) ?></td>
                        <td><?= htmlspecialchars($record['carico_utilizzato']) ?></td>
                        <td><?= htmlspecialchars($record['ripetizioni_eseguite']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">Nessuno storico degli esercizi trovato.</p>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>