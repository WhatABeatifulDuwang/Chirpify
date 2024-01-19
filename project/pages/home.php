<?php include('../database.php');?>
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
                <textarea placeholder="What is happening?!" name="message"></textarea>
                <?php
                // This method saves the data which has been written in the textarea and creates a tweet in the database accordingly
                if (isset($_POST['message'])){
                    htmlentities(createTweet($_POST['message'], 1));
                }
                ?>
            </label>
            <div>
                <input type="file" id="imageIcon" src="../assets/icons/add-image-icon.png" alt="imageIcon" accept="image/*">
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
                        $userData = getUserDataFromTweet();

                        //$name = $userData['users.name'];
                        $name = $tweet['user'];
                        $created_at = $tweet['created_at'];
                        $amountOfLikes = $tweet['likes'];

                        //echo "<b>". $name . "</b>" . " " . "<i>" . $created_at. "</i>"
                        ?>
                        <p class="userName"><?php echo $name ?></p>
                        <p class="time_posted"><?php echo $created_at ?></p>
                    </td>
                </tr>
                <tr>
                    <td class="tweetText">
                        <?php echo $tweet['message'];
                        if (isset($tweet['image'])){
                            echo $tweet['image'];
                        }
                        ?>
                    </td>
                </tr>
            <tr>
               <td class="buttonBar">
                   <?php
                        if ($amountOfLikes != 0) {
                            echo $amountOfLikes;
                        }
                   ?>
                   <img onclick="likeTweet()" id="heart" src="../assets/icons/heart-empty-icon.png" alt="empty_heart">
                   <img src="../assets/icons/reply-icon.png" alt="reply">
               </td>
            </tr>
            <?php
                }
            ?>
        </table>
    </div>
</body>
</html>