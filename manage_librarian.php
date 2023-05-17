<?php
    session_start();
    include('config/connect.php');

    if (isset($_POST['btnAdd'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $gender = $_POST['gender'];
        $nrcno = $_POST['nrcno'];
        $phoneno = $_POST['phoneno'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $address = $_POST['address'];
        $dob = $_POST['dob'];
        $role = $_POST['role'];

        $selectlibrarian = "SELECT * FROM librarians
        WHERE email='$email'";
        $checklibrarian = mysqli_query($connect,$selectlibrarian);
        $countlibrarian = mysqli_num_rows($checklibrarian);

        if ($countlibrarian == 0) {
            $insert = "INSERT INTO `librarians`(`first_name`, `last_name`, `gender`,`nrc_no`,`phone_no`,
             `email`,`password`,`address`,`dob`,`role`) 
            VALUES ('$firstname', '$lastname','$gender','$nrcno','$phoneno','$email',
            '$password','$address','$dob','$role')";
            $runinsert = mysqli_query($connect, $insert);
            if ($runinsert) {
                $showModal = true;
                $Message = 'Librarian Added Successfully!';
                $MessageTitle = 'Success';
                $alert = 'alert-success';
            } else {
                echo mysqli_error($connect);
            }
        } else {
            $showModal = true;
            $Message = 'Librarian Already Exists!';
            $MessageTitle = 'Warning';
            $alert = 'alert-warning';
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
        include('includes/message_modal.php');
    ?>
    <section class="books mt-5">
        <div class="container pt-5">
            <h4 class="font-weight-bold">Librarian</h4>
            <table id="list_table" class="table w-100 table-sm table-white table-hover">
                <thead>
                    <tr>
                        <th>Librarian ID</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>NRC Number</th>
                        <th>Phone Number</th>
                        <th>Role</th>
                        <th class="w-10">Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = "SELECT * FROM librarians";
                        $result = mysqli_query($connect, $query);
                        $count = mysqli_num_rows($result);
                    
                        if($count < 1) {
                            echo "<p>No Data Found!</p>";
                        } else {
                            for ($i = 0; $i < $count; $i++) {
                                    $arr = mysqli_fetch_array($result);
                                    $librarian_id = $arr['librarian_id'];

                                    echo "<tr>";
                                    echo "<td>" . $librarian_id . "</td>";
                                    echo "<td>" . $arr['first_name'] . " " . $arr['last_name']  . "</td>";
                                    echo "<td>" . $arr['gender'] . "</td>";
                                    echo "<td>" . $arr['email'] . "</td>";
                                    echo "<td>" . $arr['address'] . "</td>";
                                    echo "<td>" . $arr['nrc_no'] . "</td>";
                                    echo "<td>" . $arr['phone_no'] . "</td>";
                                    echo "<td>" . $arr['role'] . "</td>";
                                    echo "<td>";
                                    ?>
                    <a class='btn btn-outline-success'
                        href='edit_librarian.php?LibrarianID=<?php echo $librarian_id ?>'>Edit</a>
                    <a class='btn btn-outline-danger'
                        href='delete_librarian.php?LibrarianID=<?php echo $librarian_id ?>'
                        onclick="return confirm('Do you want to delete?')">Delete</a>
                    <?php
                    echo "</td>";
                    echo "</tr>";
                    }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
    <section class="add-form">
        <div class="container mt-5">
            <h4 class="font-weight-bold">Register Librarian</h4>
            <hr>
            <form action="manage_librarian.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" class="form-control" name="firstname" id="firstname"
                        aria-describedby="firstname">
                </div>
                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" class="form-control" name="lastname" id="firstname" aria-describedby="lastname">
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
                    <input type="text" class="form-control" name="nrcno" id="nrcno" aria-describedby="helpId">
                </div>
                <div class="form-group">
                    <label for="phoneno">Phone no.</label>
                    <input type="text" class="form-control" name="phoneno" id="phoneno" aria-describedby="phoneno">
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
                    <label for="address">Address</label>
                    <textarea class="form-control" name="address" id="address" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="dob">Date Of Birth</label>
                    <input type="date" class="form-control" name="dob" id="dob" aria-describedby="dob" placeholder="">
                </div>
                <div class="form-group">
                    <label for="phoneno">Role</label>
                    <input type="text" class="form-control" name="role" id="role" aria-describedby="role">
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