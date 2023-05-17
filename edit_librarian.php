<?php
    session_start();
    include('config/connect.php');

    if (isset($_REQUEST['LibrarianID'])) {
        $librarian_id = $_REQUEST['LibrarianID'];
        $select = "SELECT * FROM librarians WHERE librarian_id='$librarian_id'";
        $run = mysqli_query($connect, $select);
        $data = mysqli_fetch_array($run);

        if (isset($_POST['btnupdate'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $gender = $_POST['gender'];
        $nrcno = $_POST['nrcno'];
        $phoneno = $_POST['phoneno'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        $dob = $_POST['dob'];
        $role = $_POST['role'];

        $update = "UPDATE `librarians` 
        SET 
        `first_name`='$firstname',
        `last_name`='$lastname',
        `gender`='$gender',
        `nrc_no`='$nrcno',
        `phone_no`='$phoneno',
        `email`='$email',
        `password`='$password',
        `address`='$address',
        `dob`='$dob',
        `role`='$role'

        WHERE `librarian_id` = $librarian_id";

        $urun = mysqli_query($connect, $update);
        if ($urun) {
            echo "<script>alert('Librarian Data Update Successful!')</script>";
            echo "<script>location='manage_librarian.php'</script>";
        } else {
            echo mysqli_error($connect);
            }
        } 
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="images/Consulting.png" type="image/x-icon">
    <title>Scientia Library - Manage Librarian</title>
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

    <section class="vh-50 gradient-custom login">
        <div class="container mt-5 pt-5">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="card-body px-5 py-4">
                            <h5 class="font-weight-bold mb-4 text-center">Edit Librarian</h5>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="firstname">First Name</label>
                                    <input type="text" class="form-control" name="firstname" id="firstname"
                                        aria-describedby="firstname" value="<?php echo $data['first_name'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" class="form-control" name="lastname" id="firstname"
                                        aria-describedby="lastname" value="<?php echo $data['last_name'] ?>">
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
                                    <label for="nrcno">NRC no.</label>
                                    <input type="text" class="form-control" name="nrcno" id="nrcno"
                                        aria-describedby="helpId" value="<?php echo $data['nrc_no'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="phoneno">Phone no.</label>
                                    <input type="text" class="form-control" name="phoneno" id="phoneno"
                                        aria-describedby="phoneno" value="<?php echo $data['phone_no'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        aria-describedby="email" value="<?php echo $data['email'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password"
                                        aria-describedby="password" value="<?php echo $data['password'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" name="address" id="address" rows="3">
                                        <?php echo $data['address'] ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="dob">Date Of Birth</label>
                                    <input type="date" class="form-control" name="dob" id="dob" aria-describedby="dob"
                                        value="<?php echo $data['dob'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="phoneno">Role</label>
                                    <input type="text" class="form-control" name="role" id="role"
                                        aria-describedby="role" value="<?php echo $data['role'] ?>">
                                </div>
                                <div>
                                    <button class="btn add-btn" type="submit" name="btnupdate">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
        include('includes/admin_footer.php');
    ?>
</body>
<script src="node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/DataTables/js/jquery.dataTables.min.js"></script>
<script src="vendor/DataTables/js/dataTables.bootstrap5.min.js"></script>
<script src="vendor/DataTables/js/dataTables.responsive.min.js"></script>
<script src="vendor/DataTables/js/responsive.bootstrap5.min.js"></script>
<script src="vendor/js/bootstrap.bundle.min.js"></script>
<script src="js/admin_nav.js"></script>
<script src="js/script.js" charset="utf-8"></script>

</html>