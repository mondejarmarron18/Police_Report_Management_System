<?php
if(!empty($_SESSION['username'])) {
    header('location: dashboard.php');
}
?>
<script src="services/login.js" defer></script>
<div class="wrapper">   
    <div class="login_container">
        <div class="login_img">
            <h1>PRMS</h1>
            <h2>Police Report Management System</h2>
            <img src="wwwroot/vectors/login.svg" alt="">
            <h3>Manage Records in One Place</h3>
        </div>
        <div class="login_form">
            <h2>Sign In</h2>
            <input type="text" name="" id="username" placeholder="Enter your username">
            <input type="password" name="" id="password" placeholder="Enter You Password">
            <div class="invalid_notif">Invalid Username/Password</div>
            <div class="sign_in_btn">
                Sign In
            </div>
        </div>
    </div>
</div>