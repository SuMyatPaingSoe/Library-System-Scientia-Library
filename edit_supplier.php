<?php
session_start();
include('config/connect.php');

if (isset($_REQUEST['SupplierID'])) {
    $supplier_id = $_REQUEST['SupplierID'];
    $select = "SELECT * FROM suppliers WHERE supplier_id='$supplier_id'";
    $run = mysqli_query($connect, $select);
    $data = mysqli_fetch_array($run);

    if (isset($_POST['btnupdate'])) {
        $supplier_name = $_POST['suppliername'];
        $address = $_POST['location'];
        $phoneno = $_POST['phoneno'];

        $update = "UPDATE `suppliers` 
        SET 
        `supplier_name`='$supplier_name',
        `address`='$address',
        `phone_no`='$phoneno'
        WHERE `supplier_id` = $supplier_id";

        $urun = mysqli_query($connect, $update);
        if ($urun) {
            echo "<script>alert('Supplier Data Update Successful!')</script>";
            echo "<script>location='manage_supplier.php'</script>";
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
                            <h5 class="font-weight-bold mb-4 text-center">Edit Supplier</h5>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="suppliername">Supplier Name</label>
                                    <input type="text" class="form-control" name="suppliername" id="suppliername"
                                        value="<?php echo $data['supplier_name'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="location">Address</label>
                                    <textarea class="form-control" name="location" id="location"
                                        rows="3"><?php echo $data['address'] ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="phoneno">Phone no.</label>
                                    <input type="text" class="form-control" name="phoneno" id="phoneno"
                                        value="<?php echo $data['phone_no'] ?>">
                                </div>
                                <div>
                                    <button class="btn add-btn" type="submit" name="btnupdate">Submit</button>
                                </div>
                            </form>
                        </div>
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

</html>