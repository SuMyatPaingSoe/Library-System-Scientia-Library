<?php
    session_start();
    include('config/connect.php');

    if(isset($_GET['reserve_book'])) {
        $book_id = $_GET['reserve_book'];
        $member_id = $_SESSION['member_id'];

        $RedirectUrl = "book_info.php?book_id=$book_id";


        $selectreserve = "SELECT * FROM reserved
        WHERE book_id='$book_id' AND member_id = '$member_id'";
        $checkreserve = mysqli_query($connect,$selectreserve);
        $countreserve = mysqli_num_rows($checkreserve);

        if ($countreserve == 0) {
            $reserve_stmt = "INSERT INTO `reserved` (`book_id`, `member_id`) 
                                VALUES('$book_id', '$member_id')";
            $reserve_query = mysqli_query($connect, $reserve_stmt);
            if ($reserve_query) {
                $showModal = true;
                $Message = 'Book Reserved Successfully!';
                $MessageTitle = 'Success';
                $alert = 'alert-success';
            } else {
                $showModal = true;
                $Message = 'Error: ' . mysqli_error($connect);
                $MessageTitle = 'Error';
                $alert = 'alert-Warning';
            }
        } else {
            $showModal = true;
            $Message = 'Book Already Reserved!';
            $MessageTitle = 'Warning';
            $alert = 'alert-warning';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve</title>
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
<script src="vendor/js/bootstrap.bundle.min.js"></script>
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