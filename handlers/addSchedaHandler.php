<?php
include '../config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    

    $userId = $_SESSION['user_id']; // Recupera l'ID utente
    $title = $_POST['title'];
    $description = $_POST['description'];
    $exercises = $_POST['exercises'];

    if (empty($title) || empty($description) || empty($exercises)) {
        die("All fields are required.");
    }

    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare("INSERT INTO scheda (id_utente, titolo, descrizione) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $userId, $title, $description);
        $stmt->execute();

        $schedaId = $stmt->insert_id;

        $stmtLink = $conn->prepare("INSERT INTO carico (id_scheda, id_esercizio, carico_iniziale) VALUES (?, ?, ?)");
        foreach ($exercises as $exerciseId) {
            $initialWeight = 0;
            $stmtLink->bind_param("iid", $schedaId, $exerciseId, $initialWeight);
            $stmtLink->execute();
        }

        $conn->commit();
        header('Location: ../views/dashboard.php');
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        die("Transaction failed: " . $e->getMessage());
    }
}
?>
