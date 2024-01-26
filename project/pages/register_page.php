<?php include('../database.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="dependencies/scripts/login-page_script.js"></script>
    <script src="dependencies/scripts/index_script.js"></script>
    <link rel="icon" href="../assets/imgs/logo_no_bg.png" type="../assets/imgs/logo_no_bg.png">
    <link rel="stylesheet" href="../dependencies/styles/login-page_style.css">
</head>
<body>
<div>
    <div class="login-box">
        <div class="container">
            <!-- <div class="logo">
                    <img src="../assets/imgs/logo_no_bg.png" alt="Chirpify Logo">
                </div> -->
            <h2>Create a new Chirpify account</h2>

            <?php
            session_start();
            $showLoginForm = true;

            $allUsers = getAllUsers();
            foreach ($allUsers as $user){
                $emailCheck = $user['email'];
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $avatar = $_POST["avatar"];
                $username = $_POST["username"];
                $email = $_POST["email"];
                $password = $_POST["password"];

                if ($emailCheck == $email){
                    echo "<div style = 'color:red'>The email already has been used</div>";
                } else {
                    //create user
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    createUser($username,$email,$hashedPassword,null, $avatar);
                    $userId = getUserByNameAsId($username, $hashedPassword);
                    $_SESSION["user"] = $userId;
                    // navigate to home screen
                    header("Location: parent-page.php");
                    exit();
                }
            }
            ?>
            <?php if ($showLoginForm): ?>
                <form id="SignUpForm" method="post">
                    <br>
                    <div>
                        <input type="text" id="avatar" name="avatar" placeholder="Enter an optional avatar URL">
                        <input type="text" id="username" name="username" placeholder="Username">
                        <input type="text" id="email" name="email" placeholder="Enter your email">
                        <input type="password" id="password" name="password" placeholder="Enter your password">
                        <input type="submit" value="Create" class="btn btn-primary" name="Submitted">
                    </div>
                    </br>
                </form>
            <?php endif; ?>
            <p class="sign-up"> Already have an account? <a  href="login_page.php">Sign In</a></p>
            <div id="confirmationMessage"></div>
        </div>
    </div>
</div>
</body>
</html>