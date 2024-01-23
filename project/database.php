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

    try {
        $stmt = $conn->prepare("INSERT INTO users (name, last_name, email, password, avatar, admin) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $last_name, $email, $password, $avatar, $admin]);
        return $conn->lastInsertId();
    } catch (PDOException $e) {
        return false;
    }
}

function createTweet($message, $user, $image = null) {
    global $conn;

    try {
        $stmt = $conn->prepare("INSERT INTO tweets (message, image, user) VALUES (?, ?, ?)");
        $stmt->execute([$message, $image, $user]);
        return $conn->lastInsertId();
    } catch (PDOException $e) {
        return false;
    }
}

function deleteUser($userId) {
    global $conn;

    try {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$userId]);
    } catch (PDOException $e) {
        return false;
    }
}

function deleteTweet($tweetId) {
    global $conn;

    try {
        $stmt = $conn->prepare("DELETE FROM tweets WHERE id = ?");
        return $stmt->execute([$tweetId]);
    } catch (PDOException $e) {
        return false;
    }
}

function changeUserData($userId, $name, $last_name, $email, $password, $admin, $avatar = null) {
    global $conn;

    try {
        $stmt = $conn->prepare("UPDATE users SET name = ?, last_name = ?, email = ?, password = ?, avatar = ?, admin = ? WHERE id = ?");
        $stmt->execute([$name, $last_name, $email, $password, $avatar, $admin, $userId]);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

function changeTweetData($tweetId, $message, $image = null) {
    global $conn;

    try {
        $stmt = $conn->prepare("UPDATE tweets SET message = ?, image = ? WHERE id = ?");
        $stmt->execute([$message, $image, $tweetId]);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

function getUserById($userId) {
    global $conn;

    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

// for seperation of concerns
function getUserByNameAsId($name, $password) {
    global $conn;

    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE name LIKE ? AND password LIKE ?");
        $stmt->execute([$name, $password]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

function getTweetById($tweetId) {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM tweets WHERE id = ?");
        $stmt->execute([$tweetId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

function getAllUsers() {
    global $conn;

    try {
        $stmt = $conn->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

function getAllTweets() {
    global $conn;

    try {
        $stmt = $conn->prepare("SELECT * FROM tweets");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}