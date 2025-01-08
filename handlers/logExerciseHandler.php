<?php
include '../config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../views/login.php');
        exit;
    }

    $userId = $_SESSION['user_id'];
    $schedaId = $_POST['id_scheda'];
    $exerciseId = $_POST['id_esercizio'];
    $executionDate = $_POST['data_esecuzione'];
    $weightUsed = $_POST['carico_utilizzato'];
    $repsCompleted = $_POST['ripetizioni_eseguite'];

    if (empty($schedaId) || empty($exerciseId) || empty($executionDate) || empty($weightUsed) || empty($repsCompleted)) {
        die("All fields are required.");
    }

    $stmt = $conn->prepare(
        "INSERT INTO storico_esercizi (id_utente, id_scheda, id_esercizio, data_esecuzione, carico_utilizzato, ripetizioni_eseguite) 
        VALUES (?, ?, ?, ?, ?, ?)"
    );

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("iiisdi", $userId, $schedaId, $exerciseId, $executionDate, $weightUsed, $repsCompleted);

    if ($stmt->execute()) {
        header('Location: ../views/dashboard.php');
        exit;
    } else {
        die("Error executing query: " . $stmt->error);
    }
}
?>