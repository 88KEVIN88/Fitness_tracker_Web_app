<?php
include '../config/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../views/login.php');
    exit;
}

if (isset($_GET['id'])) {
    $schedaId = $_GET['id'];

    try {
        $conn->beginTransaction();

        // Delete exercises associated with the scheda
        $stmtDeleteExercises = $conn->prepare("DELETE FROM carico WHERE id_scheda = :schedaId");
        $stmtDeleteExercises->execute([':schedaId' => $schedaId]);

        // Delete the scheda
        $stmtDeleteScheda = $conn->prepare("DELETE FROM scheda WHERE id_scheda = :schedaId");
        $stmtDeleteScheda->execute([':schedaId' => $schedaId]);

        $conn->commit();
        header('Location: ../views/dashboard.php');
        exit();
    } catch (PDOException $e) {
        $conn->rollBack();
        die("Errore nell'eliminazione della scheda: " . $e->getMessage());
    }
} else {
    header('Location: ../views/dashboard.php');
    exit();
}
?>