<?php
    session_start();
    include('config/connect.php');

    if(isset($_SESSION['member_id']) || isset($_SESSION['librarian_id'])) {
        header('Location: index.php');
    }

    if (isset($_POST['btnlogin'])) {
        $email=$_POST['email'];
		$password=md5($_POST['password']);

		$select="SELECT * FROM members
				 WHERE email='$email'
				 AND password='$password'";
		$query=mysqli_query($connect,$select);
		$memberexistscount=mysqli_num_rows($query);

        $librarianselect="SELECT * FROM librarians
				 WHERE email='$email'
				 AND password='$password'";
		$librarianquery=mysqli_query($connect,$librarianselect);
		$librarianexistscount=mysqli_num_rows($librarianquery);

		if ($memberexistscount < 1 && $librarianexistscount < 1) {
            echo "<script>window.alert('Wrong Email or Password. Pls try again.')</script>";
            echo "<script>window.location='login.php'</script>";
		}
		else {
            if ($memberexistscount == 1) {
                //librarian checkout and login

                $arr=mysqli_fetch_array($query);
                if ($arr['status'] == 'active') {
                    $_SESSION['member_id']=$arr['member_id'];
                    $_SESSION['email']=$arr['email'];
                    $_SESSION['first_name']=$arr['first_name'];
                    $_SESSION['last_name']=$arr['last_name'];
                    // $_SESSION['address']=$arr['address'];
                    $_SESSION['phone_no']=$arr['phone_no'];
                    //$_SESSION['expiry_date'] = $arr['expiry_date'];

                    $showModal = true;
                    $processSuccess = true;
                    $Message = 'Login Successful!';
                    $MessageTitle = 'Success';
                    $alert = 'alert-success';
                    $RedirectUrl = 'profile.php';
                } else {
                    $showModal = true;
                    $processSuccess = false;
                    $Message = 'Account not activated yet! Please confirm with the library.';
                    $MessageTitle = 'Pending Account';
                    $alert = 'alert-danger';
                    $RedirectUrl = 'index.php';
                }

            }

            if ($librarianexistscount == 1) {
                $arr=mysqli_fetch_array($librarianquery);
                $_SESSION['librarian_id']=$arr['librarian_id'];
                $_SESSION['email']=$arr['email'];
                $_SESSION['first_name']=$arr['first_name'];
                $_SESSION['last_name']=$arr['last_name'];
                // $_SESSION['address']=$arr['address'];
                $_SESSION['phone_no']=$arr['phone_no'];
                // $_SESSION['expiry_date'] = $arr['expiry_date'];

                $showModal = true;
                $processSuccess = true;
                $Message = 'Login Successful!';
                $MessageTitle = 'Success';
                $alert = 'alert-success';
                $RedirectUrl = 'admin.php';
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
    <section class="vh-50 gradient-custom login">
        <div class="container mt-5">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="card-body px-5 py-4">
                            <h5 class="fw-bold mb-4 text-center">Log in!</h5>
                            <form action="login.php" method="post">
                                <div class="form-group">
                                    <label class="form-label" for="email">Email or Library card
                                        ID</label>
                                    <input type="email" name="email" class="form-control" />
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="typePasswordX">Password</label>
                                    <input type="password" name="password" class="form-control" />
                                </div>
                                <div>
                                    <button class="btn text-light login-btn px-4 rounded rounded-pill" name="btnlogin"
                                        type="submit">Log
                                        in</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
<?php
    if (isset($showModal) && $showModal) {
        echo '<script type="text/javascript">
            $(document).ready(function(){
                $("#MessageModal").modal("show");
            });
        </script>';
    }

?>
<script>
function redirect() {
    window.location = "<?php echo $RedirectUrl; ?>";
}
</script>

</html>