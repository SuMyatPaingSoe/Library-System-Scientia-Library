<?php

function AddBook($book_id, $count, $fetch) {
    $_SESSION['books'][$count]['book_id'] = $book_id;
    $_SESSION['books'][$count]['book_title'] = $fetch['book_title'];
    $_SESSION['books'][$count]['isbn_no'] = $fetch['isbn'];
}

function RemoveBook($remove_id) {
    $key = array_search($remove_id, array_column($_SESSION['books'], 'book_id'));
    unset($_SESSION['books'][$key]);
    $_SESSION['books']=array_values($_SESSION['books']);
}

function AddBorrower($borrower_id) {
    include('config/connect.php');
    $add_member_stmt = "SELECT * FROM members WHERE member_id = '$borrower_id'";
    $add_member_query = mysqli_query($connect, $add_member_stmt);
    $fetch = mysqli_fetch_array($add_member_query);
    
    $_SESSION['borrower_id'] = $borrower_id;
    $_SESSION['profile'] = $fetch['profile'];
    $_SESSION['borrower_name'] = $fetch['first_name'] . " " . $fetch['last_name'];
}