<?php
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();
$conn = new mysqli($_ENV['HOST_NAME'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'],$_ENV['DB_NAME']) or die("Connect failed: %s\n". $conn -> error);
session_start();
function getUserID() {
    global $conn;

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $query = "SELECT id FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            return $row['id'];
        }
    }

    return null;
} 
?>