<?php
session_start();
$_SESSION['username'] = $_GET['username'];
echo '<script>window.location = "../dashboard.php" </script>';
?>