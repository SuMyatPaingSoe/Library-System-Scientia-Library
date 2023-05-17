<?php
    session_start();
    include('config/connect.php');

    // if (!isset($_SESSION['member_id']))
    // {
    //     echo"<script>
    //             alert('Please login first')
    //             window.location='login.php'
    //         </script>";
    // }



    $book_id = $_GET['book_id'];

    $bookdetailsstmt = "SELECT b.*, g.genre_title, a.author_name, p.publisher_name
                        FROM books b, genres g, authors a, publishers p
                        WHERE b.book_id = '$book_id'
                        AND b.genre_id = g.genre_id
                        AND b.author_id = a.author_id
                        AND b.publisher_id = p.publisher_id";
    $bookdetailsquery = mysqli_query($connect, $bookdetailsstmt);
    $count = mysqli_num_rows($bookdetailsquery);
    $row = mysqli_fetch_array($bookdetailsquery);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
    <section class="search p-3">
        <!-- <div class="advanced-search">
            <a href="">Advanced Search</a>
        </div>
        <div class="d-flex justify-content-center w-100">
            <form class="input-group search-group w-50 shadow rounded" method="post">
                <input type="search" name="keyword" class="form-control" placeholder="Search a book or audio"
                    aria-label="Search" aria-describedby="search-addon" />
                <button type="button" class="btn btn-md search-btn rounded-end border border-1"><i
                        class="fa-solid fa-md fa-magnifying-glass"></i> &nbsp;&nbsp;search</button>
            </form>
        </div> -->
    </section>
    <section class="book-display">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 d-flex justify-content-center">
                    <div class="container">
                        <img src="<?php echo $row['cover'] ?>" class="w-100" alt="Kafka on the Shore">
                    </div>
                </div>
                <div class="col-lg-8 py-5">
                    <h4 class="fw-bold"><?php echo $row['book_title'] ?></h4>
                    <p><?php echo $row['description'] ?></p>
                    <table class="table table-sm table-borderless caption-top">
                        <caption class="fw-bold"></caption>
                        <tbody>
                            <tr>
                                <th>Publisher </th>
                                <td><?php echo $row['publisher_name'] ?></td>
                            </tr>
                            <tr>
                                <th>Published </th>
                                <td><?php echo $row['publication_year'] ?></td>
                            </tr>
                            <tr>
                                <th>ISBN Number </th>
                                <td><?php echo $row['isbn'] ?></td>
                            </tr>
                            <tr>
                                <th>Genre </th>
                                <td><?php echo $row['genre_title'] ?></td>
                            </tr>
                            <tr>
                                <th>Description </th>
                                <td><?php echo $row['pages'] ?> pages</td>
                            </tr>
                            <tr>
                                <th>Language </th>
                                <td><?php echo $row['language'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">

                        <div class="col-sm-4 d-flex justify-content-start">
                            <?php 
                                if(!empty($row['e_file']) && (isset($_SESSION['member_id']) || isset($_SESSION['librarian_id']))) {
                            ?>
                            <a href="<?php echo $row['e_file'] ?>"
                                class="rounded-pill btn btn-outline-warning">Download</a>
                            <?php 
                                }
                            ?>
                        </div>

                        <div class="col-sm-4 text-end">
                            <?php 
                                if ($row['quantity'] == 0) {
                                    echo "<span class='text-danger'>Not Available Currently</span>";
                                }
                            ?>
                        </div>
                        <div class="col-sm-4 d-flex justify-content-start">
                            <a href="reserve.php?reserve_book=<?php echo $_GET['book_id'] ?>"
                                class="btn btn-outline-warning rounded-pill">Place Hold</a>
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
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js" charset="utf-8"></script>

</html>