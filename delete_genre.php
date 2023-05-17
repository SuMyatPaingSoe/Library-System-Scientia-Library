<?php

    session_start();
    include('config/connect.php');

    $genre_id=$_GET['GenreID'];

    $delete="DELETE FROM genres WHERE genre_id='$genre_id'";
    $deleterun=mysqli_query($connect,$delete);
    $RedirectUrl = 'manage_genre.php';

    if ($deleterun) 
    {
        $showModal = true;
        $processSuccess = true;
        $Message = 'Genre Delete Successful!';
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