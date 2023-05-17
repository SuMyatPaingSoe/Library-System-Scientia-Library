<?php 
    session_start();
    include('config/connect.php');
    include('config/auto_assign_id.php');
    include_once('config/checkin_function.php');

    if(isset($_POST['btnCheckin'])) {
        
        if (!isset($_SESSION['borrower_id']) && !isset($_SESSION['borrower_name'])) {
            $showModal = true;
            $Message = 'User must be added to check in!';
            $MessageTitle = 'Nothing there...';
            $alert = 'alert-warning';
        } elseif(empty($_SESSION['return_books'])) {
            $showModal = true;
            $Message = 'User has no book to return!';
            $MessageTitle = 'Nothing there...';
            $alert = 'alert-warning';
        } else {
            $member_id = $_SESSION['borrower_id'];
            $borrow_id = $_POST['borrow_id'];

            for ($i=0; $i < count($_SESSION['return_books']); $i++) { 
                $book_id = $_SESSION['return_books'][$i]['book_id'];
                $borrow_id = $_SESSION['return_books'][$i]['borrow_id'];
                $return_stmt = "UPDATE `borrow_details` SET `status`='returned' 
                                WHERE `borrow_id` = '$borrow_id' AND `book_id` = '$book_id'";
                $return = mysqli_query($connect, $return_stmt);
                $on_shelf_stmt = "UPDATE `books` SET `on_shelf`=`on_shelf` + 1 WHERE `book_id` = '$book_id'";
                $on_shelf_query = mysqli_query($connect, $on_shelf_stmt);
            }

            $borrowed_books_stmt = "SELECT * FROM borrow_details bd, borrows b WHERE 
                                    bd.borrow_id = b.borrow_id
                                    AND b.borrow_id = '$borrow_id'
                                    AND b.member_id = '$member_id'";
            $borrow_books = mysqli_query($connect, $borrowed_books_stmt);
            $borrowed_books_count = mysqli_num_rows($borrow_books);


            $returned_books_stmt = "SELECT * FROM borrow_details bd, borrows b WHERE 
                                    bd.borrow_id = b.borrow_id
                                    AND b.borrow_id = '$borrow_id'
                                    AND b.member_id = '$member_id'
                                    AND bd.status = 'returned'";
            $returned_books = mysqli_query($connect, $returned_books_stmt);
            $returned_books_count = mysqli_num_rows($returned_books);
        
            if ($returned_books_count == $borrowed_books_count) {
                $checkin_stmt = "UPDATE `borrows` SET `status`='returned' 
                                WHERE `borrow_id` = '$borrow_id' AND `member_id` = '$member_id'";
                $checkin = mysqli_query($connect, $checkin_stmt);
            }
        
            if ($checkin && ($return && $on_shelf_query)) {
                unset($_SESSION['return_books']);
                unset($_SESSION['borrower_id']);
                unset($_SESSION['borrower_name']);
                $showModal = true;
                $Message = 'Successfully Checked In!';
                $MessageTitle = 'Success';
                $alert = 'alert-success';
            } else {
                $showModal = false;
                $MessageTitle = 'Something Went Wrong!';
                $Message = 'Error: ' . mysqli_error($connect);
                $alert = 'alert-danger';
            }
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
        unset($_SESSION['return_books']);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="images/Consulting.png" type="image/x-icon">
    <title>Scientia Library - Check In</title>
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
    <section class="check-in mt-5 py-5">
        <div class="container">
            <h4 class="fw-bold">Check in</h4>
            <div class="row">
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
        <form action="check_in.php" method="post">
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
                                    if (isset($_SESSION['return_books']) && isset($_SESSION['borrower_id'])) {
                                        for ($i=0; $i < count($_SESSION['return_books']); $i++) {
                                            ?>
                                <tr>
                                    <td><?php echo $_SESSION['return_books'][$i]['book_title'] ?></td>
                                    <td><?php echo $_SESSION['return_books'][$i]['isbn'] ?></td>
                                    <td><a href="check_in.php?remove=<?php echo $_SESSION['return_books'][$i]['book_id'] ?>"
                                            class="btn btn-danger">Remove</a></td>
                                </tr>

                                <?php
                                        }
                                    } 
                                    
                                    if(empty($_SESSION['return_books']) && !empty($_SESSION['borrower_id'])) {
                                ?>
                                <tr>
                                    <td colspan="3">
                                        <div class="alert alert-warning text-center">
                                            Empty. There's no book...
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                    }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <?php
                                if (isset($_SESSION['borrower_id'])) {
                                    ?>
                        <div class="card p-3">
                            <div class="card-img d-flex justify-content-center">
                                <img src="<?php echo $_SESSION['profile']  ?>" class=" img-thumbnail" width="120"
                                    alt="">
                            </div>
                            <div class="card-body text-center">
                                <b>Borrower: </b> <?php echo $_SESSION['borrower_name'] ?> <br>
                                <b>Library ID: </b> <?php echo $_SESSION['borrower_id'] ?> <br>
                                <a href="check_in.php?remove_borrower" class="btn btn-danger mt-1">Remove</a>
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
                        <input type="submit" value="Check In" name="btnCheckin" class="btn btn-success">
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