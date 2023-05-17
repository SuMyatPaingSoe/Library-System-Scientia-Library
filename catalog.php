<?php
    include('config/connect.php');
    session_start();


    if (isset($_GET['btnSearch'])) {
        $keyword = $_GET['keyword'];
        $result = array();

        $query = "SELECT * FROM books b, authors a, genres g
                  WHERE b.author_id = a.author_id
                  AND b.genre_id = g.genre_id";
        $queryrun = mysqli_query($connect, $query);
        while($row = mysqli_fetch_assoc($queryrun)) {
            foreach ($row as $column) {
                if (str_contains($column, $keyword)) {
                    array_push($result, $row);
                    break;
                }
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
    <section class="search p-5">
        <!-- <div class="advanced-search">
            <a href="">Advanced Search</a>
        </div> -->
        <div class="d-flex justify-content-center w-100">
            <form class="input-group search-group w-50 shadow rounded" action="" method="get">
                <input type="search" name="keyword" class="form-control" placeholder="Search a book or audio"
                    aria-label="Search" aria-describedby="search-addon" />
                <button type="submit" name="btnSearch" class="btn btn-md search-btn rounded-end border border-1"><i
                        class="fa-solid fa-md fa-magnifying-glass"></i> &nbsp;&nbsp;search</button>
            </form>
        </div>
    </section>
    <section class="catalog">
        <div class="container">
            <div class="row">
                <?php
                    if (isset($result)) {
                        foreach ($result as $item) {
                            
                ?>
                <div class="col-lg-3 col-md-6 py-3">
                    <a href="book_info.php?book_id=<?php echo $item['book_id'] ?>"
                        class="book-link text-decoration-none text-dark fw-bold">
                        <div class="card mx-auto rounded">
                            <img src="<?php echo $item['cover'] ?>" class="w-100" height="380"
                                alt="<?php echo $item['book_title'] ?>">
                            <div class="card-body">
                                <span class="font-weight-bold"><?php echo $item['book_title'] ?> by
                                    <?php echo $item['author_name'] ?></span>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
                        }
                } else {
                    $bookstmt = "SELECT * FROM books b, authors a WHERE b.author_id = a.author_id";
                    $bookquery = mysqli_query($connect, $bookstmt);
                    $bookcount = mysqli_num_rows($bookquery);

                    for ($i=0; $i < $bookcount; $i++) {
                        $data=mysqli_fetch_array($bookquery);
                ?>
                <div class="col-lg-3 col-md-6 py-3">
                    <a href="book_info.php?book_id=<?php echo $data['book_id'] ?>"
                        class="book-link text-decoration-none text-dark fw-bold">
                        <div class="card mx-auto rounded">
                            <img src="<?php echo $data['cover'] ?>" class="w-100" height="380"
                                alt="<?php echo $data['book_title'] ?>">
                            <div class="card-body">
                                <span class="font-weight-bold"><?php echo $data['book_title'] ?> by
                                    <?php echo $data['author_name'] ?></span>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
                        }
                    }                                          
                ?>
            </div>
            <div class="row">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>

    </section>
    <?php
        include('includes/admin_footer.php');
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