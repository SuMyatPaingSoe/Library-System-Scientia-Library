<?php
    session_start();
    include('config/connect.php');
    include('config/auto_assign_id.php');
    include('config/checkout_function.php');

    if (isset($_POST['btnCheckout'])) {
        if (empty($_SESSION['books']) || empty($_SESSION['borrower_id'])) {
            $showModal = true;
            $Message = 'Book and borrower must be added to check out!';
            $MessageTitle = 'Nothing to check out...';
            $alert = 'alert-warning';
        } else {
            $member_id = $_SESSION['borrower_id'];
            $borrow_id = $_POST['borrow_id'];
            $issue_date = date('Y-m-d');
            $due_date = date('Y-m-d', strtotime('+2 weeks'));
            $status = 'borrowed';

            $borrowed_stmt = "SELECT * FROM borrow_details bd, borrows b WHERE b.member_id = '$member_id'
                                AND bd.borrow_id = b.borrow_id
                                AND bd.status = 'borrowed'";
            $borrowed = mysqli_query($connect, $borrowed_stmt);
            $borrowed_data = mysqli_fetch_array($borrowed);
            
            if (mysqli_num_rows($borrowed) >= 4) {
                $showModal = true;
                $Message = 'Please reutrn the borrowed books first!';
                $MessageTitle = 'Return the books first';
                $alert = 'alert-warning';
            } else {
                $checkout_stmt = "INSERT INTO `borrows`(`borrow_id`, `member_id`, `issue_date`, `due_date`, `status`) 
                                VALUES ('$borrow_id','$member_id','$issue_date','$due_date','$status')";
                $checkout = mysqli_query($connect, $checkout_stmt);
                
                $book_count = count($_SESSION['books']);
                
                for ($i=0; $i < $book_count; $i++) {
                    $book_id = $_SESSION['books'][$i]['book_id'];
                    $checkout_details_stmt = "INSERT INTO `borrow_details`(`borrow_id`, `book_id`, `status`) 
                                            VALUES ('$borrow_id','$book_id','$status')";
                    $checkout_details_run = mysqli_query($connect, $checkout_details_stmt);

                    $leave_shelf_stmt = "UPDATE `books` SET `on_shelf`=`on_shelf` - 1 WHERE `book_id` = '$book_id'";
                    $leave_shelf_query = mysqli_query($connect, $leave_shelf_stmt);

                    $if_reserved_stmt = "SELECT * FROM reserved
                               WHERE book_id = '$book_id'   AND member_id = '$member_id'";
                    $if_reserved_query = mysqli_query($connect, $if_reserved_stmt);
                    if (mysqli_num_rows($if_reserved_query) == 1) {
                        $remove_reserved_stmt = "DELETE FROM reserved
                                            WHERE book_id = '$book_id'   AND member_id = '$member_id'";
                        $remove_reserved_query = mysqli_query($connect, $remove_reserved_stmt);
                    }
                }

                if($checkout && ($checkout_details_run && $leave_shelf_query)) {
                    unset($_SESSION['books']);
                    unset($_SESSION['borrower_id']);
                    unset($_SESSION['borrower_name']);
                    $showModal = true;
                    $processSuccess = true;
                    $Message = 'Successfully Checked Out!';
                    $MessageTitle = 'Success';
                    $alert = 'alert-success';
                } else {
                    $showModal = true;
                    $MessageTitle = 'Something Went Wrong!';
                    $processSuccess = false;
                    $Message = 'Error: ' . mysqli_error($connect);
                    $alert = 'alert-danger';
                }
            }
        }
    }

    if (isset($_GET['btnBookAdd'])) {
        $book_id = $_GET['book']; 
        
        $add_book_stmt = "SELECT * FROM books WHERE book_id = '$book_id'";
        $add_book_query = mysqli_query($connect, $add_book_stmt);
        $fetch = mysqli_fetch_array($add_book_query);

        if(isset($_SESSION['books'])) {
            $count = count($_SESSION['books']);

            $book_left_stmt = "SELECT * FROM books b
                               WHERE b.book_id = '$book_id'";
            $book_left_query = mysqli_query($connect, $book_left_stmt);
            $book_data = mysqli_fetch_array($book_left_query);

            if ($count < 4) {
                if (in_array($book_id, array_column($_SESSION['books'], 'book_id'))) {
                    $showModal = true;
                    $Message = 'Book Already Added!';
                    $success = true;
                    $MessageTitle = 'Warning';
                    $alert = 'alert-warning';
                } elseif ($book_data['on_shelf'] == 0) {
                    $showModal = true;
                    $Message = 'Book is currently unavailable!';
                    $success = true;
                    $MessageTitle = 'Warning';
                    $alert = 'alert-warning';
                } elseif ($book_data['on_shelf'] == 1) {
                    $member_id = $_SESSION['borrower_id'];
                    $if_reserved_stmt = "SELECT * FROM reserved
                               WHERE book_id = '$book_id'";
                    $if_reserved_query = mysqli_query($connect, $if_reserved_stmt);
                    $reserved_data = mysqli_fetch_array($if_reserved_query);

                    if (($reserved_data['member_id'] == $member_id) || (mysqli_num_rows($if_reserved_query) == 0)) {
                        AddBook($book_id, $count, $fetch);
                    } else {
                        echo "<script>alert('Reserved by someone else.')</script>";
                    }
                } else {
                    AddBook($book_id, $count, $fetch);
                }
                
            } else {
                $showModal = true;
                $Message = 'Book Limit Reached!';
                $success = false;
                $MessageTitle = 'Warning';
                $alert = 'alert-warning';
            }
        } else {
            $_SESSION['books'] = array();
            $_SESSION['books'][0]['book_id'] = $book_id;
            $_SESSION['books'][0]['book_title'] = $fetch['book_title'];
            $_SESSION['books'][0]['isbn_no'] = $fetch['isbn'];
        }
    }

    if (isset($_GET['btnmemberAdd'])) {
        $borrower_id = $_GET['member'];

        AddBorrower($borrower_id);
    } 

    if (isset($_GET['remove'])) {
        $remove_id = $_GET['remove'];
        RemoveBook($remove_id);
    }

    if (isset($_GET['remove_borrower'])) {
        unset($_SESSION['borrower_id']);
        unset($_SESSION['borrower_name']);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="images/Consulting.png" type="image/x-icon">
    <title>Scientia Library - Check Out</title>
    <link rel="stylesheet" href="vendor/css/bootstrap.min.css">
    <link rel="stylesheet" href="fonts/fontawesome-free/css/all.css">
    <link rel="stylesheet" href="vendor/bootstrap-select/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
        include('includes/admin_header.php');
        include('includes/message_modal.php');
    ?>
    <section class="check-out mt-5 py-5">
        <div class="container">
            <h4 class="fw-bold">Check out</h4>
            <div class="row">
                <div class="col-lg-6">
                    <form action="" method="get">
                        <label for="" class="fw-bold">Book</label>
                        <div class="input-group">
                            <select class="form-control selectpicker border" name="book" data-live-search="true"
                                required>
                                <?php
                                    $book_query = "SELECT * FROM books";
                                    $book_run = mysqli_query($connect, $book_query);
                                    $count_book = mysqli_num_rows($book_run);
                                    
                                    for ($i=0; $i < $count_book; $i++) { 
                                        $books = mysqli_fetch_array($book_run);
                                        echo "<option value = '" . $books['book_id'] . "' >" . $books['book_title'] . "</option>";
                                    }
                        ?>
                            </select>
                            <div class="input-group-append">
                                <button class="btn add-btn" type="submit" name="btnBookAdd"><i
                                        class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6">
                    <form action="" method="get">
                        <label for="" class="fw-bold">Borrower</label>
                        <div class="input-group">
                            <select class="form-control selectpicker border" name="member" data-live-search="true"
                                required>
                                <?php
                                    $member_query = "SELECT * FROM members WHERE status = 'active'";
                                    $member_run = mysqli_query($connect, $member_query);
                                    $count_member = mysqli_num_rows($member_run);
                                    
                                    for ($i=0; $i < $count_member; $i++) { 
                                        $members = mysqli_fetch_array($member_run);
                                        if ($members['member_id'] == $_SESSION['borrower_id']) {
                                            echo "<option selected value = '" . $members['member_id'] . "' >" ;
                                        } else {
                                            echo "<option value = '" . $members['member_id'] . "' >" ;
                                        }
                                        echo $members['first_name'] . " " . $members['last_name'] . "</option>";
                                    }
                        ?>
                            </select>
                            <div class="input-group-append">
                                <button type="submit" name="btnmemberAdd" class="btn add-btn"><i
                                        class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br>
        <form action="check_out.php" method="post">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <table class="table w-100 table-white table-hover">
                            <thead>
                                <tr>
                                    <th>Book Title</th>
                                    <th>ISBN No.</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    if (isset($_SESSION['books'])) {
                                        for ($i=0; $i < count($_SESSION['books']); $i++) {
                                            ?>
                                <tr>
                                    <td><?php echo $_SESSION['books'][$i]['book_title'] ?></td>
                                    <td><?php echo $_SESSION['books'][$i]['isbn_no'] ?></td>
                                    <td><a href="check_out.php?remove=<?php echo $_SESSION['books'][$i]['book_id'] ?>"
                                            class="btn btn-danger">Remove</a></td>
                                </tr>

                                <?php
                                        }
                                    }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <?php
                                if (isset($_SESSION['borrower_id'])) {
                                    ?>
                        <div class="card p-2">
                            <div class=" card-img d-flex justify-content-center">
                                <img src="<?php echo $_SESSION['profile'] ?>" alt="" class="img-thumbnail" width="120">
                            </div>
                            <div class="card-body text-center">
                                <!-- <img src="https://i.imgur.com/wvxPV9S.png" height="100" width="100"> -->
                                <b>Borrower: </b> <?php echo $_SESSION['borrower_name'] ?> <br>
                                <b>Library ID: </b> <?php echo $_SESSION['borrower_id'] ?> <br>
                                <a href="check_out.php?remove_borrower" class="btn btn-danger">Remove</a>
                            </div>
                        </div>
                        <?php
                                }
                        ?>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center py-3">
                        <input type="hidden" name="borrow_id"
                            value="<?php echo assign_id('borrows', 'borrow_id', 'BO-', 6); ?>">
                        <input type="submit" value="Check out" name="btnCheckout" class="btn btn-success">
                    </div>
                </div>
            </div>
        </form>
    </section>
    <?php
        include('includes/admin_footer.php');
    ?>
</body>
<script src="node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/js/bootstrap.bundle.min.js"></script>
<script src="js/admin_nav.js"></script>
<script src="js/script.js" charset="utf-8"></script>
<script src="vendor/bootstrap-select/js/bootstrap-select.min.js"></script>
<script>
$(function() {
    $('.selectpicker').selectpicker();
});
</script>
<?php
    if (isset($showModal) && $showModal) {
        echo '<script type="text/javascript">
			$(document).ready(function(){
				$("#MessageModal").modal("show");
			});
		</script>';
    }
?>


</html>