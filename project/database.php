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

function createUser($username, $email, $password, $avatar = null, $admin = 0) {
    global $conn;

    try {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, avatar, admin) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$username, $email, $password, $avatar, $admin]);
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

function changeUserData($userId, $username, $email, $password, $admin, $avatar = null) {
    global $conn;

    try {
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, password = ?, avatar = ?, admin = ? WHERE id = ?");
        $stmt->execute([$username, $email, $password, $avatar, $admin, $userId]);
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
function getUserByNameAsId($username, $password) {
    global $conn;

    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username LIKE ? AND password LIKE ?");
        $stmt->execute([$username, $password]);
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
        $stmt = $conn->prepare("SELECT * FROM tweets ORDER BY created_at DESC; ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

function getUserDataFromTweet($tweetId){
    global $conn;

    try {
        $stmt = $conn->prepare("SELECT * FROM tweets JOIN users ON tweets.user = users.id WHERE tweets.id=?");
        $stmt->execute([$tweetId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

function addLikeToTweet($tweetId){
    global $conn;

    try {
        $stmt = $conn->prepare("UPDATE tweets SET likes = likes + 1, liked_by_user_id = tweets.user WHERE id = ?");
        $stmt->execute([$tweetId]);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

function removeLikeFromTweet($tweetId){
    global $conn;

    try {
        $stmt = $conn->prepare("UPDATE tweets SET likes = likes - 1, liked_by_user_id = null WHERE id = ?");
        $stmt->execute([$tweetId]);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

function updateLikedUserId($userId, $tweetId){
    global $conn;

    try{
        $stmt = $conn->prepare("UPDATE tweets SET liked_by_user_id = ? WHERE id = ?");
        $stmt->execute([$userId, $tweetId]);
        return true;
    } catch (PDOException $e){
        return false;
    }
}

function getUserIdByLike($tweetId){
    global $conn;

    try {
        $stmt = $conn->prepare("SELECT tweets.liked_by_user_id FROM tweets WHERE id = ?");
        $stmt->execute([$tweetId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

function getCurrentUserId() {
    return $_SESSION['userId'];
}