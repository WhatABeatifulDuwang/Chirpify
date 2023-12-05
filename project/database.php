<?php

/**
 * Database Class Documentation
 *
 * Overview:
 * The Database class is a PHP class designed for basic database interactions using PDO (PHP Data Objects).
 * It includes methods for database connection, table creation, and various user and tweet operations.
 *
 * Class Structure:
 *
 * Constructor:
 * __construct($servername, $username, $password, $dbname)
 * - Initializes a new database connection using PDO.
 * - Parameters:
 *   - $servername: The name of the server.
 *   - $username: The database username.
 *   - $password: The database password.
 *   - $dbname: The name of the database.
 *
 * Public Methods:
 *
 * execute($sql, $params = [])
 * - Executes a generic SQL query with optional parameters.
 * - Parameters:
 *   - $sql: SQL query string.
 *   - $params: An array of parameters to bind to the SQL query.
 *
 * createUser($name, $last_name, $email, $password, $avatar = 'img/default_profile.png')
 * - Creates a new user record in the database.
 * - Parameters:
 *   - $name: User's first name.
 *   - $last_name: User's last name.
 *   - $email: User's email address.
 *   - $password: User's hashed password.
 *   - $avatar: (Optional) User's avatar image path. Defaults to 'img/default_profile.png'.
 *
 * getUserById($userId)
 * - Retrieves user information by user ID.
 * - Parameters:
 *   - $userId: User ID.
 * - Returns: Associative array containing user information.
 *
 * createTweet($message, $userId, $createdAt, $image = null)
 * - Creates a new tweet record in the database.
 * - Parameters:
 *   - $message: Tweet message.
 *   - $userId: ID of the user who created the tweet.
 *   - $createdAt: Creation timestamp of the tweet.
 *   - $image: (Optional) Image path associated with the tweet.
 *
 * getTweetById($tweetId)
 * - Retrieves tweet information by tweet ID.
 * - Parameters:
 *   - $tweetId: Tweet ID.
 * - Returns: Associative array containing tweet information.
 *
 * getAllTweets()
 * - Retrieves all tweets from the database.
 * - Returns: Array of associative arrays containing tweet information.
 *
 * getAllUsers()
 * - Retrieves all users from the database.
 * - Returns: Array of associative arrays containing user information.
 *
 * setAdminStatus($userId, $isAdmin)
 * - Updates the admin status of a user in the database.
 * - Parameters:
 *   - $userId: User ID.
 *   - $isAdmin: Boolean indicating admin status.
 */
class Database {
    private $conn;

    public function __construct($servername, $username, $password, $dbname) {
        try {
            $this->conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->createTables(); // Call the method to create tables
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    // Generic execute method
    public function execute($sql, $params = []) {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            die($sql . "<br>" . $e->getMessage());
        }
    }

    // Method to create tables
    private function createTables() {
        // Inside the createTables method
        $this->execute("
      CREATE TABLE IF NOT EXISTS users (
        id CHAR(36) PRIMARY KEY NOT NULL,
        name VARCHAR(255) NOT NULL,
        last_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        avatar VARCHAR(255) NOT NULL,
        admin BOOLEAN NOT NULL DEFAULT false -- New column for ADMIN status, default to false
      )
    ");

        // Create tweets table
        $this->execute("
      CREATE TABLE IF NOT EXISTS tweets (
        id VARCHAR(36) PRIMARY KEY NOT NULL,
        message VARCHAR(255) NOT NULL,
        image CHAR(36) NULL, -- Allow NULL values
        user CHAR(36) NOT NULL,
        created_at TIMESTAMP NOT NULL,
        FOREIGN KEY (user) REFERENCES users(id)
      )
    ");

        $this->execute("
      CREATE INDEX IF NOT EXISTS idx_user ON tweets (user)
    ");
    }

    // Users table methods

    public function getUserById($userId) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->execute($sql, [$userId]);
        // Inside the getUserById method or wherever you fetch user data
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        $userData['admin'] = (bool) $userData['admin'];
        return $userData;
    }

    public function createUser($name, $last_name, $email, $password, $avatar = 'img/default_profile.png') {
        $id = uniqid(); // Generate a unique user ID
        // Inside the createUser method
        $sql = "INSERT INTO users (id, name, last_name, email, password, avatar, admin) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $this->execute($sql, [$id, $name, $last_name, $email, $password, $avatar, 0]); // Use 0 for false
    }

    // Tweets table methods

    public function getTweetById($tweetId) {
        $sql = "SELECT * FROM tweets WHERE id = ?";
        $stmt = $this->execute($sql, [$tweetId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createTweet($message, $userId, $createdAt, $image = null) {
        $id = uniqid(); // Generate a unique tweet ID
        $sql = "INSERT INTO tweets (id, message, image, user, created_at) VALUES (?, ?, ?, ?, ?)";
        $this->execute($sql, [$id, $message, $image, $userId, $createdAt]);
    }

    public function getAllTweets() {
        $sql = "SELECT * FROM tweets";
        $stmt = $this->execute($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllUsers() {
        $sql = "SELECT * FROM users";
        $stmt = $this->execute($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function setAdminStatus($userId, $isAdmin) {
        $sql = "UPDATE users SET admin = ? WHERE id = ?";
        $this->execute($sql, [$isAdmin, $userId]);
    }
}
