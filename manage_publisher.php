<?php
    session_start();
    include('config/connect.php');

    if (isset($_POST['btnAdd'])) {
        $publisher_name = $_POST['name'];
        $address = $_POST['address'];
        $phoneno = $_POST['phoneno'];

        $selectpublisher = "SELECT * FROM publishers
        WHERE publisher_name='$publisher_name'";
        $checkpublisher = mysqli_query($connect,$selectpublisher);
        $countpublisher = mysqli_num_rows($checkpublisher);

        if ($countpublisher == 0) {
            $insert = "INSERT INTO `publishers`(`publisher_name`, `address`, `phone_no`) 
            VALUES ('$publisher_name','$address','$phoneno')";
            $runinsert = mysqli_query($connect, $insert);
            if ($runinsert) {
                $showModal = true;
                $Message = 'Publisher Added Successfully!';
                $MessageTitle = 'Success';
                $alert = 'alert-success';
            } else {
                echo mysqli_error($connect);
            }
        } else {
            $showModal = true;
            $Message = 'Publisher Already Exists!';
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
    <title>Scientia Library - Manage Publisher</title>
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
            <h4 class="font-weight-bold">Publishers</h4>
            <table id="list_table" class="table w-100 table-sm table-white table-hover">
                <thead>
                    <tr>
                        <th>Publisher Name</th>
                        <th>Address</th>
                        <th>Phone no</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                     $query = "SELECT * FROM publishers";
                     $result = mysqli_query($connect, $query);
                     $count = mysqli_num_rows($result);
                 
                     if($count < 1) {
                         echo "<p>No Data Found!</p>";
                     } else {
                        for ($i = 0; $i < $count; $i++) {
                                $arr = mysqli_fetch_array($result);
                                $publisher_id = $arr['publisher_id'];

                                echo "<tr>";
                                echo "<td>" . $arr['publisher_name'] . "</td>";
                                echo "<td>" . $arr['address'] . "</td>";
                                echo "<td>" . $arr['phone_no'] . "</td>";
                                echo "<td>";
                                ?>

                    <a class='btn btn-outline-success'
                        href='edit_publisher.php?PublisherID=<?php echo $publisher_id ?>'>Edit</a>
                    <a class='btn btn-outline-danger'
                        href='delete_publisher.php?PublisherID=<?php echo $publisher_id ?>'
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
            <h4 class="font-weight-bold">Add Publisher</h4>
            <hr>
            <form action="manage_publisher.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Publisher Name</label>
                    <input type="text" class="form-control" name="name" id="name" aria-describedby="name" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea class="form-control" name="address" id="address" required rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="phoneno">Phone no.</label>
                    <input type="text" class="form-control" name="phoneno" id="phoneno" aria-describedby="phoneno"
                        required>
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
    if ($showModal) {
        echo '<script type="text/javascript">
			$(document).ready(function(){
				$("#MessageModal").modal("show");
			});
		</script>';
    }
?>

</html>