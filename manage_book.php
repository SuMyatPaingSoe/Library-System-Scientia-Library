<?php
    session_start();
    include('config/connect.php');

    if (isset($_POST['btnAdd'])) {
        $title = $_POST['booktitle'];
        $isbn = $_POST['isbnno'];
        $language = $_POST['language'];
        $author = $_POST['author'];
        $publisher = $_POST['publisher'];
        $genre = $_POST['genre'];
        $publishedyear = $_POST['published'];
        $description = addslashes($_POST['description']);
        $edition = $_POST['edition'];
        $quantity = $_POST['quantity'];
        $pages = $_POST['pages'];

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

        $selectbook = "SELECT * FROM books
                        WHERE book_title='$title'";
        $checkbook = mysqli_query($connect,$selectbook);
        $countbook = mysqli_num_rows($checkbook);

        if ($countbook == 0) {
            if($_FILES['e-file']['size'] != 0) {
                $file = $_FILES['e-file']['name'];
                $folder1 = "Book Files/";
                $FileName1=$folder1. '_' .$file;
                $copy = copy($_FILES['e-file']['tmp_name'], $FileName1);
    
                if (!$copy) 
                {
                    echo "<p>File Upload unsuccessful...</p>";
                    exit();
                }

                $insert = "INSERT INTO `books`(`book_title`, `isbn`, `pages`, `language`, `edition`, `author_id`, `publisher_id`, 
                `genre_id`, `publication_year`, `description`, `quantity`, `on_shelf`, `cover`, `e_file`) VALUES 
                ('$title','$isbn','$pages','$language','$edition','$author','$publisher','$genre',
                '$publishedyear','$description','$quantity', '$quantity', '$FileName', '$FileName1')";
                $runinsert = mysqli_query($connect, $insert);
                if ($runinsert) {
                    echo "<script>alert('Book Registration Successful!');
                            location.assign('manage_book.php');
                        </script>";
                } else {
                    echo mysqli_error($connect);
                }
            } else {
                $insert = "INSERT INTO `books`(`book_title`, `isbn`, `pages`, `language`, `edition`, `author_id`, `publisher_id`, 
                `genre_id`, `publication_year`, `description`, `quantity`, `cover`) VALUES 
                ('$title','$isbn','$pages','$language','$edition','$author','$publisher','$genre',
                '$publishedyear','$description','$quantity','$FileName')";
                $runinsert = mysqli_query($connect, $insert);
                if ($runinsert) {
                    $showModal = true;
                    $Message = 'Book Added Successfully!';
                    $MessageTitle = 'Success';
                    $alert = 'alert-success';
                } else {
                    $showModal = true;
                    $Message = 'Error: ' . mysqli_error($connect);
                    $MessageTitle = 'Something Went Wrong!';
                    $alert = 'alert-danger';
                }
            } 
        } else {
            $showModal = true;
            $Message = 'Book Already Exists!';
            $MessageTitle = 'Warning';
            $alert = 'alert-warning';
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
    <title>Scientia Library - Manage Book</title>
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
        include('includes/message_modal.php');
    ?>
    <section class="books mt-5">
        <div class="container pt-5">
            <h4 class="font-weight-bold">Books</h4>
            <table id="list_table" class="table w-100 table-sm table-white table-hover">
                <thead>
                    <tr>
                        <th class="w-25">Book Title</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Published</th>
                        <th>ISBN No.</th>
                        <th>Genre</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = "SELECT * FROM books b, genres g, authors a, publishers p WHERE
                                b.genre_id = g.genre_id AND b.author_id = a.author_id AND b.publisher_id = p.publisher_id";
                        $result = mysqli_query($connect, $query);
                        $count = mysqli_num_rows($result);
                    
                        if($count < 1) {
                            echo "<p>No Data Found!</p>";
                        } else {
                            for ($i = 0; $i < $count; $i++) {
                                    $arr = mysqli_fetch_array($result);
                                    $book_id = $arr['book_id'];

                                    echo "<tr>";
                                    echo "<td>" . $arr['book_title'] . "</td>";
                                    echo "<td>" . $arr['author_name'] . "</td>";
                                    echo "<td>" . $arr['publisher_name'] . "</td>";
                                    echo "<td>" . $arr['publication_year'] . "</td>";
                                    echo "<td>" . $arr['isbn'] . "</td>";
                                    echo "<td>" . $arr['genre_title'] . "</td>";
                                    echo "<td>";
                                    ?>
                    <a class='btn btn-outline-success' href='edit_book.php?BookID=<?php echo $book_id?>'>Edit</a>
                    <a class='btn btn-outline-danger' href='delete_book.php?BookID=<?php echo $book_id?>'
                        onclick=" return confirm('Do you want to delete?')">Delete</a>
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
            <h4 class="font-weight-bold">Register Book</h4>
            <hr>
            <form action="manage_book.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Book Title</label>
                    <input type="text" class="form-control" name="booktitle" required>
                </div>
                <div class="form-group">
                    <label for="author">Author</label>
                    <select class="form-control selectpicker border" name="author" data-live-search="true" required>
                        <?php
                            $authorquery = "SELECT * FROM authors";
                            $authorrun = mysqli_query($connect, $authorquery);

                            while($authors = mysqli_fetch_array($authorrun)) {
                                echo "<option value = " . $authors['author_id'] . ">" . $authors['author_name'] . "</option>";                                
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="edition">Edition</label>
                    <input type="text" class="form-control" name="edition" id="edition" required>
                </div>
                <div class="form-group">
                    <label for="language">Language</label>
                    <input type="text" class="form-control" name="language" id="edition" required>
                </div>
                <div class="form-group">
                    <label for="pages">Page Count</label>
                    <input type="number" class="form-control" name="pages" id="pages" aria-describedby="pages" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control" name="quantity" id="quantity" required>
                </div>
                <div class="form-group">
                    <label for="publisher">Publisher</label>
                    <select class="form-control selectpicker border" name="publisher" id="publisher"
                        data-live-search="true" required>
                        <?php
                            $publisherquery = "SELECT * FROM publishers";
                            $publisherrun = mysqli_query($connect, $publisherquery);

                            while($publishers = mysqli_fetch_array($publisherrun)) {
                                echo "<option value = " . $publishers['publisher_id'] . ">" . $publishers['publisher_name']  . "</option>";                                
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="published">Publication Year</label>
                    <input type="text" class="form-control" name="published" required>
                </div>
                <div class="form-group">
                    <label for="isbnno">ISBN no.</label>
                    <input type="text" class="form-control" name="isbnno" required>
                </div>
                <div class="form-group">
                    <label for="bookcover">Book Cover</label>
                    <input type="file" class="form-control-file" name="bookcover" required>
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

                            while($genres = mysqli_fetch_array($genrerun)) {
                                echo "<option value = " . $genres['genre_id'] . ">" . $genres['genre_title']  . "</option>";                                
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <input type="submit" value="Submit" name="btnAdd" class="btn add-btn">
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
<?php
    if (isset($showModal) && $showModal) {
        echo '<script type="text/javascript">
			$(document).ready(function(){
				$("#MessageModal").modal("show");
			});
		</script>';
    }
?>

</html>