<?php

    session_start();
    include('config/connect.php');

    $librarian_id=$_GET['LibrarianID'];

    $delete="DELETE FROM librarians WHERE librarian_id='$librarian_id'";
    $deleterun=mysqli_query($connect,$delete);

    if ($deleterun) 
    {
        echo "<script>window.alert('Librarian delete completed!')</script>";
        echo "<script>window.location='manage_librarian.php'</script>";
    }
    else
    {
        echo mysqli_error($connect);
    }