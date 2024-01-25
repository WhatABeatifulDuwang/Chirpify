<?php include('../database.php');?>
<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <script src="dependencies/scripts/login-page_script.js"></script> 
    <script src="dependencies/scripts/index_script.js"></script> 
    <link rel="stylesheet" href="../dependencies/styles/login-page_style.css"> 
    <link rel="icon" href="../assets/imgs/logo_no_bg.png" type="../assets/imgs/logo_no_bg.png">
</head> 
<body> 
    <div> 
        <div class="login-box"> 
           <div class="logo-wrapper">
           </div>
            <div class="container">
                <h2>Log Into Chirpify</h2> 
                <div class="logo"> 
                    <img src="../assets/imgs/logo_no_bg.png" alt="Chirpify Logo"> 
                </div>
                <?php
                session_start();
                $showLoginForm = true;

                $allUsers = getAllUsers();
                foreach ($allUsers as $user){
                        $emailCheck = $user['email'];
                }

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $username = $_POST["username"];
                    $password = $_POST["password"];
                    $user = getUserByNameAsId($username, $password);
                    $validUsername = $user['username'];
                    $validPassword = $user['password'];

                    if ($emailCheck != $username||$username!=''){
                        echo "<div style = 'color:red'>There is no account like this in our records</div>";
                        }

                    if ($username == $validUsername && $password == $validPassword) {
                        $userId = getUserByNameAsId($username, $password);
                        $_SESSION["user"] = $userId;
                        header("Location: parent-page.php");
                        exit();
                    } 

                }
                ?>
                <?php if ($showLoginForm): ?>
                    <form id="loginForm" method="post">
                        <input type="text" id="username" name="username" placeholder="Enter your username or email"> 
                        <br> 
                        <input type="password" id="password" name="password" placeholder="Enter your password"> 
                        <br> 
                        <input type="submit" value="Login" class="btn btn-primary" name="Submitted"> 
                    </form>
                <?php endif; ?>
                <p class="sign-up" href="register_page.php"> Don't have an account? <a>Sign Up</a></p> 
                <div id="confirmationMessage"></div> 
            </div> 
        </div> 
    </div> 
</body> 
</html>