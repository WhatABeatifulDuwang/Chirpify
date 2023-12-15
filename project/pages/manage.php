<?php
include_once('../database.php');

// Handle form submissions for creating users and updating tweets
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database('127.0.0.1', 'root', '', 'chirpify');

    if (isset($_POST['create_user'])) {
        // Handle create user operation
        $name = $_POST['new_name'];
        $last_name = $_POST['new_last_name'];
        $email = $_POST['new_email'];
        $password = password_hash($_POST['new_password'], PASSWORD_DEFAULT); // Hash the password

        $db->createUser($name, $last_name, $email, $password);
    } elseif (isset($_POST['update_tweet'])) {
        // Handle update tweet operation
        $tweetId = $_POST['tweet_id'];
        $message = $_POST['updated_tweet'];

        $db->updateTweet($tweetId, $message);
    }
}

// Handle form submissions for editing, deleting users, and deleting tweets
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit'])) {
        $userId = $_POST['user_id'];

        $db = new Database('127.0.0.1', 'root', '', 'chirpify');
        $userData = $db->getUserById($userId);

        $name = $_POST['name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $isAdmin = isset($_POST['admin']) ? 1 : 0;

        $db->updateUser($userId, $name, $last_name, $email, $isAdmin);
    } elseif (isset($_POST['delete'])) {
        // Handle delete user operation
        $userId = $_POST['user_id'];

        $db = new Database('127.0.0.1', 'root', '', 'chirpify');
        $db->deleteUser($userId);
    } elseif (isset($_POST['delete_tweet'])) {
        // Handle delete tweet operation
        $tweetId = $_POST['tweet_id'];

        $db = new Database('127.0.0.1', 'root', '', 'chirpify');
        $db->deleteTweet($tweetId);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Page</title>
    <link rel="stylesheet" href="../dependencies/styles/manage-page_style.css">
</head>
<body>
<div class="admin-container">
    <h1>Manage Panel</h1>

    <!-- Form for creating a new user -->
    <form method="post" action="">
        <label for="new_name">Name:</label>
        <input type="text" name="new_name" required>

        <label for="new_last_name">Last Name:</label>
        <input type="text" name="new_last_name" required>

        <label for="new_email">Email:</label>
        <input type="email" name="new_email" required>

        <label for="new_password">Password:</label>
        <input type="password" name="new_password" required>

        <button type="submit" name="create_user">Create User</button>
    </form>

    <!-- Form for updating a tweet -->
    <form method="post" action="">
        <label for="updated_tweet">Updated Tweet:</label>
        <textarea name="updated_tweet" rows="4" required></textarea>

        <label for="tweet_id">Select Tweet:</label>
        <select name="tweet_id" required>
            <?php
            // Display tweets in a dropdown for selecting a tweet to update
            $tweets = $db->getAllTweets();

            foreach ($tweets as $tweet) {
                echo "<option value='{$tweet['id']}'>Tweet ID: {$tweet['id']}</option>";
            }
            ?>
        </select>

        <button type="submit" name="update_tweet">Update Tweet</button>
    </form>

    <!-- Table for editing and deleting users and tweets -->
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Admin</th>
            <th>Action</th>
            <th>View Tweets</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Display users in a table for editing and deleting
        $users = $db->getAllUsers();

        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>{$user['id']}</td>";
            echo "<td>{$user['name']}</td>";
            echo "<td>{$user['last_name']}</td>";
            echo "<td>{$user['email']}</td>";
            echo "<td><input type='checkbox' name='admin' " . ($user['admin'] ? 'checked' : '') . " disabled></td>";
            echo "<td>
                            <form method='post' action=''>
                                <input type='hidden' name='user_id' value='{$user['id']}'>
                                <input type='text' name='name' value='{$user['name']}'>
                                <input type='text' name='last_name' value='{$user['last_name']}'>
                                <input type='text' name='email' value='{$user['email']}'>
                                <input type='checkbox' name='admin' " . ($user['admin'] ? 'checked' : '') . ">
                                <button type='submit' name='edit'>Edit</button>
                                <button type='submit' name='delete'>Delete</button>
                            </form>
                        </td>";
            echo "<td><a href='view_tweets.php?user_id={$user['id']}'>View Tweets</a></td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>