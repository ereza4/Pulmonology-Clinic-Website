<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$host = 'localhost';
$dbname = 'klinika_db';
$user = 'root';
$password = '1234';

try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $conn = new PDO($dsn, $user, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   // echo "Connected to klinika_db!";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
