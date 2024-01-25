<?php
include_once('../database.php');
session_start();
$uid = $_SESSION['user']['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deleteUser'])) {
        $userId = $_POST['id'];
        deleteUser($userId);
    } elseif (isset($_POST['deleteTweet'])) {
        $tweetId = $_POST['id'];
        deleteTweet($tweetId);
    } elseif (isset($_POST['editUserDetails'])) {
        $userId = $_POST['idFrom'];
        $newUsername = $_POST['newUsername'];
        $newBio = $_POST['newBio'];
        $newAdmin = isset($_POST['newAdmin']) ? 1 : 0;

        editUserprofileWithAdmin($newUsername, $newBio, $newAdmin, $userId);
    }
}

if (!isCurrentUserAdmin() && $uid != null) {
    echo ("<script>
    window.alert('You do not have access to this place');
    window.location.href= '../pages/home.php';
    </script>");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../dependencies/styles/manage-page_style.css">
    <script src="../dependencies/scripts/manage_script.js"></script>
</head>
<body>
    <div class="content">
        <div class="editUserForm" id="editUserForm">
            <h2>Edit User Details</h2>
            <form method="post" action="manage.php">
                <input type="hidden" name="idFrom">

                <label for="newUsername">New username:</label>
                <input type="text" id="newUsername" name="newUsername" required>

                <label for="newBio">New bio:</label>
                <input type="text" id="newBio" name="newBio" required>

                <label for="newAdmin">Is admin:</label>
                <input type="checkbox" id="newAdmin" name="newAdmin">

                <div class="buttons">
                    <button type="submit" name="editUserDetails">Save</button>
                    <button onclick="hideUserEditForm()" name="cancelUserDetails" style="background-color: rgb(255,87,87);">Cancel</button>
                </div>
            </form>
        </div>

        <div class="userOverview">
            <h1>Users</h1>
            <table>
                <tr>
                    <th>Id</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Avatar</th>
                    <th>Admin</th>
                    <th>Actions</th>
                </tr>
                <?php
                // This method creates table data by retrieving user data from the database
                $users = getAllUsers();
                foreach($users as $user) {
                    ?>
                    <tr>
                        <td><?php echo $user['id'] ?></td>
                        <td><?php echo $user['username'] ?></td>
                        <td><?php echo $user['email'] ?></td>
                        <td><?php echo $user['password'] ?></td>
                        <td><?php echo $user['avatar'] ?></td>
                        <td><?php
                            if ($user['admin'] == 1) {
                                echo 'Yes';
                            } else {
                                echo 'No';
                            }
                            ?></td>
                        <td>
                            <form method="post" action="manage.php" onsubmit="return confirm('Are you sure?');">
                                <input type="hidden" name="id" value="<?php echo $user['id'] ?>">
                                <button type="submit" name="deleteUser" class="delete">Delete</button>
                            </form>
                            <button class="edit" onclick=showUserEditForm(<?php echo $user['id']?>) >Edit</button>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>

        <div class="tweetOverview">
            <h1>Tweets</h1>
            <table>
                <tr>
                    <th>Id</th>
                    <th>Message</th>
                    <th>Image</th>
                    <th>User</th>
                    <th>Create date</th>
                    <th>Liked by</th>
                    <th>Likes</th>
                    <th>Actions</th>
                </tr>
                <?php
                // This method creates table data by retrieving user data from the database
                $tweets = getAllTweets();
                foreach($tweets as $tweet) {
                    ?>
                    <tr>
                        <td><?php echo $tweet['id'] ?></td>
                        <td><?php echo $tweet['message'] ?></td>
                        <td><?php echo $tweet['image'] ?></td>
                        <td><?php echo $tweet['user'] ?></td>
                        <td><?php echo $tweet['created_at'] ?></td>
                        <td><?php echo $tweet['liked_by_user_id'] ?></td>
                        <td><?php echo $tweet['likes'] ?></td>
                        <td>
                            <form method="post" action="manage.php" onsubmit="return confirm('Are you sure?');">
                                <input type="hidden" name="id" value="<?php echo $tweet['id'] ?>">
                                <button type="submit" name="deleteTweet" class="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>