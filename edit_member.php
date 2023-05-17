<?php
    session_start();
    include('config/connect.php');

    if (isset($_REQUEST['MemberID'])) {
        $member_id = $_REQUEST['MemberID'];
        $select = "SELECT * FROM members WHERE member_id='$member_id'";
        $run = mysqli_query($connect, $select);
        $data = mysqli_fetch_array($run);
    
        if (isset($_POST['btnupdate'])) {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $gender = $_POST['gender'];
            $email = $_POST['email'];
            $password = md5($_POST['password']);
            $nrcno = $_POST['nrcno'];
            $phoneno = $_POST['phoneno'];
            $dob = $_POST['dob'];
            $address = $_POST['address'];
            //$expirydate = $_POST['expirydate'];
    
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
            `address`='$address'
            -- `expiry_date`='$expirydate'

            WHERE `member_id` = $member_id";
    
            $urun = mysqli_query($connect, $update);
            if ($urun) {
                echo "<script>alert('Member Data Update Successful!')</script>";
                echo "<script>location='manage_member.php'</script>";
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
    <section class="vh-50 gradient-custom login">
        <div class="container mt-5 pt-5">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="card-body px-5 py-4">
                            <h5 class="font-weight-bold mb-4 text-center">Edit Member</h5>
                            <form action="" method="post" enctype="multipart/form-data">
                                <!-- <div class="form-group">
                                    <label for="libraryid">Library ID</label>
                                    <input type="text" class="form-control" name="libraryid" id="libraryid"
                                        value="SL-183292" disabled>
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
                                        aria-describedby="password" value="<?php echo $data['password'] ?>">
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
                                <!-- <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select class="custom-select" name="gender" id="gender">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div> -->
                                <!-- <div class="form-group">
                                    <label for="expirydate">Expiry Date</label>
                                    <input type="date" class="form-control" name="expirydate" id="expirydate"
                                        value="<?php echo date('Y-m-d', strtotime('+1 year')) ?>" readonly>
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