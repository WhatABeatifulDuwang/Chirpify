<?php
session_start();
if (!isset($_SESSION['user']['id']) || empty($_SESSION['user']['id'])) {
    header('Location: login_page.php');
    exit();
}

if (isset($_POST['logout'])) {
    unset($_SESSION['user']['id']);
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../dependencies/styles/parent_style.css">
    <script src="../dependencies/scripts/parent-page_script.js"></script>
</head>
<body>
<div class="row">
    <div class="navbar">
    <nav>
    <ul>
        <li>
            <button onclick="showPage('../pages/home.php')">
            <img class="icon" src="../assets/imgs/house-icon-nobg.png" alt="house-icon"/>
            Home
            </button>
        </li>
        <li>
            <button onclick="showPage('../pages/profile-page.php')">
            <img class="icon" src="../assets/imgs/profile-icon.png" alt="profile-icon">
            Profile
            </button>
        </li>
        <li>
            <div class="dropdown">
                <img class="icon" src="../assets/imgs/elipsis-icon.png" alt="elipsis-icon">
                <button>More</button>
                <div class="dropdown-content">
                    <a><button onclick="showPage('../pages/manage.php')">Manage</button></a>
                    <form method="post">
                    <a><button type="submit" name="logout">Logout</button></a>
                    </form>
                </div>
            </div>
        </li>
    </ul>
</nav>
    </div>
    <div class="container">
        <iframe id="parent_div"></iframe>
    </div>
</div>
</body>
</html>