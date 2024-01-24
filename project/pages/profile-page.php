<?php include('../database.php');
session_start();
$uid = $_SESSION['user']['id'];

if (isset($_POST['submit'])){
    $newUsername = $_POST['new_username'];
    $newBio = $_POST['new_bio'];

    $result = editUserprofile($newUsername, $newBio);
    $_SESSION['user']['username'] = $newUsername;
}

$currentUsername = $_SESSION['user']['username'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twitter Profile Page</title>
    <link rel="stylesheet" href="../dependencies/styles/profile-page_style.css">
    <script src="../dependencies/scripts/profile-page_script.js"></script>
</head>
<body>
    <div class="container">
        <div class="profile-background">
            <img src="../assets/imgs/profile-background.png" alt="Profile cover">
        </div>
        <div class="profile-info">
                <img src="../assets/imgs/default_profile.png" alt="Profile picture">
                    <h2><?php echo $currentUsername?></h2>
                    <p><?php echo '@'. $currentUsername?></p>
                    <h3>About me:</h3>
                    <?php
                    foreach(getUserBioById($uid) as $userBio);
                    ?>
                    <h1><?php echo($userBio)?></h1>
                </div>
                <div class="edit-profile">
                <button onclick="showEditForm()">Edit Profile</button>
                <div class="edit-form">
                    <form action="profile-page.php" method="post">
                        <label for="new_username">Username:</label>
                        <input type="text" name="new_username" id="new_username" value="<?php echo $currentUsername; ?>"><br>
                        <label for="new_bio">Bio:</label>
                        <textarea name="new_bio" id="new_bio"><?php echo $userBio; ?></textarea><br>
                        <button type="submit" name="submit">Update Profile</button>
                    </form>
                </div>
            </div>
            </div>
        <div class="profile-content">
        <p>Tweets<p>
        <div class="tweet">
        <table>
            <?php
            // This method creates table data by retrieving tweet data from the current user from the database
            $tweets = getAllTweets();
            $currentUserTweets = array_filter($tweets, function($tweet) use ($uid) {
                return $tweet['user'] == $uid;
            });        
            foreach($currentUserTweets as $tweet)
            {
                ?>
                <tr>
                    <td>
                        <?php
                        // This method creates variables out of the database data
                        $id = $tweet['id'];
                        $userData = getUserDataFromTweet($id);
                        $name = $userData['username'];
                        $created_at = $tweet['created_at'];
                        $amountOfLikes = $tweet['likes'];
                        ?>
                        <p class="userName"><?php echo '@' . $name ?></p>
                        <p class="time_posted"><?php echo $created_at ?></p>
                        <?php if ($uid == $userData['id']): ?>
                        <button onclick="editTweet(<?php echo $id ?>)" class="edit">Edit</button>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td class="tweetText">
                        <form method="post" action="home.php">
                        <?php
                        $message = $tweet['message'];

                        // This method checks if an image is set, if so it will be shown
                        if (isset($tweet['image'])){
                            echo $tweet['image'];
                        }
                        ?>
                            <label id="<?php echo "textLabel" . $id?>" for="<?php echo "updateText" . $id?>"><?php echo str_repeat("&nbsp", 6) . $message?></label>
                            <input type="hidden" id="<?php echo "updateText" . $id?>" name="updatedTweet" value="<?php echo $message?>">
                            <input type="hidden" name="id" value="<?php echo $id?>">
                            <input type="hidden" id="<?php echo "submitButton" . $id?>" name="submit" value="Submit">
                        </form>
                    </td>
                </tr>
            <tr>
               <td class="buttonBar">
                   <form method="post" action="home.php">
                       <?php
                       // This method checks if the amount of likes has exceeded zero, if so the amount will be shown
                       if ($amountOfLikes != 0) {
                           if ($amountOfLikes < 10 && $amountOfLikes > 0){
                               echo $amountOfLikes . "&nbsp;&nbsp;";
                           }
                           else{
                               echo $amountOfLikes;
                           }
                       }
                       else {
                           echo str_repeat("&nbsp", 4);
                       }
                       ?>
                       <input type="submit" id="hiddenButton" name="likeId" value="<?php echo $id?>">
                       <img onclick="likeTweet(<?php echo $id?>);" id="<?php echo "heart" . $id?>" src="../assets/icons/heart-empty-icon.png" alt="empty_heart">
                       <img src="../assets/icons/reply-icon.png" alt="reply">
                   </form>
               </td>
            </tr>
            <?php
                }
            ?>
        </table>
            </div>
        </div>
    </div>
</body>
</html>