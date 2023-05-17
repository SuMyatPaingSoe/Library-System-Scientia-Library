<?php
function Checkin() {
    include('config/connect.php');
}

function AddBorrower($borrower_id) {
    include('config/connect.php');
    $add_member_stmt = "SELECT member_id, first_name, last_name, profile FROM members WHERE member_id = '$borrower_id'";
    $add_member_query = mysqli_query($connect, $add_member_stmt);
    $fetch = mysqli_fetch_array($add_member_query);

    $_SESSION['borrower_id'] = $borrower_id;
    $_SESSION['profile'] = $fetch['profile'];
    $_SESSION['borrower_name'] = $fetch['first_name'] . " " . $fetch['last_name'];

    $borrow_books_stmt = "SELECT bk.book_id, bk.book_title, bk.isbn, bd.borrow_id
                              FROM borrow_details bd,members m, borrows bw, books bk 
                              WHERE m.member_id = '$borrower_id' 
                              AND m.member_id = bw.member_id
                              AND bk.book_id = bd.book_id
                              AND bw.borrow_id = bd.borrow_id
                              AND bd.status = 'borrowed'";
    $borrow_books_query = mysqli_query($connect, $borrow_books_stmt);
    

    $_SESSION['return_books'] = array();

    while($books_fetch = mysqli_fetch_array($borrow_books_query)) { 
        $_SESSION['return_books'][] = $books_fetch;  
    }
}

function RemoveBook($remove_id) {
    $key = array_search($remove_id, array_column($_SESSION['return_books'], 'book_id'));
    unset($_SESSION['return_books'][$key]);
    $_SESSION['return_books']=array_values($_SESSION['return_books']);
}