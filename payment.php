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
    <section class="welcome p-4">
        <div class="container">
            <h4 style="color: #b9936c;">How To Make Payment</h4>
            <hr>
            <p class="welcome-text text-start" style="color:black;">
                For KBZ Pay <br>
                Account Number :: <b>3532 8754 0943 6642</b> <br>
                Account Name :: <span style="color: #b9936c;">Scientia Library</span>
            </p>
            <p class="welcome-text text-start" style="color:black;">
                For CB Pay <br>
                Account Number :: <b>8643 9834 6523 6612</b> <br>
                Account Name :: <span style="color: #b9936c;">Scientia Library</span>
            </p>
            <p class="welcome-text text-start" style="color:black;">
                For AYA Pay <br>
                Account Number :: <b>5467 0943 5186 4389</b> <br>
                Account Name :: <span style="color: #b9936c;">Scientia Library</span>
            </p>
        </div>
    </section>
    <section class="welcome">
        <div class="container">
            <h4 style="color: #b9936c;">Important Notice!</h4>
            <p class="welcome-text text-start alert alert-info">Once your registration is complete,
                we will send you a confirmation email. <br> You will also receive a separate
                email that includes details on how to access our library. <br> Membership fees is
                2 lakhs and A Life Time membership gives you instant access to our Library.
            </p>
            <br>
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