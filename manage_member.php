<?php
    session_start();
    include('config/connect.php');
    include('config/auto_assign_id.php');

    // if (isset($_POST['btnAdd'])) {
    //     $member_id = $_POST['member_id'];
    //     $firstname = $_POST['firstname'];
    //     $lastname = $_POST['lastname'];
    //     $gender = $_POST['gender'];
    //     $email = $_POST['email'];
    //     $password=md5($_POST['password']);
    //     $nrcno = $_POST['nrcno'];
    //     $phoneno = $_POST['phoneno'];
    //     $dob = $_POST['dob'];
    //     $address = $_POST['address'];
    //     $expirydate = $_POST['expirydate'];


    //     $selectmember = "SELECT * FROM members
    //     WHERE email='$email'";
    //     $checkmember = mysqli_query($connect,$selectmember);
    //     $countmember = mysqli_num_rows($checkmember);

    //     if ($countmember == 0) {
    //         $insert = "INSERT INTO `members`(`member_id`, `first_name`, `last_name`, `gender`, `email`, 
    //         `password`,`nrc_no`,`phone_no`,`dob`,`address`,`expiry_date`) 
    //         VALUES ('$member_id','$firstname', '$lastname','$gender','$email','$password','$nrcno',
    //         '$phoneno','$dob','$address','$expirydate')";
    //         $runinsert = mysqli_query($connect, $insert);
    //         if ($runinsert) {
    //             $showModal = true;
    //             $Message = 'Member Added Successfully!';
    //             $MessageTitle = 'Success';
    //             $alert = 'alert-success';
    //         } else {
    //             echo mysqli_error($connect);
    //         }
    //     } else {
    //         $showModal = true;
    //         $Message = 'Member Already Exists!';
    //         $MessageTitle = 'Warning';
    //         $alert = 'alert-warning';
    //     }
    // }

    if (isset($_POST['btnActivate'])) {
        $activate_id = $_POST['activate_id'];
        $activate_query = "UPDATE `members` SET `status` = 'active' WHERE `member_id` = '$activate_id'";
        $activate = mysqli_query($connect, $activate_query);
        if ($activate) {
            $showModal = true;
            $processSuccess = true;
            $Message = 'Member Activated!';
            $MessageTitle = 'Success';
            $alert = 'alert-success';
            $RedirectUrl = 'profile.php';
        } else {
            $showModal = true;
            $processSuccess = false;
            $Message = 'Error: ' . mysqli_error($connect);
            $MessageTitle = 'Error';
            $alert = 'alert-warning';
            $RedirectUrl = 'manage_member.php';
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
    <title>Scientia Library - Manage Member</title>
    <link rel="stylesheet" href="vendor/css/bootstrap.min.css">
    <link rel="stylesheet" href="fonts/fontawesome-free/css/all.css">
    <link rel="stylesheet" href="vendor/DataTables/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="vendor/DataTables/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
        include('includes/admin_header.php');
        include('includes/message_modal.php');
    ?>
    <section class="books mt-5">
        <div class="container-fluid pt-5">
            <h4 class="font-weight-bold">Members</h4>
            <table id="list_table" class="table w-100 table-sm table-white table-hover">
                <thead>
                    <tr>
                        <th>Member ID</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>NRC no</th>
                        <th>Phone no</th>
                        <th>Address</th>
                        <th>Payment</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = "SELECT * FROM members";
                        $result = mysqli_query($connect, $query);
                        $count = mysqli_num_rows($result);
                    
                        if($count < 1) {
                            echo "<p>No Data Found!</p>";
                        } else {
                            for ($i = 0; $i < $count; $i++) {
                                    $arr = mysqli_fetch_array($result);
                                    $member_id = $arr['member_id'];
                                    
                                    echo "<tr>";
                                    echo "<td>" . $member_id . "</td>";
                                    echo "<td>" . $arr['first_name'] . " " . $arr['last_name']  . "</td>";
                                    echo "<td>" . $arr['gender'] . "</td>";
                                    echo "<td>" . $arr['email'] . "</td>";
                                    echo "<td>" . $arr['nrc_no'] . "</td>";
                                    echo "<td>" . $arr['phone_no'] . "</td>";
                                    echo "<td>" . $arr['address'] . "</td>";
                                    echo "<td>";
                                    echo "<img data-toggle = 'modal' data-target = '#imageModal". $member_id ."' src='".$arr['payment']."' width='100' height='150'>";     
                                    echo "</td>";
                                    echo "<td>";
                                    ?>
                    <a class='btn btn-outline-success' href='edit_member.php?MemberID=<?php echo $member_id ?>'>Edit</a>
                    <a class='btn btn-outline-danger' href='delete_member.php?MemberID=<?php echo $member_id ?>'
                        onclick="return confirm('Do you want to delete?')">Delete</a>
                    <?php
                        if ($arr['status'] == 'pending') {
                    ?>
                    <form action="" method="post" style="display: inline;">
                        <input type="hidden" name="activate_id" value="<?php echo $arr['member_id'] ?>">
                        <button type="submit" class='btn btn-outline-primary' name="btnActivate">Activate</button>
                    </form>

                    <?php
                    }
                    ?>

                    <?php
                    echo "</td>";
                    echo "</tr>";
                    ?>
                    <div class="modal fade" id="imageModal<?php echo $member_id ?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Payment Image</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <img src="<?php echo $arr['payment'] ?>" alt="payment image" width="100%">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
    <!-- <section class="add-form">
        <div class="container mt-5">
            <h4 class="font-weight-bold">Register Member</h4>
            <hr>
            <form action="manage_member.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="library_id" id="library_id"
                    value="<?php echo assign_id('members', 'member_id', 'LM-', 6)  ?>">
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" class="form-control" name="firstname" id="firstname"
                        aria-describedby="firstname">
                </div>
                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" class="form-control" name="lastname" id="lastname" aria-describedby="lastname">
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
                    <input type="email" class="form-control" name="email" id="email" aria-describedby="email"
                        placeholder="name@example.com">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password"
                        aria-describedby="password" placeholder="password">
                </div>
                <div class="form-group">
                    <label for="nrcno">NRC no.</label>
                    <input type="text" class="form-control" name="nrcno" id="nrcno" aria-describedby="helpId">
                </div>
                <div class="form-group">
                    <label for="phoneno">Phone no.</label>
                    <input type="text" class="form-control" name="phoneno" id="phoneno" aria-describedby="phoneno">
                </div>
                <div class="form-group">
                    <label for="dob">Date Of Birth</label>
                    <input type="date" class="form-control" name="dob" id="dob" aria-describedby="dob" placeholder="">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea class="form-control" name="address" id="address" rows="3"></textarea>
                </div>
                <input type="hidden" class="form-control" name="expirydate" id="expirydate"
                    aria-describedby="expirydate" value="<?php echo date('Y/m/d', time()) ?>">
                <div>
                    <input type="submit" value="Submit" name="btnAdd" class="btn add-btn">
                </div>
            </form>
        </div>
    </section> -->
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