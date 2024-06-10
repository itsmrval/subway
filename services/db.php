<?php

try {
    $conn = new PDO("mysql:host=127.0.0.1", "root", "lynqo");
    $conn->exec("CREATE DATABASE IF NOT EXISTS subwaySchedule");
    $conn->exec("USE subwaySchedule");

    $conn->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        firstName VARCHAR(50) NOT NULL,
        lastName VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        is_admin BOOLEAN NOT NULL DEFAULT 0
    )");



} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
