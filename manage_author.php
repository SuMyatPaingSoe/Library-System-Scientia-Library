<?php
    session_start();
    include('config/connect.php');

    if (isset($_POST['btnAdd'])) {
        $author_name = $_POST['firstname'] . " " . $_POST['lastname'];

        $selectauthor = "SELECT * FROM authors
        WHERE author_name='$author_name'";
        $checkauthor = mysqli_query($connect,$selectauthor);
        $countauthor = mysqli_num_rows($checkauthor);

        if ($countauthor == 0) {
            $insert = "INSERT INTO `authors`(`author_name`) 
            VALUES ('$author_name')";
            $runinsert = mysqli_query($connect, $insert);
            if ($runinsert) {
                $showModal = true;
                $Message = 'Author Added Successfully!';
                $MessageTitle = 'Success';
                $alert = 'alert-success';
            } else {
                $showModal = true;
                $Message = 'Error: ' . mysqli_error($connect);
                $MessageTitle = 'Something Went Wrong!';
                $alert = 'alert-danger';
            }
        } else {
            $showModal = true;
            $Message = 'Author Already Exists!';
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
    <title>Scientia Library - Manage Author</title>
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
            <h4 class="font-weight-bold">Authors</h4>
            <table id="list_table" class="table w-100 table-sm table-white table-hover">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = "SELECT * FROM authors";
                        $result = mysqli_query($connect, $query);
                        $count = mysqli_num_rows($result);
                    
                        if($count < 1) {
                            echo "<p>No Data Found!</p>";
                        } else {
                            for ($i = 0; $i < $count; $i++) {
                                    $arr = mysqli_fetch_array($result);
                                    $names = explode(" ", $arr['author_name']);
                                    $author_id = $arr['author_id'];
                                    echo "<tr>";
                                    foreach ($names as $name) {
                                        echo "<td>" . $name . "</td>";
                                    }
                                    echo "<td>";
                                    ?>
                    <a class='btn btn-outline-success' href='edit_author.php?AuthorID=<?php echo $author_id ?>'>Edit</a>
                    <a class='btn btn-outline-danger' href='delete_author.php?AuthorID=<?php echo $author_id ?>'
                        onclick="return confirm('Do you want to delete?')">Delete</a>
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
    <section class="add-form">
        <div class="container mt-5">
            <h4 class="font-weight-bold">Add Author</h4>
            <hr>
            <form action="manage_author.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" class="form-control" name="firstname" id="firstname"
                        aria-describedby="firstname">
                </div>
                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" class="form-control" name="lastname" id="firstname" aria-describedby="lastname">
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
<script src="node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/DataTables/js/jquery.dataTables.min.js"></script>
<script src="vendor/DataTables/js/dataTables.bootstrap5.min.js"></script>
<script src="vendor/DataTables/js/dataTables.responsive.min.js"></script>
<script src="vendor/DataTables/js/responsive.bootstrap5.min.js"></script>
<script src="vendor/js/bootstrap.bundle.min.js"></script>
<script src="js/admin_nav.js"></script>
<script src="js/script.js" charset="utf-8"></script>
<?php
    if ($showModal) {
        echo '<script type="text/javascript">
			$(document).ready(function(){
				$("#MessageModal").modal("show");
			});
		</script>';
    }
?>

</html>