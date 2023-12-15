<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <script src="dependencies/scripts/login-page_script.js"></script> 
    <link rel="stylesheet" href="../dependencies/styles/login-page_style.css"> 
    <title></title> 
</head> 
<body> 
    <div class="container"> 
        <div class="login-box"> 
            <div class="logo"> 
                <img src="../assets/imgs/logo_no_bg.png" alt="Chirpify Logo"> 
            </div> 
            <h1>Login into Chirpify</h1> 
            <form id="loginForm" method="post"> 
                <h3>Username or Email</h3> 
                <input type="text" id="username" name="username" placeholder="Enter your username or email"> 
                <br> 
                <h3>Password</h3> 
                <input type="text" id="password" name="password" placeholder="Enter your password"> 
                <br> 
                <input type="submit" value="Login" class="btn btn-primary"> 
            </form> 
            <p class="sign-up">Don't have an acount? <a href="placeholder-page.html">Sign Up</a></p> 
            <div id="confirmationMessage"></div> 
        </div> 
    </div> 
</body> 
</html>