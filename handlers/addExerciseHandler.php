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

    $conn->begin_transaction();

    try {
        // Se una nuova descrizione è stata fornita, aggiungila nella tabella esercizi_descrizione
        if (!empty($newDescription)) {
            $stmtDescription = $conn->prepare("INSERT INTO esercizi_descrizione (nome_esercizio, descrizione_esecuzione) VALUES (?, ?)");
            if (!$stmtDescription) {
                throw new Exception("Error preparing statement for new description: " . $conn->error);
            }

            $stmtDescription->bind_param("ss", $exerciseName, $newDescription);
            $stmtDescription->execute();

            // Recupera l'ID della nuova descrizione
            $descriptionId = $stmtDescription->insert_id;
        }

        // Inserisci l'esercizio nella tabella esercizo
        $stmtExercise = $conn->prepare(
            "INSERT INTO esercizo (nome, descrizione, serie_predefinite, ripetizioni_predefinite, id_tipo, id_descrizionee) 
            VALUES (?, ?, ?, ?, ?, ?)"
        );
        if (!$stmtExercise) {
            throw new Exception("Error preparing statement for exercise: " . $conn->error);
        }

        $stmtExercise->bind_param("ssiiii", $exerciseName, $description, $series, $repetitions, $typeId, $descriptionId);
        $stmtExercise->execute();

        $conn->commit();
        header('Location: ../views/dashboard.php');
        exit;
    } catch (Exception $e) {
        $conn->rollback();
        die("Transaction failed: " . $e->getMessage());
    }
}
?>
