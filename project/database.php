<?php

// Database credentials
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "chirpify";

// Creating the connection with the database
try {
    $conn = new PDO("mysql:host=$dbServername;dbname=$dbName", $dbUsername, $dbPassword);
    // Creates a database if it does not exist
    $sql = "CREATE DATABASE IF NOT EXISTS chirpify";
    $conn->exec($sql);
    $sql = "use chirpify";
    $conn->exec($sql);
    // Creates the table users if it does not exist
    $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL,
            email VARCHAR(100) NOT NULL,
            password VARCHAR(255) NOT NULL,
            bio VARCHAR(255) DEFAULT NULL,
            avatar VARCHAR(255) DEFAULT NULL,
            admin INT DEFAULT 0,
            UNIQUE (username, email)
            )";
    $conn->exec($sql);
    // Creates the tweet table if it does not exist
    $sql = "CREATE TABLE IF NOT EXISTS tweets (
            id INT AUTO_INCREMENT PRIMARY KEY,
            message VARCHAR(255) NOT NULL,
            image VARCHAR(255) DEFAULT NULL,
            user INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
            likes INT DEFAULT 0,
            liked_by_user_id INT DEFAULT NULL,
            FOREIGN KEY (user) REFERENCES users(id)
            )";
    // Creates a table with foreign keys from both tables to look up the tweets which got liked
    $conn->exec($sql);
    $sql = "CREATE TABLE IF NOT EXISTS liked_tweets (
            tweet_id INT NOT NULL,
            user_id INT NOT NULL,
            PRIMARY KEY(tweet_id, user_id),
            CONSTRAINT fk_tweets
                FOREIGN KEY (tweet_id)
                REFERENCES tweets(id) ON DELETE CASCADE,
            CONSTRAINT fk_users
                FOREIGN KEY (user_id)
                REFERENCES users(id) ON DELETE CASCADE
            )";
    $conn->exec($sql);
} catch (PDOException $e) {}

function createUser($username, $email, $password, $bio, $avatar = null, $admin = 0) {
    global $conn;

    try {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, email, password, bio, avatar, admin) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$username, $email, $password, $bio, $avatar, $admin]);
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

function getUserByUsername($username) {
    global $conn;

    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

function getUserIdByUsername($username) {
    global $conn;

    try {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

function getUsernameById($userId) {
    global $conn;

    try {
        $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
        $stmt->execute([$userId]);
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

// Retrieves the user data from a tweet based on tweet id
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

// Adds a like to the database based on tweet id
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

function insertLikedUser($tweetId, $userId){
    global $conn;

    try {
        $stmt = $conn->prepare("INSERT INTO liked_tweets (tweet_id, user_id) VALUES (?, ?)");
        $stmt->execute([$tweetId, $userId]);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// Removes a like from the database based on tweet id
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

function removeLikedUser($tweetId, $userId){
    global $conn;

    try {
        $stmt = $conn->prepare("DELETE FROM liked_tweets WHERE tweet_id = ? AND user_id = ?");
        $stmt->execute([$tweetId, $userId]);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// This query updates the user id on the liked tweet
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

// This query retrieves the id from user who liked the tweet
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
    return $_SESSION['user']['id'];
}

function isCurrentUserAdmin() {
    global $conn;

    try {
        $stmt = $conn->prepare("SELECT admin FROM users WHERE id = ?");
        $stmt->execute([getCurrentUserId()]);
        if ($stmt->fetch(PDO::FETCH_ASSOC)['admin'] == 1) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        return false;
    }
}

function getUserBioById($userId){
    global $conn;

    try {
        $stmt = $conn->prepare("SELECT bio FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

function editUserprofile($username, $bio, $userId) {
    global $conn;

    try {
        $stmt = $conn->prepare("UPDATE users SET username = ?, bio = ? WHERE id = ?");
        $stmt->execute([$username, $bio, $userId]);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

function editUserprofileWithAdmin($username, $bio, $userId, $admin) {
    global $conn;

    try {
        $stmt = $conn->prepare("UPDATE users SET username = ?, bio = ?, admin = ? WHERE id = ?");
        $stmt->execute([$username, $bio, $admin, $userId]);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}