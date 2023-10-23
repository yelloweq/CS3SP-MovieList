<?php
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();
$conn = new mysqli($_ENV['SERVER_NAME'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'],$_ENV['DB_NAME']) or die("Connect failed: %s\n". $conn -> error);
?>