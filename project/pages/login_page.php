<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <script src="dependencies/scripts/login-page_script.js"></script> 
    <script src="dependencies/scripts/index_script.js"></script> 
    <link rel="stylesheet" href="../dependencies/styles/login-page_style.css"> 
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
            <form id="loginForm" method="post"> 
                <div class="content-text">Username or Email</div>
                <input type="text" id="username" name="username" placeholder="Enter your username or email"> 
                <br> 
                <div class="content-text">Password</div>
                <input type="text" id="password" name="password" placeholder="Enter your password"> 
                <br> 
                <input type="submit" value="Login" class="btn btn-primary"> 
            </form> 
            </div>
            <p class="sign-up" href="register_page.php"> Don't have an acount? <a>Sign Up</a></p> 
            <div id="confirmationMessage"></div> 
        </div> 
    </div> 
</body> 
</html>