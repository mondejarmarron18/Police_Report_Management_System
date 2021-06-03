<?php
    if (empty($_SESSION['username'])) {
       echo '<script>window.location = "login.php" </script>';
    } 
?>