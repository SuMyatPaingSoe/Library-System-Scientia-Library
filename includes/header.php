<?php $activePage = basename($_SERVER['PHP_SELF'], ".php"); ?>
<header class="header">
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm bg-white">
        <a class="navbar-brand" href="index.php">
            <img src="images/Scientia.svg" height="50" width="150" alt="Scientia Library">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav w-100 ml-auto justify-content-end nav nav-tab">
                <li class="nav-item px-1">
                    <a class="nav-link font-weight-bold <?php echo (($activePage == 'index') || ($activePage == '')) ? 'active' : '' ?>"
                        aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item px-1">
                    <a class="nav-link font-weight-bold <?php echo ($activePage == 'getlibrarycard') ? 'active' : '' ?>"
                        aria-current="page" href="getlibrarycard.php">Get a
                        Library Card</a>
                </li>
                <li class="nav-item px-1">
                    <a class="nav-link font-weight-bold <?php echo ($activePage == 'catalog') ? 'active' : '' ?>"
                        aria-current="page" href="catalog.php">Catalog</a>
                </li>
                <li class="nav-item px-1">
                    <a class="nav-link font-weight-bold <?php echo ($activePage == 'aboutus') ? 'active' : '' ?>"
                        aria-current="page" href="aboutus.php">About
                        us</a>
                </li>
                <?php

                    if(isset($_SESSION['librarian_id']) || isset($_SESSION['member_id'])) {
                ?>
                <li class="dropdown profile-link nav-item px-1">
                    <a href="#" class="dropdown-toggle nav-link font-weight-bold" id="profileDropdown" role="button"
                        data-toggle="dropdown" aria-expanded="false">
                        Profile
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right p-2" aria-labelledby="profileDropdown">
                        <li class="container">
                            <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?> <br>
                            <small class="text-muted"><?php echo $_SESSION['email'] ?></small>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li><a href="<?php echo (isset($_SESSION['member_id']) ? 'profile.php' : 'admin.php'); ?>"
                                class="dropdown-item <?php echo (($activePage == 'profile') || ($activePage == 'admin')) ? 'active' : '' ?>">Dashboard</a>
                        </li>
                        <li><a href="logout.php" class="dropdown-item text-danger">Log Out</a> </li>
                    </ul>
                </li>
                <?php 
                    } else {
                        echo "<li class='nav-item px-1'>
                                <a class='nav-link font-weight-bold " . (($activePage == 'aboutus') ? 'active' : '') .  " ' aria-current='page' href='login.php'>Log In</a>
                            </li>";
                    }
                ?>

            </ul>
        </div>
    </nav>
</header>