<?php

    session_start();
    include('config/connect.php');

    $supplier_id=$_GET['SupplierID'];

    $delete="DELETE FROM suppliers WHERE supplier_id='$supplier_id'";
    $deleterun=mysqli_query($connect,$delete);

    if ($deleterun) 
    {
        echo "<script>window.alert('Supplier delete completed!')</script>";
        echo "<script>window.location='manage_supplier.php'</script>";
    }
    else
    {
        echo mysqli_error($connect);
    }