<?php
    session_start();
    include('config/connect.php');
    include('config/purchase_function.php');
    include('config/auto_assign_id.php');

    if (isset($_POST['btnSave'])) 
    {
        $supplierid=$_POST['txtsupplierid'];
        $librarianid=$_POST['txtlibrarianid'];
        $txtpurchaseid=$_POST['txtpurchaseid'];
        // $govtax=CalculateTax();
        $txtpurchasedate=$_POST['txtpurchasedate'];
        $TotalAmount=$_POST['txttotalamount'];
        $Totalquantity=$_POST['txttotalqty'];
        $Status="Pending";
        $insert_pur="INSERT INTO purchases
        (`purchase_id`,`purchase_date`,`total_quantity`,`total_amount`,`purchase_status`,`librarian_id`,`supplier_id`)values
        ('$txtpurchaseid','$txtpurchasedate','$Totalquantity','$TotalAmount','$Status','$librarianid','$supplierid')";
        $ret=mysqli_query($connect,$insert_pur);
        
        $size=count($_SESSION['purchase_function']);
        for ($i=0; $i <$size ; $i++) 
        { 
            $bookid=$_SESSION['purchase_function'][$i]['book_id'];
            $purchaseprice=$_SESSION['purchase_function'][$i]['purchase_price'];
            $purchasequantity=$_SESSION['purchase_function'][$i]['purchase_quantity'];
            $inser_PDetail="INSERT INTO purchase_details(`purchase_id`,`book_id`,`purchase_price`,`purchase_quantity`)
            VALUES('$txtpurchaseid','$bookid','$purchaseprice','$purchasequantity')";
            $ret=mysqli_query($connect,$inser_PDetail);
        }

        if ($ret)
        {
            unset($_SESSION['purchase_function']);
            echo "<script>window.alert('Purchase Process Complete.')</script>";
            echo "<script>window.location='book_purchase.php'</script>";
        }
        else
        {
            echo "<p>Something went wrong in purchase:". mysqli_error($connect)."</p>";
            die();
        }
    }
    
    if (isset($_POST['btnAdd'])) 
    {
        $bookid=$_POST['txtbookid'];
        $purchaseprice=$_POST['txtpurchaseprice'];
        $purchasequantity=$_POST['txtpurchasequantity'];
        Add($bookid,$purchaseprice,$purchasequantity);
    } elseif (isset($_GET['action'])) {

        $action=$_GET['action'];
        if ($action==='remove') 
        {
            $bookid=$_GET['bookid'];
            Remove($bookid);
        }
        elseif ($action==='clearall') 
        {
            ClearAll();
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
    <section class="purchase-list pt-5">
        <div class="container pt-5">
            <h4 class="font-weight-bold">Purchases</h4>
            <table id="list_table" class="table w-100 table-sm table-white table-hover">
                <thead>
                    <tr>
                        <th>Purchase ID</th>
                        <th>Purchase Date</th>
                        <th>Total Cost</th>
                        <th>Purchaser</th>
                        <th>Supplier</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = "SELECT * FROM purchases p, librarians l, suppliers s WHERE
                                p.librarian_id = l.librarian_id AND
                                p.supplier_id = s.supplier_id";
                        $result = mysqli_query($connect, $query);
                        $count = mysqli_num_rows($result);
                    
                        if($count < 1) {
                            echo "<p>No Data Found!</p>";
                        } else {
                            for ($i = 0; $i < $count; $i++) {
                                    $arr = mysqli_fetch_array($result);
                                    $purchase_id = $arr['purchase_id'];

                                    echo "<tr>";
                                    echo "<td>" . $arr['purchase_id'] . "</td>";
                                    echo "<td>" . $arr['purchase_date'] . "</td>";
                                    echo "<td><b>" . $arr['total_amount'] . "</b> MMK</td>";
                                    echo "<td>" . $arr['first_name'] . " " . $arr['last_name'] . "</td>";
                                    echo "<td>" . $arr['supplier_name'] . "</td>";
                                    echo "<td>" . $arr['purchase_status'] . "</td>";
                                    echo "<td>";
                    ?>
                    <a class='btn btn-outline-primary'
                        href='purchase_details.php?PurchaseID=<?php echo $purchase_id?>'>Details</a>
                    <?php
                    if ($arr['purchase_status'] == 'Pending') {
                        echo "<a class=' btn btn-outline-success'
                        href='approve_purchase.php?PurchaseID=$purchase_id'>Approve</a>";
                    } elseif ($arr['purchase_status'] == 'Approved') {
                    echo "<a class=' btn btn-outline-success'
                        href='complete_purchase.php?PurchaseID=$purchase_id'>Complete</a>";
                    }
                    ?>
                    <a class='btn btn-outline-danger'
                        href='delete_purchase.php?PurchaseID=<?php echo $purchase_id?>'>Delete</a>
                    <?php
                                        echo  "</td>";
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
            <h4 class="font-weight-bold">Purchase Books</h4>
            <hr>
            <form action="book_purchase.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Purchase ID</label>
                    <input type="text" class="form-control" name="txtpurchaseid"
                        value="<?php echo assign_id('purchases','purchase_id','PUR-',6)?>" readonly>
                </div>
                <div class="form-group">
                    <label for="title">Purchase Date</label>
                    <input name="txtpurchasedate" type="text" class="form-control" value="<?php echo date('Y-m-d')?>"
                        readonly>
                </div>
                <div class="form-group">
                    <label for="book">Book Title</label>
                    <select class="form-control selectpicker border" name="txtbookid" data-live-search="true" required>
                        <?php
                            $book_query = "SELECT * FROM books";
                            $book_run = mysqli_query($connect, $book_query);
                            $count_book = mysqli_num_rows($book_run);
                            
                            for ($i=0; $i < $count_book; $i++) { 
                                $books = mysqli_fetch_array($book_run);
                                echo "<option value = '" . $books['book_id'] . "' >" . $books['book_title'] . "</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="title">Purchase Price</label>
                    <input name="txtpurchaseprice" type="number" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="title">Purchase Quantity</label>
                    <input name="txtpurchasequantity" type="number" class="form-control" />
                </div>
                <div class="form-group">
                    <input type="submit" value="Add" class="btn btn-success" name="btnAdd">
                </div>
                <table id="list_table" class="table w-100 table-sm table-white table-hover">
                    <thead>
                        <tr>
                            <th>Cover</th>
                            <th>Book ID</th>
                            <th>Book Title</th>
                            <th>Purchase Price</th>
                            <th>Purchase Quantity</th>
                            <th>Sub Total</th>
                            <th>Operation</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if (isset($_SESSION['purchase_function'])) {
                            $size=count($_SESSION['purchase_function']);
                            for ($i=0; $i <$size ; $i++) 
                            { 
                                $image1=$_SESSION['purchase_function'][$i]['cover'];
                                $bookid=$_SESSION['purchase_function'][$i]['book_id'];
                                $booktitle=$_SESSION['purchase_function'][$i]['book_title'];
                                $purchaseprice=$_SESSION['purchase_function'][$i]['purchase_price'];
                                $purchasequantity=$_SESSION['purchase_function'][$i]['purchase_quantity'];
                                $Subtotal=$purchaseprice * $purchasequantity;
                    
                                echo"<tr>";
                                echo"<td><img src='$image1' height='300px'/></td>";
                                echo "<td>$bookid</td>";
                                echo "<td>$booktitle</td>";
                                echo "<td>$purchaseprice MMK</td>";
                                echo "<td>$purchasequantity Pcs</td>";
                                echo "<td>$Subtotal MMK</td>";
                    
                                echo "<td><a class='btn btn-danger' href='book_purchase.php?action=remove&bookid=$bookid'>Remove</a><td>";
                    
                                echo "</tr>";
                            }
                            ?>
                        <tr>
                            <td colspan="5" class="text-right">Total Amount</td>
                            <td colspan="2" class="text-center">
                                <input type="text"
                                    style=" background: none; display: inline-block; width: 100px; color:black;"
                                    name="txttotalamount" class="form-control"
                                    value="<?php echo CalculateTotalAmount() ?>" readonly /><span class="p-1">MMK</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-right">Total Quantity</td>
                            <td colspan="2" class="text-center">
                                <input type="text"
                                    style=" background: none; display: inline-block; width: 100px; color:black;"
                                    name="txttotalqty" class="form-control"
                                    value="<?php echo CalculateTotalQuantity() ?>" readonly /><span
                                    class="p-1">Pcs</span>
                            </td>
                        </tr>
                        <?php
                        } else {
                        ?>
                        <tr>
                            <td colspan="7">
                                <div class="alert alert-warning text-center">
                                    Nothing is still added.
                                </div>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div class="container">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="title">Supplier Name</label>
                            <?php 	
                                $select="SELECT * FROM suppliers";
                                $query=mysqli_query($connect,$select);
                                $count=mysqli_num_rows($query);
                                if($count>0)
                                {
                                    echo "<select name='txtsupplierid' class='form-control selectpicker border'>";
                                    for ($i	=0; $i<$count; $i++) 
                                    { 
                                        $data=mysqli_fetch_array($query);
                                        $suppliername=$data['supplier_name'];
                                        $supplierid=$data['supplier_id'];
                                        echo "<option value='$supplierid'>$suppliername</option>";
                                        
                                    }
                                    echo "</select>";
                                }
                            ?>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="title">Librarian Name</label>
                            <?php 	
                                $select="SELECT * FROM librarians";
                                $query=mysqli_query($connect,$select);
                                $count=mysqli_num_rows($query);
                                if($count>0)
                                {
                                    echo "<select name='txtlibrarianid' class='form-control selectpicker border'>";
                                    for ($i	=0; $i<$count; $i++) 
                                    { 
                                        $data=mysqli_fetch_array($query);
                                        $librarianname=$data['first_name'] . " " . $data['last_name'];
                                        $librarianid=$data['librarian_id'];
                                        echo "<option value='$librarianid'>$librarianname</option>";
                                        
                                    }
                                    echo "</select>";
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-success" type="submit" name="btnSave" value="Save" />
                            <a class="btn btn-danger" href="book_purchase.php?action=clearall">
                                Clear All</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <?php
        include('includes/admin_footer.php');
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
<script src="vendor/bootstrap-select/js/bootstrap-select.min.js"></script>
<script>
$(function() {
    $('.selectpicker').selectpicker();
});
</script>

</html>