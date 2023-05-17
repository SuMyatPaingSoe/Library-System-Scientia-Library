<?php
    session_start();
    include('config/connect.php');

    if (isset($_REQUEST['BookID'])) {
        $bookid = $_REQUEST['BookID'];
        $select = "SELECT * FROM books WHERE book_id='$bookid'";
        $run = mysqli_query($connect, $select);
        $data = mysqli_fetch_array($run);

        if (isset($_POST['btnupdate'])) {
            $title = $_POST['booktitle'];
            $isbn = $_POST['isbnno'];
            $language = $_POST['language'];
            $author = $_POST['author'];
            $publisher = $_POST['publisher'];
            $genre = $_POST['genre'];
            $publishedyear = $_POST['published'];
            $quantity = $_POST['quantity'];
            $description = addslashes($_POST['description']);
            $edition = $_POST['edition'];
            $pages = $_POST['pages'];

            if($_FILES['e-file']['size'] != 0) {
                $file = $_FILES['e-file']['name'];
                $folder = "Book Files/";
                $FileName=$folder. '_' .$file;
                $copy = copy($_FILES['e-file']['tmp_name'], $FileName);

                if (!$copy) 
                {
                    echo "<p>File Upload unsuccessful...</p>";
                    exit();
                }

                $update = "UPDATE `books` 
                SET 
                `book_title`='$title',
                `isbn`='$isbn',
                `pages`='$pages',
                `language`='$language',
                `edition`='$edition',
                `author_id`='$author',
                `publisher_id`='$publisher',
                `genre_id`='$genre',
                `publication_year`='$publishedyear',
                `description`='$description',
                `quantity`='$quantity',
                `e_file`='$FileName' WHERE `book_id` = $bookid";
                $urun = mysqli_query($connect, $update);
                if ($urun) {
                    echo "<script>alert('Book Data Update Successful!')</script>";
                    echo "<script>location='manage_book.php'</script>";
                } else {
                    echo mysqli_error($connect);
                }
            }

            if(($_FILES['bookcover']['size'] !=0) && ($_FILES['e-file']['size'] != 0) ) {
                $file = $_FILES['e-file']['name'];
                $folder1 = "Book Files/";
                $FileName1=$folder1. '_' .$file;
                $copy1 = copy($_FILES['e-file']['tmp_name'], $FileName1);

                $image=$_FILES['bookcover']['name'];
                $folder2="Book Images/";
                $FileName2=$folder2. '_' .$image;
                $copy2=copy($_FILES['bookcover']['tmp_name'], $FileName2);

                if (!$copy1) 
                {
                    echo "<p>File Upload unsuccessful...</p>";
                    exit();
                }

                if(!$copy2) {
                    echo "<p>Image Upload unsuccessful...</p>";
                    exit();
                }

                $update = "UPDATE `books` 
                SET 
                `book_title`='$title',
                `isbn`='$isbn',
                `pages`='$pages',
                `language`='$language',
                `edition`='$edition',
                `author_id`='$author',
                `publisher_id`='$publisher',
                `genre_id`='$genre',
                `publication_year`='$publishedyear',
                `description`='$description',
                `quantity`='$quantity',
                `cover`='$FileName2'
                `e_file`='$FileName1' WHERE `book_id` = $bookid";
                $urun = mysqli_query($connect, $update);
                if ($urun) {
                    echo "<script>alert('Book Data Update Successful!')</script>";
                    echo "<script>location='manage_book.php'</script>";
                } else {
                    echo mysqli_error($connect);
                }

            }

            if($_FILES['bookcover']['size'] != 0) {
                //Image Upload---------------
                $image=$_FILES['bookcover']['name'];
                $folder="Book Images/";
                $FileName=$folder. '_' .$image;
                $copy=copy($_FILES['bookcover']['tmp_name'], $FileName);

                if (!$copy) 
                {
                    echo "<p>Image Upload unsuccessful...</p>";
                    exit();
                }

                $update = "UPDATE `books` 
                SET 
                `book_title`='$title',
                `isbn`='$isbn',
                `pages`='$pages',
                `language`='$language',
                `edition`='$edition',
                `author_id`='$author',
                `publisher_id`='$publisher',
                `genre_id`='$genre',
                `publication_year`='$publishedyear',
                `description`='$description',
                `quantity`='$quantity',
                `cover`='$FileName' WHERE `book_id` = $bookid";
                $urun = mysqli_query($connect, $update);
                if ($urun) {
                    echo "<script>alert('Book Data Update Successful!')</script>";
                    echo "<script>location='manage_book.php'</script>";
                } else {
                    echo mysqli_error($connect);
                }
            } else {
                $update = "UPDATE `books` 
                SET 
                `book_title`='$title',
                `isbn`='$isbn',
                `pages`='$pages',
                `language`='$language',
                `edition`='$edition',
                `author_id`='$author',
                `publisher_id`='$publisher',
                `genre_id`='$genre',
                `publication_year`='$publishedyear',
                `description`='$description',
                `quantity`='$quantity' WHERE `book_id` = $bookid";
                $urun = mysqli_query($connect, $update);
                if ($urun) {
                    echo "<script>alert('Book Data Update Successful!')</script>";
                    echo "<script>location='manage_book.php'</script>";
                } else {
                    echo mysqli_error($connect);
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
    <link rel="icon" href="images/Consulting.png" type="image/x-icon">
    <title>Scientia Library - Admin</title>
    <link rel="stylesheet" href="vendor/css/bootstrap.min.css">
    <link rel="stylesheet" href="fonts/fontawesome-free/css/all.css">
    <link rel="stylesheet" href="vendor/DataTables/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="vendor/DataTables/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="vendor/bootstrap-select/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
        include('includes/admin_header.php');
    ?>
    <section>
        <div class="container mt-5 pt-5">
            <h4 class="font-weight-bold mb-4 text-left">Edit Book</h4>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Book Title</label>
                    <input type="text" class="form-control" name="booktitle" value="<?php echo $data['book_title'] ?>"
                        required>
                </div>
                <div class="form-group">
                    <label for="author">Author</label>
                    <select class="form-control selectpicker border" name="author" data-live-search="true" required>
                        <?php
                            $authorquery = "SELECT * FROM authors";
                            $authorrun = mysqli_query($connect, $authorquery);
                            $countauthor = mysqli_num_rows($authorrun);
                            for ($i=0; $i < $countauthor; $i++) {
                                $authors = mysqli_fetch_array($authorrun);
                                if ($authors['author_id'] == $data['author_id']) {
                                    echo "<option selected value = '" . $authors['author_id'] . "'>";
                                } else {
                                    echo "<option value = " . $authors['author_id'] . ">";
                                }
                                    echo $authors['author_name'] . "</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" rows="3"
                        required><?php echo $data['description'] ?></textarea>
                </div>
                <div class="form-group">
                    <label for="edition">Edition</label>
                    <input type="number" class="form-control" name="edition" id="edition"
                        value="<?php echo $data['edition'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="language">Language</label>
                    <input type="text" class="form-control" name="language" id="language"
                        value="<?php echo $data['language'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="pages">Page Count</label>
                    <input type="number" class="form-control" name="pages" id="pages" aria-describedby="pages"
                        value="<?php echo $data['pages'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control" name="quantity" id="quantity"
                        value="<?php echo $data['quantity'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="publisher">Publisher</label>
                    <select class="form-control selectpicker border" name="publisher" data-live-search="true" required>
                        <?php
                            $publisherquery = "SELECT * FROM publishers";
                            $publisherrun = mysqli_query($connect, $publisherquery);
                            $countpublisher = mysqli_num_rows($publisherrun);
                            
                            for ($i=0; $i < $countpublisher; $i++) { 
                                $publishers = mysqli_fetch_array($publisherrun);
                                if ($publishers['publisher_id'] == $data['publisher_id']) {
                                    echo "<option selected value = '" . $publishers['publisher_id'] . "' >" ;
                                } else {
                                    echo "<option value = '" . $publishers['publisher_id'] . "' >" ;
                                }
                                echo $publishers['publisher_name'] . "</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="published">Publication Year</label>
                    <input type="text" class="form-control" name="published"
                        value="<?php echo $data['publication_year'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="isbnno">ISBN no.</label>
                    <input type="text" class="form-control" name="isbnno" value="<?php echo $data['isbn'] ?>" required>
                </div>
                <img src="<?php echo $data['cover'] ?>" alt="book-cover" width="300">
                <div class="form-group">
                    <label for="bookcover">Book Cover</label>
                    <input type="file" class="form-control-file" name="bookcover">
                </div>
                <div class="form-group">
                    <label for="e-file">E-file</label>
                    <input type="file" class="form-control-file" name="e-file">
                </div>
                <div class="form-group">
                    <label for="genre">Genre</label>
                    <select class="form-control selectpicker border" name="genre" data-live-search="true" required>
                        <?php
                            $genrequery = "SELECT * FROM genres";
                            $genrerun = mysqli_query($connect, $genrequery);
                            $countgenre = mysqli_num_rows($genrerun);
                            for ($i=0; $i < $countgenre; $i++) {
                                $genres = mysqli_fetch_array($genrerun);
                                if ($genres['genre_id'] == $data['genre_id']) {
                                    echo "<option value = '" . $genres['genre_id'] . "' selected >";
                                } else {
                                    echo "<option value = " . $genres['genre_id'] . ">";
                                }
                                    echo $genres['genre_title'] . "</option>";
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <button class="btn add-btn" type="submit" name="btnupdate">Submit</button>
                </div>
            </form>
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
<script src="vendor/bootstrap-select/js/bootstrap-select.min.js"></script>
<script>
$(function() {
    $('.selectpicker').selectpicker();
});
</script>

</html>