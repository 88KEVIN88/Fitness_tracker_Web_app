<?php
include '../config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../views/login.php');
        exit;
    }

    $userId = $_SESSION['user_id'];
    $exerciseName = $_POST['exercise_name'];
    $description = $_POST['description'];
    $series = $_POST['series'];
    $repetitions = $_POST['repetitions'];
    $typeId = $_POST['type_id'];
    $descriptionId = $_POST['description_id'];
    $newDescription = $_POST['new_description'];

    if (empty($exerciseName) || empty($description) || empty($series) || empty($repetitions) || empty($typeId)) {
        die("All fields are required.");
    }

    try {
        $conn->beginTransaction();

        // If a new description is provided, add it to esercizi_descrizione table
        if (!empty($newDescription)) {
            $stmtDescription = $conn->prepare("INSERT INTO esercizi_descrizione (nome_esercizio, descrizione_esecuzione) VALUES (:nome, :descrizione)");
            
            $stmtDescription->execute([
                ':nome' => $exerciseName,
                ':descrizione' => $newDescription
            ]);

            // Get the ID of the new description
            $descriptionId = $conn->lastInsertId();
        }

        // Insert exercise into esercizo table
        $stmtExercise = $conn->prepare(
            "INSERT INTO esercizo (nome, descrizione, serie_predefinite, ripetizioni_predefinite, id_tipo, id_descrizionee) 
            VALUES (:nome, :descrizione, :serie, :ripetizioni, :tipo, :desc_id)"
        );

        $stmtExercise->execute([
            ':nome' => $exerciseName,
            ':descrizione' => $description,
            ':serie' => $series,
            ':ripetizioni' => $repetitions,
            ':tipo' => $typeId,
            ':desc_id' => $descriptionId
        ]);

        $conn->commit();
        header('Location: ../views/dashboard.php');
        exit;
        
    } catch (PDOException $e) {
        $conn->rollBack();
        die("Transaction failed: " . $e->getMessage());
    }
}
?>