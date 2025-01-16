<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'fitness_tracker';

try {
    $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";
    $conn = new PDO($dsn, $username, $password);
    
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>