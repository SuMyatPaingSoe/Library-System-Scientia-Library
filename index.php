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
    <link rel="stylesheet" href="fonts/fontawesome-free/css/all.min.css">
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
        include('includes/search_form.php');
    ?>

    <section class="welcome">
        <div class="container">
            <h4>Welcome to Scientia Library</h4>
            <hr>
            <p class="welcome-text text-start">Scientia Library offers extensive resources
                for our community. Through Scientia Library, you can enjoy the library catalogue and keep yourself
                updated with our library. You can access, borrow and return ebooks online at any time. With the Scientia
                Library eLibrary you can borrow a wide range of books such as eBooks, ePapers.
                This offer is available to all Scientia Library users. When you use our eLibrary for the first time,
                we recommend that you visit our Get a Library Card.
                Registering for our eLibrary is carried out via Get a Library Card.
            </p>
            <br>
        </div>
    </section>
    <section class="new-arrival">
        <div class="container">
            <h4>New Acquisitions</h4>
            <hr>
            <div class="row">
                <?php
                    $bookstmt = "SELECT * FROM books b, authors a WHERE b.author_id = a.author_id ORDER BY book_id DESC LIMIT 4";
                    $bookquery = mysqli_query($connect, $bookstmt);
                    $bookcount = mysqli_num_rows($bookquery);

                    for ($i=0; $i < $bookcount; $i++) { 
                        $data = mysqli_fetch_array($bookquery);

                        $book_title = $data['book_title'];
                        $author_name = $data['author_name'];
                        $cover = $data['cover'];
                ?>
                <div class="col-lg-3 col-md-6 py-3">
                    <a href="book_info.php?book_id=<?php echo $data['book_id'] ?>"
                        class="book-link text-decoration-none text-dark fw-bold">
                        <div class="card mx-auto rounded">
                            <img src="<?php echo $cover ?>" class="w-100" height="380" alt="<?Php echo $book_title ?>">
                            <div class="card-body">
                                <span class="font-weight-bold"><?php echo $book_title ?> by
                                    <?php echo $author_name ?></span>
                            </div>
                        </div>
                    </a>
                </div>
                <?php

                    }
                                                    
                ?>
            </div>
        </div>
    </section>
    <!-- <section class="news">
        <div class="container">
            <h4>News & Events</h4>
            <hr>
            <div class="row">
                <div class="col-lg-4 py-3">
                    <div class="card">
                        <img src="https://blog.arduino.cc/wp-content/uploads/2018/09/21992798_2064914543534854_4896369861147824557_o.jpg"
                            alt="">
                        <div class="card-body">
                            <h4>Arduino Event for Kids</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quaerat fugit ad, nam aliquam
                                eos quasi ut quo maiores ea eveniet veniam, quia harum dolorem deleniti ducimus iusto
                                expedita minus accusantium.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 py-3">
                    <div class="card">
                        <img src="images/istockphoto-583816330-612x612.jpg" alt="">
                        <div class="card-body">
                            <h4>Online Book Discussion</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor mollitia eveniet odit
                                optio officia quae inventore provident ipsum saepe vel! In error dolores totam, commodi
                                eligendi nam recusandae qui magnam.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 py-3">
                    <div class="card">
                        <img src="https://www.avpartners.com/wp-content/uploads/2017/08/Seminars-1.jpg" alt="">
                        <div class="card-body">
                            <h4>Seminar for Job Opportunities</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique quia voluptates
                                voluptate beatae fugit error unde aperiam ex asperiores voluptatum, earum itaque odit,
                                veritatis ducimus?</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
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