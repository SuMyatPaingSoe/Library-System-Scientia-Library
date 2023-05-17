<?php
    session_start();
    include('config/connect.php');

    $member_id = $_SESSION['member_id'];
    $query = "SELECT * FROM members WHERE member_id = '$member_id'";
    $result = mysqli_query($connect, $query);
    $data = mysqli_fetch_array($result);

    if (isset($_POST['btnupdate'])) {
        if(!empty($_POST['password'])) {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $gender = $_POST['gender'];
            $email = $_POST['email'];
            $password = md5($_POST['password']);
            $nrcno = $_POST['nrcno'];
            $phoneno = $_POST['phoneno'];
            $dob = $_POST['dob'];
            $address = $_POST['address'];
            $expirydate = $_POST['expirydate'];

            $update = "UPDATE `members` 
            SET 
            `first_name`='$firstname',
            `last_name`='$lastname',
            `gender`='$gender',
            `email`='$email',
            `password`='$password',
            `nrc_no`='$nrcno',
            `phone_no`='$phoneno',
            `dob`='$dob',
            `address`='$address',
            `expiry_date`='$expirydate'
            WHERE `member_id` = '$member_id'";
        } else {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $gender = $_POST['gender'];
            $email = $_POST['email'];
            $nrcno = $_POST['nrcno'];
            $phoneno = $_POST['phoneno'];
            $dob = $_POST['dob'];
            $address = $_POST['address'];
            $expirydate = $_POST['expirydate'];

            $update = "UPDATE `members` 
            SET 
            `first_name`='$firstname',
            `last_name`='$lastname',
            `gender`='$gender',
            `email`='$email',
            `nrc_no`='$nrcno',
            `phone_no`='$phoneno',
            `dob`='$dob',
            `address`='$address',
            `expiry_date`='$expirydate'

            WHERE `member_id` = '$member_id'";
        }
        

        $urun = mysqli_query($connect, $update);
        if ($urun) {
            echo "<script>alert('Member Data Update Successful!')</script>";
            echo "<script>location='profile.php'</script>";
        } else {
            echo mysqli_error($connect);
        }
    } 
?>
<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="images/Scientia-portrait-white-bg.svg" type="image/x-icon">
    <title>Scientia Library - Home</title>
    <link rel="stylesheet" href="vendor/css/bootstrap.min.css">
    <link rel="stylesheet" href="fonts/fontawesome-free/css/all.css">
    <link rel="stylesheet" href="vendor/DataTables/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="vendor/DataTables/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="d-flex flex-column h-100">
    <?php
    include('includes/header.php');
?>
    <main role="main" class="flex-shrink-0">
        <section class="profile container">
            <ul class="nav nav-tabs mt-5" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link text-dark font-weight-bold active" id="lent-tab" data-toggle="tab" href="#lent"
                        role="tab" aria-controls="lent" aria-selected="true">Lent</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark font-weight-bold" id="reserved-tab" data-toggle="tab" href="#reserved"
                        role="tab" aria-controls="reserved" aria-selected="false">Reserved</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark font-weight-bold" id="profile-tab" data-toggle="tab" href="#profile"
                        role="tab" aria-controls="profile" aria-selected="false">Profile</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="lent" role="tabpanel" aria-labelledby="lent-tab">
                    <div class="container mt-2">
                        <table id="list_table" class="table w-100 table-sm table-white table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Book Title</th>
                                    <th>Due Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                        
                                        $member_id = $_SESSION['member_id'];
                                        $query = "SELECT * FROM borrows b, borrow_details bd, members m, books bo 
                                                  WHERE b.borrow_id = bd.borrow_id
                                                  AND bo.book_id = bd.book_id
                                                  AND b.member_id = m.member_id 
                                                  AND b.member_id = '$member_id'
                                                  AND bd.status = 'borrowed'";
                                        $result = mysqli_query($connect, $query);
                                        $count = mysqli_num_rows($result);
                                    
                                        if($count < 1) {
                                            echo "<tr>";
                                            echo "<td colspan='3'><div class='alert alert-light text-center'>You haven't rented any book.</div></td>";
                                            echo "</tr>";
                                        } else {
                                            for ($i = 0; $i < $count; $i++) {
                                                    $arr = mysqli_fetch_array($result);
                                        ?>
                                <tr>
                                    <td><img src="<?php echo $arr['cover'] ?>" width="100" alt="book cover"></td>
                                    <td><a href="book_info.php?book_id=<?php echo $arr['book_id'] ?>"
                                            class="text-dark text-decoration-none">
                                            <?php echo $arr['book_title'] ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php echo ($arr['due_date'] < date('Y-m-d')) ? $arr['due_date'] . " <span class='badge badge-danger'>Overdue</span>" : $arr['due_date'] ?>
                                    </td>
                                </tr>

                                <!-- echo "<tr>";
                                echo "<td><img src='" . $arr[' cover'] . "' alt='book cover' width='100' /></td>" ;
                                        echo "<td><a href='book_info.php?book_id=" . $arr['book_id']
                                        . "' class='text-dark text-decoration-none'>" . $arr['book_title'] . "</a></td>"
                                        ; echo "<td>" . $arr['due_date'] . "</td>" ; echo "</tr>" ;  -->
                                <?php 
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="reserved" role="tabpanel" aria-labelledby="reserved-tab">
                    <div class="container mt-2">
                        <table id="list_table" class="table w-100 table-sm table-white table-hover">
                            <thead>
                                <tr>
                                    <th class="w-25">Book Title</th>
                                    <th>Author</th>
                                    <th>ISBN No.</th>
                                    <th>Genre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                        $query = "SELECT * FROM books b, genres g, authors a, reserved r WHERE
                                b.genre_id = g.genre_id AND b.author_id = a.author_id AND r.book_id = b.book_id AND r.member_id = $member_id";
                        $result = mysqli_query($connect, $query);
                        $count = mysqli_num_rows($result);
                    
                        if($count < 1) {
                            echo "<p>No Data Found!</p>";
                        } else {
                            for ($i = 0; $i < $count; $i++) {
                                    $arr = mysqli_fetch_array($result);
                                    $book_id = $arr['book_id'];

                                    echo "<tr>";
                                    echo "<td>" . $arr['book_title'] . "</td>";
                                    echo "<td>" . $arr['author_name'] . "</td>";
                                    echo "<td>" . $arr['isbn'] . "</td>";
                                    echo "<td>" . $arr['genre_title'] . "</td>";
                                    echo "</tr>";
                        }
                    }
                    ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="container mt-4 py-3">
                        <h4 class="font-weight-bold text-center">My Profile</h4>
                        <img src="<?php echo $data['profile'] ?>" alt="profile" height="200"
                            class="image-thumbnail rounded mx-auto d-block">
                        <hr>
                        <form action="" method="post" enctype="multipart/form-data">
                            <!-- <div class="form-group">
                            <label for="libraryid">Library ID</label>
                            <input type="text" class="form-control" name="libraryid" id="libraryid" value="SL-183292"
                                disabled>
                        </div> -->
                            <div class="form-group">
                                <label for="firstname">First Name</label>
                                <input type="text" class="form-control" name="firstname" id="firstname"
                                    value="<?php echo $data['first_name'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last Name</label>
                                <input type="text" class="form-control" name="lastname" id="lastname"
                                    value="<?php echo $data['last_name'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="custom-select" name="gender" id="gender">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    aria-describedby="email" value="<?php echo $data['email'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password"
                                    aria-describedby="password">
                            </div>
                            <div class="form-group">
                                <label for="nrcno">NRC no.</label>
                                <input type="text" class="form-control" name="nrcno" id="nrcno"
                                    value="<?php echo $data['nrc_no'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="phoneno">Phone no.</label>
                                <input type="text" class="form-control" name="phoneno" id="phoneno"
                                    value="<?php echo $data['phone_no'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="dob">Date Of Birth</label>
                                <input type="date" class="form-control" name="dob" id="dob" aria-describedby="dob"
                                    value="<?php echo $data['dob'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control" name="address" id="address"
                                    rows="3"><?php echo $data['address'] ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="custom-select" name="gender" id="gender">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <!-- <div class="form-group">
                            <label for="expirydate">Expiry Date</label>
                            <input type="date" class="form-control" name="expirydate" id="expirydate"
                                value="<?php echo $data['expiry_date'] ?>" readonly>
                        </div> -->
                            <!-- <div class="form-group">
                                    <input type="button" value="Renew" class="btn btn-primary">
                                </div> -->
                            <div>
                                <button class="btn add-btn" type="submit" name="btnupdate">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php
    include('includes/footer.php');
?>
</body>
<script src="node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/DataTables/js/jquery.dataTables.min.js"></script>
<script src="vendor/DataTables/js/dataTables.bootstrap5.min.js"></script>
<script src="vendor/DataTables/js/dataTables.responsive.min.js"></script>
<script src="vendor/DataTables/js/responsive.bootstrap5.min.js"></script>
<script src="vendor/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js" charset="utf-8"></script>

</html>