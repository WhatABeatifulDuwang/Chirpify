<?php include('../database.php');
session_start();
$uid = $_SESSION['user']['id'];

// This method checks if the submit button has been pressed to update the database
if (isset($_POST['submit'])){
    changeTweetData($_POST['id'], $_POST['updatedTweet'], null);
}

if (isset($_POST['likeId'])) {
    $userIdByLike = getUserIdByLike($_POST['likeId']);
    if ($userIdByLike['liked_by_user_id'] != $uid ){
        addLikeToTweet($_POST['likeId']);
        updateLikedUserId($uid, $_POST['likeId']);
    }
    else{
        removeLikeFromTweet($_POST['likeId']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../dependencies/styles/home_style.css">
    <script src="../dependencies/scripts/home_script.js"></script>
</head>
<body>
    <div class="tweetPost">
        <form method="post" action="home.php" enctype="multipart/form-data">
            <img src="../assets/imgs/profile-icon.png" alt="profile_picture" class="profile_picture">
            <label>
                <textarea placeholder="What is happening?!" name="message" required></textarea>
                <?php
                // This method saves the data which has been written in the textarea and creates a tweet in the database accordingly
                if (isset($_POST['message'])){
                    createTweet($_POST['message'], $uid);
                }
                ?>
            </label>
            <div>
                <img id="imageIcon" src="../assets/icons/add-image-icon.png" alt="imageIcon">
                <button type="submit" value="send" class="postButton">Post</button>
            </div>
        </form>
    </div>
    <div class="tweetOverview">
        <table>
            <?php
            // This method creates table data by retrieving tweet data from the database
             $tweets = getAllTweets();
             foreach($tweets as $tweet)
             {
                ?>
                <tr>
                    <td>
                        <?php
                        // This method creates variables out of the database data
                        $id = $tweet['id'];
                        $userData = getUserDataFromTweet($id);
                        $name = $userData['name'];
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
</body>
</html>