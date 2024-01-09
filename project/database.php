<?php

// Database credentials
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "chirpify";

// Creating the connection with the database
try {
    $conn = new PDO("mysql:host=$dbServername;dbname=$dbName", $dbUsername, $dbPassword);
} catch (PDOException $e) {}

function createUser($name, $last_name, $email, $password, $avatar = null, $admin = 0) {
    global $conn;

    $stmt = $conn->prepare("INSERT INTO users (name, last_name, email, password, avatar, admin) VALUES (?, ?, ?, ?, ?, ?)");
    try {
        $stmt->execute([$name, $last_name, $email, $password, $avatar, $admin]);
        return $conn->lastInsertId();
    } catch (PDOException $e) {
        return false;
    }
}