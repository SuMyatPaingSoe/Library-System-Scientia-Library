<?php
    $server = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'scientia_library_db';

    $connect = mysqli_connect($server, $username, $password, $database);

    if(!$connect) {
        echo "<p>" . mysqli_connect_error() . "</p>";
    }
 
?>