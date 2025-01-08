<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $premium = ($_POST['role'] === 'premium') ? 1 : 0;

    $sql = "INSERT INTO utente (username, password, premium) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Check if the statement preparation failed
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ssi", $username, $password, $premium);

    if ($stmt->execute()) {
        header('Location: ../index.php');
    } else {
        die("Error executing query: " . $stmt->error);
    }
}
?>
