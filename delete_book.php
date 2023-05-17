<?php

    session_start();
    include('config/connect.php');

    $bookid=$_GET['BookID'];

    $delete="DELETE FROM books WHERE book_id='$bookid'";
    $deleterun=mysqli_query($connect,$delete);

    $RedirectUrl = 'manage_book.php';

    if ($deleterun) 
    {
        $showModal = true;
        $processSuccess = true;
        $Message = 'Book Delete Successful!';
        $MessageTitle = 'Success';
        $alert = 'alert-success';
    }
    else
    {
        $showModal = true;
        $processSuccess = false;
        $Message = 'Error: ' . mysqli_error($connect);
        $MessageTitle = 'Something Went Wrong!';
        $alert = 'alert-danger';
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete book</title>
    <link rel="stylesheet" href="vendor/css/bootstrap.min.css">
    <link rel="stylesheet" href="fonts/fontawesome-free/css/all.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    include('includes/message_modal.php');
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

    if(isset($processSuccess) && $processSuccess) {
        $RedirectUrl = 'manage_book.php';
    } else {
        $RedirectUrl = basename($_SERVER['PHP_SELF']);
    }
?>
<script>
function redirect() {
    window.location = "<?php echo $RedirectUrl; ?>";
}
</script>

</html>