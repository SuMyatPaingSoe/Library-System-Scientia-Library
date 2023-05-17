<?php
    session_start();
    include('config/connect.php');
    include('config/purchase_function.php');

    if (isset($_GET['PurchaseID'])) {
        $purchase_id = $_GET['PurchaseID'];

        $query = "SELECT * FROM purchases p, purchase_details pd, librarians l, suppliers s WHERE
                                    p.purchase_id = '$purchase_id' AND
                                    pd.purchase_id = p.purchase_id AND
                                    p.librarian_id = l.librarian_id AND
                                    p.supplier_id = s.supplier_id";
        $result = mysqli_query($connect, $query);
        $purchase = mysqli_fetch_array($result);
    }

    
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="images/Consulting.png" type="image/x-icon">
    <title>Scientia Library - Purchase Book</title>
    <link rel="stylesheet" href="vendor/css/bootstrap.min.css">
    <link rel="stylesheet" href="fonts/fontawesome-free/css/all.css">
    <link rel="stylesheet" href="vendor/DataTables/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="vendor/DataTables/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="vendor/bootstrap-select/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="css/style.css">

<body>
    <?php
        include('includes/admin_header.php');
    ?>
    <section class="purchase-details-section pt-5">
        <div class="container pt-5">
            <h4 class="font-weight-bold">Purchase Details</h4>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="purchase_id">Purchase ID</label><br>
                        <input type="text" class="form-control border-0 bg-transparent text-dark font-weight-bold"
                            value="<?php echo $purchase['purchase_id'] ?>" id="purchase_id" disabled>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="date">Purchase Date</label><br>
                        <input type="text" class="form-control border-0 bg-transparent text-dark font-weight-bold"
                            value="<?php echo $purchase['purchase_date'] ?>" id="date" disabled>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="status">Status</label><br>
                        <input type="text" class="form-control border-0 bg-transparent text-dark font-weight-bold"
                            value="<?php echo $purchase['purchase_status'] ?>" id="status" disabled>
                    </div>

                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="purchaser">Purchaser</label><br>
                        <input type="text" class="form-control border-0 bg-transparent text-dark font-weight-bold"
                            value="<?php echo $purchase['first_name'] . " " . $purchase['last_name'] ?>" id="purchaser"
                            disabled>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="supplier">Supplier</label><br>
                        <input type="text" class="form-control border-0 bg-transparent text-dark font-weight-bold"
                            value="<?php echo $purchase['supplier_name'] ?>" id="supplier" disabled>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <h4 class="font-weight-bold">Purchase Details</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th>Book Title</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                            $purchase_details_query = "SELECT * FROM purchase_details pd, books b, purchases p
                                                       WHERE pd.purchase_id = '$purchase_id'
                                                       AND pd.purchase_id = p.purchase_id
                                                       AND pd.book_id = b.book_id";
                            $purchase_details_run = mysqli_query($connect, $purchase_details_query);
                            $purchase_details_count = mysqli_num_rows($purchase_details_run);

                            for ($i = 0; $i < $purchase_details_count; $i++) {
                                $purchase_details = mysqli_fetch_array($purchase_details_run);
                                $amount = $purchase_details['purchase_price'] * $purchase_details['purchase_quantity'];
                        ?>
                    <tr>
                        <td>
                            <img src="<?php echo $purchase_details['cover'] ?>"
                                alt="<?php echo $purchase_details['book_title'] ?>" width="200">
                        </td>
                        <td><?php echo $purchase_details['book_title'] ?></td>
                        <td><?php echo $purchase_details['purchase_quantity'] ?> Pcs</td>
                        <td><?php echo $purchase_details['purchase_price'] ?> MMK</td>
                        <td><?php echo $amount ?> MMK</td>
                    </tr>
                    <?php
                            }
                        ?>
                    <tr>
                        <th colspan="4" class="text-right">Total Quantity</th>
                        <td><?php echo $purchase['total_quantity'] ?> Pcs</td>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-right">Total Amount</th>
                        <td><?php echo $purchase['total_amount'] ?> MMK</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="container">
            <?php
                if ($purchase['purchase_status'] == 'Pending') {
                    echo "<a href='approve_purchase.php?PurchaseID=$purchase_id' class='btn btn-outline-primary'>Approve</a>";
                } elseif ($purchase['purchase_status'] == 'Approved') {
                    echo "<a href='complete_purchase.php?PurchaseID=$purchase_id' class='btn btn-outline-success'>Complete</a>";
                } elseif ($purchase['purchase_status'] == 'Complete') {
                    echo "<button class='btn btn-outline-success'><i class='fa-solid fa-check'></i> Completed</button>";
                }
            ?>
        </div>
    </section>
    <?php
        include('includes/admin_footer.php');
    ?>
</body>
<script src=" vendor/jquery/jquery.min.js"></script>
<script src="vendor/DataTables/js/jquery.dataTables.min.js"></script>
<script src="vendor/DataTables/js/dataTables.bootstrap5.min.js"></script>
<script src="vendor/DataTables/js/dataTables.responsive.min.js"></script>
<script src="vendor/DataTables/js/responsive.bootstrap5.min.js"></script>
<script src="vendor/js/bootstrap.bundle.min.js"></script>
<script src="js/admin_nav.js"></script>
<script src="js/script.js" charset="utf-8"></script>
<script src="vendor/bootstrap-select/js/bootstrap-select.min.js"></script>
<script>
$(function() {
    $('.selectpicker').selectpicker();
});
</script>

</html>