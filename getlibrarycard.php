<?php
    session_start();
    include('config/connect.php');

    if (isset($_POST['btnAdd'])) {
        //$member_id = $_POST['member_id'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $password=md5($_POST['password']);
        $nrcno = $_POST['nrcno'];
        $phoneno = $_POST['phoneno'];
        $dob = $_POST['dob'];
        $address = $_POST['address'];
        $status = "pending";
        //$expirydate = $_POST['expirydate'];

        $image1=$_FILES['profile']['name'];
        $folder="Profile/";
        $profile=$folder. '_' .$image1;
        $copy1=copy($_FILES['profile']['tmp_name'], $profile);

        if (!$copy1) 
        {
            $showModal = true;
            $processSuccess = false;
            $Message = 'Image Upload unsuccessful!';
            $MessageTitle = 'Image Upload Unsuccessful.';
            $alert = 'alert-warning';
            $RedirectUrl = 'profile.php';
        }

        $image=$_FILES['payment']['name'];
        $folder="Payment/";
        $payment=$folder. '_' .$image;
        $copy=copy($_FILES['payment']['tmp_name'], $payment);

        if (!$copy) 
        {
            $showModal = true;
            $processSuccess = false;
            $Message = 'Image Upload unsuccessful!';
            $MessageTitle = 'Image Upload Unsuccessful.';
            $alert = 'alert-warning';
            $RedirectUrl = 'profile.php';
            // echo "<p>Image Upload unsuccessful...</p>";
            // exit();
        }

        $selectmember = "SELECT * FROM members
        WHERE email='$email'";
        $checkmember = mysqli_query($connect,$selectmember);
        $countmember = mysqli_num_rows($checkmember);

        if ($countmember == 0) {
            $insert = "INSERT INTO `members`(`first_name`, `last_name`, `gender`, `email`, 
            `password`,`nrc_no`,`phone_no`,`dob`,`address`, `payment`, `profile`, `status`) 
            VALUES ('$firstname', '$lastname','$gender','$email','$password','$nrcno',
            '$phoneno','$dob','$address','$payment', '$profile', '$status')";
            $runinsert = mysqli_query($connect, $insert);
            if ($runinsert) {
                $showModal = true;
                $processSuccess = true;
                $Message = 'Account Register Successful. Please wait for reply from library.';
                $MessageTitle = 'Success';
                $alert = 'alert-success';
                $RedirectUrl = 'index.php';
            } else {
                $showModal = true;
                $processSuccess = true;
                $Message = 'Error: ' . mysqli_error($connect);
                $MessageTitle = 'Error';
                $alert = 'alert-danger';
                $RedirectUrl = 'getlibrarycard.php';
            }
        } else {
            $showModal = true;
            $processSuccess = false;
            $Message = 'Please try with different email.';
            $MessageTitle = 'Account already exists with same email!';
            $alert = 'alert-warning';
            $RedirectUrl = 'getlibrarycard.php';
            // echo "<script>alert('Email is exists!')</script>";
            // echo "<script>location='getlibrarycard.php'</script>";
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
    <link rel="icon" href="images/Scientia-portrait-white-bg.svg" type="image/x-icon">
    <title>Scientia Library - Home</title>
    <link rel="stylesheet" href="vendor/css/bootstrap.min.css">
    <link rel="stylesheet" href="fonts/fontawesome-free/css/all.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
        include('includes/header.php');
        include('includes/message_modal.php');
    ?>
    <section class="home" id="home">
        <div class="banner w-100 py-5">
            <div class="banner-text text-center w-100">
                <h1>Welcome to <br><b style="color: #dda83f;">Scientia</b> Library</h1>
            </div>
        </div>
    </section>

    <section class="welcome p-4">
        <div class="container">
            <div class="d-flex justify-content-center w-100">
                <h4 style="color: #b9936c; ">Get Your Library card Here
                    and Become Our Member</h4>
            </div>
        </div>
    </section>
    <section class="add-form">
        <div class="container">
            <form action="getlibrarycard.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="firstname" style="color: #b9936c;">
                        First Name</label>
                    <input type="text" class="form-control" id="firstname" name="firstname"
                        placeholder="Enter your first name" onkeypress="return lettersAndSpaceOnly(event)" required>
                </div>
                <div class="form-group">
                    <label for="lastname" style="color: #b9936c;">
                        Last Name</label>
                    <input type="text" class="form-control" id="lastname" name="lastname"
                        placeholder="Enter your last name" onkeypress="return lettersAndSpaceOnly(event)" required>
                </div>
                <!-- <div class="form-group">
                    <label for="profile" style="color: #b9936c; ">Profile Picture</label>
                    <input type="file" class="form-control-file" name="profile" required>
                </div> -->
                <div class="form-group">
                    <label for="gender" style="color: #b9936c;">Gender</label>
                    <select class="custom-select" id="gender" name="gender" id="gender">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email" style="color: #b9936c;">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com"
                        required>
                </div>
                <div class="form-group">
                    <label for="password" style="color: #b9936c;">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="password"
                        required>
                </div>
                <div class="form-group">
                    <label for="nrcno" style="color: #b9936c;">NRC no.</label>
                    <input type="text" class="form-control" name="nrcno" id="nrcno" placeholder="Enter Your NRC Number"
                        required>
                </div>
                <div class="form-group">
                    <label for="phoneno" style="color: #b9936c;">Phone no.</label>
                    <input type="text" class="form-control" name="phoneno" id="phoneno"
                        onkeypress="return onlyNumberKey(event)" maxlength="11" placeholder="Enter Your Phone Number"
                        required>
                </div>
                <div class="form-group">
                    <label for="address" style="color: #b9936c;">Address</label>
                    <textarea class="form-control" name="address" id="address" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="dob" style="color: #b9936c;">Date Of Birth</label>
                    <input type="date" class="form-control" name="dob" id="dob" required>
                </div>
                <div class="form-group">
                    <label for="payment" style="color: #b9936c;">Upload Your Payment Receipt here</label>
                    <input type="file" class="form-control-file" name="payment" id="payment" required>
                    <a href="payment.php" class="alert-link">Click here if you do not not know how to make payment!</a>
                </div>
                <div class="form-group">
                    <label for="profile" style="color: #b9936c;">Upload Your Profile here</label>
                    <input type="file" class="form-control-file" name="profile" id="profile" required>
                </div>
                <div>
                    <input type="submit" value="Submit" name="btnAdd" class="btn add-btn">
                </div>
            </form>
        </div>
    </section>
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
<script src="js/admin_nav.js"></script>
<script src="js/script.js" charset="utf-8"></script>
<script>
//For Phone Number  
function onlyNumberKey(evt) {
    var ASCIICode = (evt.which) ? evt.which : evt.keyCode
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        return false;
    return true;
}

// space is allowed
function lettersAndSpaceOnly() {
    var charCode = String.fromCharCode(event.keyCode);
    var regex = /^[a-zA-Z\s]*$/;
    return regex.test(charCode);
}
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