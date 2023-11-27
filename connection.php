<?php
    $dbhost = 'localhost:9999';  
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'Study_room';

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if(! $conn ) {
        die('Could not connect: ' . mysqli_connect_error());
    }
?>