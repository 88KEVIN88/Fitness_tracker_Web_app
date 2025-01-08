<?php
include '../config/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM scheda WHERE id_utente = ?");
if ($stmt) {
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $schede = $result->fetch_all(MYSQLI_ASSOC);
} else {
    die("Error preparing statement: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Le tue schede</h1>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
    <div class="mb-3">
        <a href="add_scheda.php" class="btn btn-primary">Nuova scheda</a>
        <a href="add_exercise.php" class="btn btn-success">Aggiungi esercizis</a>
        <a href="log_exercise.php" class="btn btn-warning">Registra esercizio</a>
        <a href="exercise_history.php" class="btn btn-info">Storico</a>
    </div>
    <ul class="list-group">
        <?php foreach ($schede as $scheda): ?>
            <li class="list-group-item">
                <h5><?= htmlspecialchars($scheda['titolo']) ?>:</h5>
                <p><?= htmlspecialchars($scheda['descrizione']) ?></p>
                <ul class="list-group mt-2">
                    <?php
                    $stmtExercises = $conn->prepare(
                        "SELECT e.nome, e.descrizione, c.carico_iniziale FROM carico c 
                        JOIN esercizo e ON c.id_esercizio = e.id_esercizio 
                        WHERE c.id_scheda = ?"
                    );
                    if ($stmtExercises) {
                        $stmtExercises->bind_param("i", $scheda['id_scheda']);
                        $stmtExercises->execute();
                        $resultExercises = $stmtExercises->get_result();
                        $exercises = $resultExercises->fetch_all(MYSQLI_ASSOC);

                        if (!empty($exercises)) {
                            foreach ($exercises as $exercise): ?>
                                <li class="list-group-item">
                                    <strong><?= htmlspecialchars($exercise['nome']) ?>:</strong> <?= htmlspecialchars($exercise['descrizione']) ?>
                                    (Carico iniziale <?= htmlspecialchars($exercise['carico_iniziale']) ?> kg)
                                </li>
                            <?php endforeach;
                        } else {
                            echo "<li class='list-group-item'>No exercises found for this scheda.</li>";
                        }
                    } else {
                        echo "<li class='list-group-item'>Error retrieving exercises.</li>";
                    }
                    ?>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
