<?php 
require_once 'includes/autoloader.php';
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="wwwroot/css/default.css">
    <script src="wwwroot/js/default.js" defer></script>
    <title>
        <?php 
        echo 'PRMS - '; 
        include_once 'includes/page_title.php'; ?>
    </title>
</head>
<body>
    <?php 
    if ($_GET['page_title'] == "login" || $_GET['page_title'] == "") {
        require_once 'pages/login.php'; 
    }
    else{ 
        require_once 'includes/session.php';
    ?>
    <div class="wrapper">
        <div class="page_menu">
            <?php require_once 'includes/nav.php'; ?>
        </div>
        <div class="page_body">
            <?php 
                require_once 'includes/header.php'; 
                require_once 'pages/'. $_GET['page_title'] .'.php'; 
            ?>
            <div class="notif">
                Record Updated
            </div>
        </div>
    </div>
    <?php
    }
    ?>
</body>
</html>