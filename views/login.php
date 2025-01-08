<?php
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepara e verifica i dati
    $stmt = $conn->prepare("SELECT id_utente, password FROM utenti WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Salva l'ID utente nella sessione
        $_SESSION['user_id'] = $user['id_utente'];
        header('Location: ../views/dashboard.php');
        exit();
    } else {
        die("Invalid email or password.");
    }
}
?>
