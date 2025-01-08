<?php
include '../config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password']; // Password will be hashed.

    $stmt = $conn->prepare("SELECT id_utente, password FROM utente WHERE username = ?");
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id_utente'];
            header('Location: ../views/dashboard.php');
            exit;
        } else {
            echo "Invalid username or password.";
        }
        $stmt->close();
    } else {
        die("Error preparing statement: " . $conn->error);
    }
}
?>
