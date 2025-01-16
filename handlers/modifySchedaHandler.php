<?php
include '../config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $schedaId = $_POST['id_scheda'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $removeExercises = isset($_POST['remove_exercises']) ? $_POST['remove_exercises'] : [];
    $addExercises = isset($_POST['add_exercises']) ? $_POST['add_exercises'] : [];

    try {
        $conn->beginTransaction();

        // Update scheda details
        $stmt = $conn->prepare("UPDATE scheda SET titolo = :title, descrizione = :description WHERE id_scheda = :schedaId");
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':schedaId' => $schedaId
        ]);

        // Remove selected exercises
        if (!empty($removeExercises)) {
            $stmtRemove = $conn->prepare("DELETE FROM carico WHERE id_scheda = :schedaId AND id_esercizio = :exerciseId");
            foreach ($removeExercises as $exerciseId) {
                $stmtRemove->execute([
                    ':schedaId' => $schedaId,
                    ':exerciseId' => $exerciseId
                ]);
            }
        }

        // Add new exercises
        if (!empty($addExercises)) {
            $stmtAdd = $conn->prepare("INSERT INTO carico (id_scheda, id_esercizio, carico_iniziale) VALUES (:schedaId, :exerciseId, :weight)");
            foreach ($addExercises as $exerciseId) {
                $stmtAdd->execute([
                    ':schedaId' => $schedaId,
                    ':exerciseId' => $exerciseId,
                    ':weight' => 0
                ]);
            }
        }

        $conn->commit();
        header('Location: ../views/dashboard.php');
        exit();
    } catch (PDOException $e) {
        $conn->rollBack();
        die("Errore nell'aggiornamento della scheda: " . $e->getMessage());
    }
}
?>