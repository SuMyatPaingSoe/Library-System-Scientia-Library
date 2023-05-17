<?php
    if (!isset($_SESSION['librarian_id'])) {
        echo "<script>alert('Please Log in!')</script>";
        echo "<script>window.location='login.php'</script>";
    }
?>
<header>
    <nav class="navbar navbar-expand navbar-light bg-white d-flex flex-column align-item-start fixed-top admin-nav h-100"
        id="sidebar">
        <a href="" class="navbar-brand mt-2">
            <img src="images/Scientia-portrait.svg" alt="Logo" width="120">
        </a>
        <ul class="nav navbar-nav d-flex flex-column w-100 overflow-auto" id="nav_accordion">
            <li class="nav-item">
                <a class="nav-link text-gray" href="index.php"><i class="fa-solid fa-home"></i>
                    Home</a>
            </li>
            <li class="nav-item has-submenu">
                <a class="nav-link text-gray" href="admin.php"><i class="fa-solid fa-chart-line"></i>
                    Dashboard <i class="fa-solid fa-caret-down"></i>
                </a>
                <ul class="submenu collapse w-100">
                    <li class="dropdown-item p-0">
                        <a class="nav-link text-gray" href="manage_book.php"><i class="fa-solid fa-book"></i>
                            Books</a>
                    </li>
                    <li class="dropdown-item p-0">
                        <a class="nav-link text-gray" href="manage_author.php"><i class="fa-solid fa-user-pen"></i>
                            Authors</a>
                    </li>
                    <li class="dropdown-item p-0">
                        <a class="nav-link text-gray" href="manage_member.php"><i class="fa-solid fa-users"></i>
                            Members</a>
                    </li>
                    <li class="dropdown-item p-0">
                        <a class="nav-link text-gray" href="manage_genre.php"><i class="fa-solid fa-border-all"></i>
                            Genres</a>
                    </li>
                    <li class="dropdown-item p-0">
                        <a class="nav-link text-gray" href="manage_publisher.php"><i class="fa-solid fa-building"></i>
                            Publishers</a>
                    </li>
                    <!-- <li class="dropdown-item p-0">
                        <a class="nav-link text-dark" href="manage_language.php"><i class="fa-solid fa-book"></i>
                            Languages</a>
                    </li> -->
                    <li class="dropdown-item p-0">
                        <a class="nav-link text-gray" href="manage_librarian.php"><i class="fa-solid fa-users"></i>
                            Librarians</a>
                    </li>
                    <li class="dropdown-item p-0">
                        <a class="nav-link text-gray" href="manage_supplier.php"><i class="fa-solid fa-building"></i>
                            Suppliers</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link text-gray" href="check_in.php"><i class="fa-solid fa-file-import"></i> Check
                    In</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-gray" href="check_out.php"><i class="fa-solid fa-file-export"></i> Check
                    Out</a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link text-dark" href="#"><i class="fa-solid fa-calendar-days"></i> News & Events</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="#"><i class="fa-solid fa-magnifying-glass"></i>
                    OPAC
                    Search</a>
            </li> -->
        </ul>
    </nav>
    <nav class="navbar normal-nav py-2 bg-white navbar-light fixed-top shadow-sm bg-body">
        <div class="my-container">
            <button class="btn bg-body m-2 menu-btn" id="menu-btn">
                <i class="fas fa-xl fa-bars"></i>
            </button>
        </div>
        <div class="dropdown profile-link">
            <a href="#" class="dropdown-toggle nav-link text-dark" id="profileDropdown" role="button"
                data-toggle="dropdown" aria-expanded="false">
                Profile
            </a>
            <ul class="dropdown-menu dropdown-menu-right p-2" aria-labelledby="profileDropdown">
                <li class="container">
                    <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?> <br>
                    <small class="text-muted"><?php echo $_SESSION['email'] ?></small>
                </li>
                <li class="dropdown-divider"></li>
                <li><a href="admin.php" class="dropdown-item">Dashboard</a></li>
                <li><a href="logout.php" class="dropdown-item text-danger">Log Out</a> </li>
            </ul>
        </div>
    </nav>
</header>