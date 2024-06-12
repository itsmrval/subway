<?php

try {
    $conn = new PDO("mysql:host=$db_host", $db_user, $db_password);
    $conn->exec("CREATE DATABASE IF NOT EXISTS $db_name");
    $conn->exec("USE $db_name");

    $conn->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        firstName VARCHAR(50) NOT NULL,
        lastName VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        is_admin BOOLEAN NOT NULL DEFAULT 0
    )");

    $conn->exec("CREATE TABLE IF NOT EXISTS favorites (
        id INT AUTO_INCREMENT PRIMARY KEY,
        userId INT NOT NULL,
        stopId INT NOT NULL,
        lineId INT NOT NULL,
        FOREIGN KEY (userId) REFERENCES users(id)
    )");



} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
