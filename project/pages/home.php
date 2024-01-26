<?php include('../database.php');
session_start();
// Creates an integer variable from the session
$uid = $_SESSION['user']['id'];

// This method checks if the submit button has been pressed to update the database
if (isset($_POST['submit'])){
    changeTweetData($_POST['id'], $_POST['updatedTweet'], null);
}

// If the submit button for like has been pressed, updates the database
if (isset($_POST['likeId'])) {
    $userIdByLike = getUserIdByLike($_POST['likeId']);
    
    // If the retrieved id from the like is not the same as the user id from session, it will add a like and update the liked user id
    if ($userIdByLike['liked_by_user_id'] != $uid ){
        addLikeToTweet($_POST['likeId']);
        updateLikedUserId($uid, $_POST['likeId']);
        insertLikedUser($_POST['likeId'], $uid);
        $imageUrl = "../assets/icons/heart-full-icon.png"; 
    }
    // If the id from the session is the same, it will remove a like from the database
    else{
        removeLikeFromTweet($_POST['likeId']);
        removeLikedUser($_POST['likeId'], $uid);
        $imageUrl = "../assets/icons/heart-empty-icon.png"; 
    }
}

if (isset($_POST['deleteTweetId'])) {
    $deleteSuccess = deleteTweet($_POST['deleteTweetId']);
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
                // This method checks if the data has been set and creates a tweet in the database accordingly
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
                        $name = $userData['username'];
                        $created_at = $tweet['created_at'];
                        $amountOfLikes = $tweet['likes'];
                        ?>
                        <p class="userName"><?php echo '@' . $name ?></p>
                        <p class="time_posted"><?php echo $created_at ?></p>
                        <?php
                        // This method checks if session user has the same id as the user id from the tweet, if so only show edit for those posts
                        if ($uid == $userData['id']): ?>
                            <button onclick="editTweet(<?php echo $id ?>)" class="edit">Edit</button>
                            <form method="post" action="home.php" onsubmit="return confirm('Are you sure?');">
                                <input type="hidden" name="deleteTweetId" value="<?php echo $id ?>">
                                <button type="submit" class="delete">Delete</button>
                            </form>
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
                           // Repeats a string four times, which is a whitespace here
                           echo str_repeat("&nbsp", 4);
                       }
                        // Checks if the user has liked their own comment, depending on the awnser change the img url
                       if ($uid == $tweet["liked_by_user_id"]){
                        $imageUrl = "../assets/icons/heart-full-icon.png"; 
                       }else{
                        $imageUrl = "../assets/icons/heart-empty-icon.png"; 
                       }
                       ?>
                       <input type="submit" id="hiddenButton" name="likeId" value="<?php echo $id?>">
                       <img onclick="likeTweet(<?php echo $id?>);" id="<?php echo "heart" . $id?>" src="<?php echo $imageUrl; ?>" alt="empty_heart">
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