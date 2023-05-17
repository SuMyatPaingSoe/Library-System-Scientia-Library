<?php

    session_start();
    include('config/connect.php');

    $author_id=$_GET['AuthorID'];

    $delete="DELETE FROM authors WHERE author_id='$author_id'";
    $deleterun=mysqli_query($connect,$delete);

    if ($deleterun) 
    {
        echo "<script>window.alert('Author delete completed!')</script>";
        echo "<script>window.location='manage_author.php'</script>";
    }
    else
    {
        echo mysqli_error($connect);
    }