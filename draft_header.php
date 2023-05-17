<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="images/Consulting.png" type="image/x-icon">
    <title>Scientia Library - Login</title>
    <link rel="stylesheet" href="vendor/css/bootstrap.min.css">
    <link rel="stylesheet" href="fonts/fontawesome-free/css/all.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand navbar-light bg-body shadow d-flex flex-column align-item-start fixed-top admin-nav h-100"
            id="sidebar">
            <!-- <a href="" class="navbar-brand mt-2 ms-4">
                <img src="images/Scientia-portrait.svg" alt="Logo" width="120">
            </a> -->
            <ul class="navbar-nav d-flex flex-column mt-4 w-100">
                <li class="nav-item">
                    <a class="nav-link text-dark" aria-current="page" href="#"><i class="fa-solid fa-home"></i>
                        Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="admin.html"><i class="fa-solid fa-chart-line"></i>
                        Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#"><i class="fa-solid fa-calendar-days"></i> News & Events</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa-solid fa-landmark"></i> Library
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li class="dropdown-header">Manage Books</li>
                        <li><a class="dropdown-item" href="book_listing.html"><i class="fa-solid fa-book"></i> Book
                                Listing</a></li>
                        <li><a class="dropdown-item" href="add_book.html"><i class="fa-solid fa-folder-plus"></i> Add
                                Book</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="dropdown-header">Manage Authors</li>
                        <li><a class="dropdown-item" href="author_listing.html"><i class="fa-solid fa-user-pen"></i>
                                Author
                                Listing</a></li>
                        <li><a class="dropdown-item" href="add_author.html"><i class="fa-solid fa-user-plus"></i> Add
                                Author</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="dropdown-header">Manage Users</li>
                        <li><a class="dropdown-item" href="user_listing.html"><i class="fa-solid fa-users"></i> User
                                Listing</a></li>
                        <li><a class="dropdown-item" href="register_user.html"><i class="fa-solid fa-address-book"></i>
                                User
                                Registration</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="dropdown-header">Manage Transactions</li>
                        <li><a class="dropdown-item" href="check_in.html"><i class="fa-solid fa-file-import"></i>
                                Check-in</a>
                        </li>
                        <li><a class="dropdown-item" href="check_out.html"><i class="fa-solid fa-file-export"></i>
                                Check-out</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#"><i class="fa-solid fa-magnifying-glass"></i>
                        OPAC
                        Search</a>
                </li>
            </ul>
        </nav>
        <nav class="navbar normal-nav py-2 bg-white navbar-light fixed-top shadow-sm bg-body">
            <a href="" class="navbar-brand ms-auto normal-nav-logo">
                <img src="images/Scientia.svg" alt="Logo" width="160">
            </a>
        </nav>
    </header>
    <section class="admin my-container">
        <button class="btn bg-body m-2 menu-btn" id="menu-btn">
            <i class="fas fa-xl fa-bars"></i>
        </button>
        <section class="search mt-4">
            <div class="advanced-search">
                <a href="">Advanced Search</a>
            </div>
            <div class="d-flex justify-content-center w-100">
                <form class="input-group search-group w-50 shadow rounded" method="post">
                    <input type="search" name="keyword" class="form-control" placeholder="Search a book or audio"
                        aria-label="Search" aria-describedby="search-addon" />
                    <button type="button" class="btn btn-md search-btn rounded-end border border-1"><i
                            class="fa-solid fa-md fa-magnifying-glass"></i> &nbsp;&nbsp;search</button>
                </form>
            </div>
        </section>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 py-3">
                    <div class="card w-100 text-dark">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-3x fa-book"></i>
                            <p class="card-text fs-5 mt-3">Book Total: <span class="count">2399</span></p>
                            <a href="" class="btn btn-dark">Manage</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 py-3">
                    <div class="card w-100 text-danger">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-3x fa-users"></i>
                            <p class="card-text fs-5 mt-3">Library Members: <span class="count">310</span></p>
                            <a href="" class="btn btn-danger">Manage</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 py-3">
                    <div class="card w-100 text-warning">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-3x fa-arrows-rotate"></i>
                            <p class="card-text fs-5 mt-3">Books Issued: <span class="count">30</span></p>
                            <a href="" class="btn btn-warning">Manage</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 py-3">
                    <div class="card w-100 text-primary">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-3x fa-check"></i>
                            <p class="card-text fs-5 mt-3">Books Returned: <span class="count">15</span></p>
                            <a href="" class="btn btn-primary">Manage</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<script src="node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
<script src="vendor/js/bootstrap.min.js" charset="utf-8"></script>
<script>
var menu_btn = document.querySelector('#menu-btn');
var sidebar = document.querySelector('#sidebar');
var container = document.querySelector(".my-container");

menu_btn.addEventListener("click", () => {
    sidebar.classList.toggle("active-nav")
    container.classList.toggle("active-cont")
})
</script>
<script src="js/script.js"></script>

</html>