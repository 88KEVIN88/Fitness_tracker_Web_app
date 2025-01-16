<?php
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Prepara e verifica i dati
        $stmt = $conn->prepare("SELECT id_utente, password FROM utenti WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Salva l'ID utente nella sessione
            $_SESSION['user_id'] = $user['id_utente'];
            header('Location: ../views/dashboard.php');
            exit();
        } else {
            die("Invalid email or password.");
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>