<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="styles.css">
</head>
<nav>
    <ul>
        <li>
            <a href="./home.php">
            <img class="icon" src="./assets/imgs/logo_no_bg.png" alt="bird-logo">
            </a>
        </li>
            <li>
                <img class="icon" src="./assets/imgs/house-icon-nobg.png" alt="house-icon"/>
                <a href="./home.php">Home</a>
            </li>
        <li>
            <img class="icon" src="./assets/imgs/profile-icon.png" alt="profile-icon">
            <a href="./home.php">Profile</a>
        </li>
        <li>
            <div class="dropdown">
                <img class="icon" src="./assets/imgs/elipsis-icon.png" alt="elipsis-icon">
                <button>More</button>
                <div class="dropdown-content">
                    <a href="#">Lorem Ipsum</a>
                    <a href="#">Lorem Ipsum</a>
                    <a href="#">Lorem Ipsum</a>
                </div>
            </div>
        </li>
        <li><button id="post">Post</button></li>
    </ul>
</nav>
</html>