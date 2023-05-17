<?php
    include('config/connect.php');

    if (isset($_GET['PurchaseID'])) {
        $purchase_id = $_GET['PurchaseID'];
        $complete_query = "UPDATE purchases SET purchase_status = 'Complete' WHERE purchase_id = '$purchase_id'";
        $complete_run = mysqli_query($connect, $complete_query);

        $select_purchased_books_query = "SELECT * FROM purchase_details WHERE purchase_id = '$purchase_id'";
        $select_purchased_books_run = mysqli_query($connect, $select_purchased_books_query);
        $purchased_books = mysqli_fetch_array($select_purchased_books_run);
        $purchased_books_count = mysqli_num_rows($select_purchased_books_run);
        $increase_quantity_result = 0;

        for ($i=0; $i < $purchased_books_count; $i++) { 
            $purchased_quantity = $purchased_books['purchase_quantity'];
            $purchased_book_id = $purchased_books['book_id'];
            $increase_quantity_query = "UPDATE books SET quantity = quantity + $purchased_quantity,
                                                         on_shelf = on_shelf + $purchased_quantity
                                                         WHERE book_id = $purchased_book_id";
            $increase_quantity_run = mysqli_query($connect, $increase_quantity_query);
            $increase_quantity_result++;
        }
        

        
        if($complete_run && ($increase_quantity_result == $purchased_books_count)) {
            $showModal = true;
            $processSuccess = true;
            $Message = 'Purchase Completed!';
            $MessageTitle = 'Success';
            $alert = 'alert-success';
            $RedirectUrl = 'book_purchase.php';
        } else {
            $showModal = true;
            $processSuccess = false;
            $Message = 'Error: ' . mysqli_error($connect);
            $MessageTitle = 'Error';
            $alert = 'alert-danger';
            $RedirectUrl = 'book_purchase.php';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Purchase</title>
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