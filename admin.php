<?php
    session_start();
    include('config/connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="images/Consulting.png" type="image/x-icon">
    <title>Scientia Library - Admin</title>
    <link rel="stylesheet" href="vendor/css/bootstrap.min.css">
    <link rel="stylesheet" href="fonts/fontawesome-free/css/all.css">
    <link rel="stylesheet" href="vendor/DataTables/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="vendor/DataTables/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    include('includes/admin_header.php');
?>
    <section class="search p-5 mt-5">
        <!-- <div class="advanced-search">
            <a href="">Advanced Search</a>
        </div> -->
        <div class="d-flex justify-content-center w-100">
            <form class="input-group search-group w-50 shadow rounded" method="post">
                <input type="search" name="keyword" class="form-control" placeholder="Search a book or audio"
                    aria-label="Search" aria-describedby="search-addon" />
                <button type="button" class="btn btn-md search-btn rounded-end border border-1"><i
                        class="fa-solid fa-md fa-magnifying-glass text-warning"></i> &nbsp;&nbsp;search</button>
            </form>
        </div>
    </section>
    <section class="admin">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 py-3">
                    <div class="card w-100 bg-dark text-light">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-3x fa-book"></i>
                            <p class="card-text fs-5 mt-3">Book Total: <span class="count">2399</span></p>
                            <a href="" class="btn btn-dark">Manage</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 py-3">
                    <div class="card w-100 bg-danger text-light">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-3x fa-users"></i>
                            <p class="card-text fs-5 mt-3">Library Members: <span class="count">310</span></p>
                            <a href="" class="btn btn-danger">Manage</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 py-3">
                    <div class="card w-100 bg-warning text-light">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-3x fa-arrows-rotate"></i>
                            <p class="card-text fs-5 mt-3">Books Issued: <span class="count">30</span></p>
                            <a href="" class="btn btn-warning text-light">Manage</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 py-3">
                    <div class="card w-100 bg-primary text-light">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-3x fa-check"></i>
                            <p class="card-text fs-5 mt-3">Books Returned: <span class="count">15</span></p>
                            <a href="" class="btn btn-primary">Manage</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="borrow-list">
        <div class="container mt-5">
            <h4 class="fw-bold">Today's due</h4>
            <table id="list_table" class="table w-100 table-white table-hover">
                <thead>
                    <tr>
                        <th>Book Title</th>
                        <th>Borrower's Name</th>
                        <th>Borrowed Date</th>
                        <th>Email</th>
                        <th>Phone no.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $today = date('Y-m-d');
                        $duequery = "SELECT * FROM borrows b, members m, borrow_details bd, books bk
                                         WHERE b.due_date = CURRENT_DATE
                                         AND bd.status = 'borrowed'
                                         AND m.member_id = b.member_id
                                         AND bk.book_id = bd.book_id
                                         AND b.borrow_id = bd.borrow_id";
                        $duerun = mysqli_query($connect, $duequery);

                        if(mysqli_num_rows($duerun) <= 0) {
                    ?>
                    <tr>
                        <td colspan="5">
                            <div class="alert alert-info text-center">No Today Due Borrow</div>
                        </td>
                    </tr>
                    <?php
                        } else {
                            while ($borrows = mysqli_fetch_array($duerun)) {
                               ?>
                    <tr>
                        <td><?php echo $borrows['book_title']  ?></td>
                        <td><?php echo $borrows['first_name'] . " " . $borrows['last_name']  ?></td>
                        <td><?php echo $borrows['due_date']  ?></td>
                        <td><?php echo $borrows['email']  ?></td>
                        <td><?php echo $borrows['phone_no'] ?></td>
                    </tr>
                    <?php
                            }
                        }
                    ?>
                </tbody>
            </table>
            <h4 class="fw-bold text-danger mt-5">Overdue</h4>
            <table id="list_table" class="table w-100 table-white table-hover">
                <thead>
                    <tr>
                        <th>Book Title</th>
                        <th>Borrower's Name</th>
                        <th>Due Date</th>
                        <th>Email</th>
                        <th>Phone no.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $today = date('Y-m-d');
                        $overduequery = "SELECT * FROM borrows b, members m, borrow_details bd, books bk
                                         WHERE b.due_date < CURRENT_DATE
                                         AND bd.status = 'borrowed'
                                         AND m.member_id = b.member_id
                                         AND bk.book_id = bd.book_id
                                         AND b.borrow_id = bd.borrow_id";
                        $overduerun = mysqli_query($connect, $overduequery);
                        
                        if(mysqli_num_rows($overduerun) <= 0) {
                            ?>
                    <tr>
                        <td colspan="5">
                            <div class="alert alert-danger text-center">No Overdue Borrow</div>
                        </td>
                    </tr>
                    <?php
                                } else {
                                    while ($borrows = mysqli_fetch_array($overduerun)) {
                                        ?>
                    <tr>
                        <td><?php echo $borrows['book_title']  ?></td>
                        <td><?php echo $borrows['first_name'] . " " . $borrows['last_name']  ?></td>
                        <td><?php echo $borrows['due_date']  ?></td>
                        <td><?php echo $borrows['email']  ?></td>
                        <td><?php echo $borrows['phone_no'] ?></td>
                    </tr>
                    <?php
}
                        }
                    ?>
                </tbody>
            </table>
    </section>
    <?php
        include('includes/footer.php');
    ?>
</body>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/DataTables/js/jquery.dataTables.min.js"></script>
<script src="vendor/DataTables/js/dataTables.bootstrap5.min.js"></script>
<script src="vendor/DataTables/js/dataTables.responsive.min.js"></script>
<script src="vendor/DataTables/js/responsive.bootstrap5.min.js"></script>
<script src="vendor/js/bootstrap.bundle.min.js"></script>
<script src="js/admin_nav.js"></script>
<script src="js/script.js" charset="utf-8"></script>

</html>