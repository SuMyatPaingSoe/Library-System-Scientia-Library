<?php
    session_start();
    include('config/connect.php');

    if (isset($_POST['btnAdd'])) {
        $genretitle = $_POST['genretitle'];

        $selectgenre = "SELECT * FROM genres
        WHERE genre_title='$genretitle'";
        $checkgenre = mysqli_query($connect,$selectgenre);
        $countgenre = mysqli_num_rows($checkgenre);

        if ($countgenre == 0) {
            $insert = "INSERT INTO `genres`(`genre_title`) 
            VALUES ('$genretitle')";
            $runinsert = mysqli_query($connect, $insert);
            if ($runinsert) {
                $showModal = true;
                $Message = 'Genre Added Successfully!';
                $MessageTitle = 'Success';
                $alert = 'alert-success';
            } else {
                echo mysqli_error($connect);
            }
        } else {
            $showModal = true;
            $Message = 'Genre Already Exists!';
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
    <title>Scientia Library - Manage Genre</title>
    <link rel="stylesheet" href="vendor/css/bootstrap.min.css">
    <link rel="stylesheet" href="fonts/fontawesome-free/css/all.css">
    <link rel="stylesheet" href="vendor/DataTables/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="vendor/DataTables/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
        include('includes/admin_header.php');
        include('includes/message_modal.php');
    ?>
    <section class="books mt-5">
        <div class="container pt-5">
            <h4 class="font-weight-bold">Genres</h4>
            <table id="list_table" class="table w-100 table-sm table-white table-hover">
                <thead>
                    <tr>
                        <th>Genre Name</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                     $query = "SELECT * FROM genres";
                     $result = mysqli_query($connect, $query);
                     $count = mysqli_num_rows($result);
                 
                     if($count < 1) {
                         echo "<p>No Data Found!</p>";
                     } else {
                        for ($i = 0; $i < $count; $i++) {
                                $arr = mysqli_fetch_array($result);
                                $genre_id = $arr['genre_id'];

                                echo "<td>" . $arr['genre_title'] . "</td>";
                                echo "<td>";
                                ?>
                    <a class='btn btn-outline-success' href='edit_genre.php?GenreID=<?php echo $genre_id ?>'>Edit</a>
                    <a class='btn btn-outline-danger' href='delete_genre.php?GenreID=<?php echo $genre_id ?>'>Delete</a>
                    <?php
                    echo "</td>";
                    echo "</tr>";
                    }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
    <section class=" add-form">
        <div class="container mt-5">
            <h4 class="font-weight-bold">Add Genre</h4>

            <hr>
            <form action="manage_genre.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="genretitle">Genre Title</label>
                    <input type="text" class="form-control" name="genretitle" id="genretitle"
                        aria-describedby="genretitle">
                </div>
                <div>
                    <input type="submit" value="Submit" name="btnAdd" class="btn add-btn">
                </div>
            </form>
        </div>

    </section>
    <?php
        include('includes/footer.php');
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