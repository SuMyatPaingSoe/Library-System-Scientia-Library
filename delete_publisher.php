<?php

    session_start();
    include('config/connect.php');

    $publisher_id=$_GET['PublisherID'];

    $delete="DELETE FROM publishers WHERE publisher_id='$publisher_id'";
    $deleterun=mysqli_query($connect,$delete);

    if ($deleterun) 
    {
        echo "<script>window.alert('Publisher delete completed!')</script>";
        echo "<script>window.location='manage_publisher.php'</script>";
    }
    else
    {
        echo mysqli_error($connect);
    }