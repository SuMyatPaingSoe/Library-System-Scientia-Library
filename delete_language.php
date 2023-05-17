<?php

    session_start();
    include('config/connect.php');

    $language_id=$_GET['LanguageID'];

    $delete="DELETE FROM languages WHERE language_id='$language_id'";
    $deleterun=mysqli_query($connect,$delete);

    if ($deleterun) 
    {
        echo "<script>window.alert('Language delete completed!')</script>";
        echo "<script>window.location='manage_language.php'</script>";
    }
    else
    {
        echo mysqli_error($connect);
    }