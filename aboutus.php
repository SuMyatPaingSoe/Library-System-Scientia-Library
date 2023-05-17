<?php
    session_start();
    include('config/connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="images/Consulting.png" type="image/x-icon">
    <link rel="icon" href="images/Scientia-portrait-white-bg.svg" type="image/x-icon">
    <title>Scientia Library - Home</title>
    <link rel="stylesheet" href="vendor/css/bootstrap.min.css">
    <link rel="stylesheet" href="fonts/fontawesome-free/css/all.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
        include('includes/header.php');
    ?>
    <section class="home" id="home">
        <div class="banner w-100 py-5">
            <div class="banner-text text-center w-100">
                <h1>Welcome to <br><b style="color: #dda83f;">Scientia</b> Library</h1>
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