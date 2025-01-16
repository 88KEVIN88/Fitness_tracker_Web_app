<?php
include '../config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $exercises = $_POST['exercises'];

    if (empty($title) || empty($description) || empty($exercises)) {
        die("All fields are required.");
    }

    try {
        $conn->beginTransaction();

        // Insert into scheda table
        $stmt = $conn->prepare("INSERT INTO scheda (id_utente, titolo, descrizione) VALUES (:userId, :title, :description)");
        $stmt->execute([
            ':userId' => $userId,
            ':title' => $title,
            ':description' => $description
        ]);

        $schedaId = $conn->lastInsertId();

        // Insert exercise links
        $stmtLink = $conn->prepare("INSERT INTO carico (id_scheda, id_esercizio, carico_iniziale) VALUES (:schedaId, :exerciseId, :weight)");
        foreach ($exercises as $exerciseId) {
            $stmtLink->execute([
                ':schedaId' => $schedaId,
                ':exerciseId' => $exerciseId,
                ':weight' => 0
            ]);
        }

        $conn->commit();
        header('Location: ../views/dashboard.php');
        exit();
    } catch (PDOException $e) {
        $conn->rollBack();
        die("Transaction failed: " . $e->getMessage());
    }
}
?>