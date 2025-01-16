<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $premium = ($_POST['role'] === 'premium') ? 1 : 0;

    try {
        $stmt = $conn->prepare("INSERT INTO utente (username, password, premium) VALUES (:username, :password, :premium)");
        
        $stmt->execute([
            ':username' => $username,
            ':password' => $password,
            ':premium' => $premium
        ]);

        header('Location: ../index.php');
        exit;
        
    } catch (PDOException $e) {
        die("Registration failed: " . $e->getMessage());
    }
}
?>