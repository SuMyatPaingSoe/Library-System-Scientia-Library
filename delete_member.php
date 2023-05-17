<?php

    session_start();
    include('../config/connect.php');

    $member_id=$_GET['MemberID'];

    $delete="DELETE FROM members WHERE member_id='$member_id'";
    $deleterun=mysqli_query($connect,$delete);

    if ($deleterun) 
    {
        echo "<script>window.alert('Member delete completed!')</script>";
        echo "<script>window.location='manage_member.php'</script>";
    }
    else
    {
        echo mysqli_error($connect);
    }