<?php
    $page_title = $_GET['page_title'];

    //Replace all undercore with space
    $page_title = str_replace('_', ' ', $page_title);

    //Turn all the first character in every word to uppercase
    $page_title = ucwords($page_title);

    echo $page_title;
?>