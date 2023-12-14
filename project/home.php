<?php include_once('database.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="dependencies/styles/home_style.css">
    <script src="dependencies/scripts/home_script.js"></script>
</head>
<body>
    <div class="row">
        <div class="navbar">
            <?php include "navbar.html" ?>
        </div>
        <div class="column">
            <div class="tweetPost">
                <form>
                    <img src="./assets/imgs/profile-icon.png" alt="profile_picture">
                    <label>
                        <textarea placeholder="What is happening?!"></textarea>
                    </label>
                    <button type="submit">Post</button>
                </form>
            </div>
            <div class="tweetOverview">
                <table>
                    <?php
                    /*
                        $tweets = getAllTweets();
                        foreach($tweets as $tweet)
                        {
                    */
                        ?>
                        <tr>
                            <td class="userName">
                                <p>@Name</p>
                                <?php /* echo $tweet['userId']; */?>
                            </td>
                            <td class="time_posted">
                                <p>2d</p>
                                <?php /* echo $tweet['createdAt']; */?>
                            </td>
                        </tr>
                        <tr>
                            <td class="tweetText">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                                <?php /* echo $tweet['message']; */?>
                            </td>
                        </tr>
                    <tr>
                       <td class="buttonBar">
                           <img onclick="likeTweet(0)" id="heart" src="./assets/icons/heart-empty-icon.png" alt="empty_heart">
                           <img src="./assets/icons/reply-icon.png" alt="reply">
                       </td>
                    </tr>
                    <?php
                    /*
                        }
                      */
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>