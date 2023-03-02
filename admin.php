<?php
    session_start();
    include('db.inc.php');
    if($_SESSION['user']['state'] != "admin")
        header('location:index.php');
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admine | Seabens Library</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/all.min.css">
        <link rel="stylesheet" href="https://unpkg.com/aos@3.0.0-beta.6/dist/aos.css">
        <script src="js/all.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <link rel="icon" href="images/icon.png">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Island+Moments&display=swap');
            @import url('https://fonts.googleapis.com/css2?family=Dosis&display=swap');
            body{   background-color: var(--fourth-c);  }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg pt-0 pb-0 sticky-top">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="images/icon.png" alt="" class="img-fluid brand-icon">
                    <span>Seabens Library</span>
                </a>
                <div class="collapse navbar-collapse" id="navbarScroll">
                        <ul class="navbar-nav ms-auto my-2 my-lg-0">
                            <li class="nav-item">
                                <a class="nav-link p-lg-3 p-2 active" href="#">Admin</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-lg-3 p-2 " href="admin_books.php">Livres</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-lg-3 p-2" href="admin_reservations.php">Reservations</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-lg-3 p-2" href="news_admin_ad.php">Actualités</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-lg-3 p-2" href="admin_comptes.php">Comptes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-lg-3 p-2" href="admin_messages.php">Messages</a>
                            </li>
                        </ul>
                </div>
                <div class="d-flex justify-content-right">
                    <button 
                        class="navbar-toggler me-4" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#navbarScroll" 
                        aria-controls="navbarScroll" 
                        aria-expanded="false" 
                        aria-label="Toggle navigation">
                        <i class="fa-solid fa-bars"></i>
                    </button>

                    <div class="ps-2 user-drmn dropstart">
                        <button type="button" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user"></i>
                        </button>
                        <ul class="dropdown-menu user-dr p-3">
                            <li class="d-flex justify-content-center">username : <span><?php echo $_SESSION['user']['name']; ?></span></li>
                            <li class="d-flex justify-content-center"><p>email : <span><?php echo $_SESSION['user']['email']; ?></span></li>
                            <li class="d-flex justify-content-center p-2 main-btn rounded-pill aa ms-auto me-auto"><a href="logout.php" class="t-black">logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <div class="content container mt-5 mb-5">
            <h2 class="t-font t-black d-flex justify-content-center">Vue General</h2>
            <div class="row mb-1 mt-4">
                <div class="col-lg-3-perso col-md-6-perso col-11 elements-ad p-4 mt-4 ms-1 me-1 nbr-comptes">
                    <div class="t-font t-black d-flex justify-content-center p-4">
                        <?php
                            $nRows = $conn->query('select count(*) from users')->fetchColumn(); 
                        ?>
                        <h1 class="ad-el-count">
                            <?php echo $nRows;?>
                        </h1>
                    </div>
                    <div class="t-font t-black d-flex justify-content-center ad-el-count-name pt-1">
                        <a href="admin_comptes.php" class="unstyled"><h4>Nombre de comptes</h4></a>
                    </div>
                </div>
                <div class="col-lg-3-perso col-md-6-perso col-11 elements-ad p-4 mt-4 ms-1 me-1 nbr-livres">
                    <div class="t-font t-black d-flex justify-content-center p-4">
                        <?php
                            $nRows = $conn->query('select count(*) from books')->fetchColumn(); 
                        ?>
                        <h1 class="ad-el-count">
                            <?php echo $nRows;?>
                        </h1>
                    </div>
                    <div class="t-font t-black d-flex justify-content-center ad-el-count-name pt-2">
                        <a href="admin_books.php" class="unstyled"><h4>Nombre de livres</h4></a>
                    </div>
                </div>
                <div class="col-lg-3-perso col-md-6-perso col-11 elements-ad p-4 mt-4 ms-1 me-1 nbr-msgs">
                    <div class="t-font t-black d-flex justify-content-center p-4">
                        <?php
                            $nRows = $conn->query('select count(*) from messages')->fetchColumn(); 
                        ?>
                        <h1 class="ad-el-count">
                            <?php echo $nRows;?>
                        </h1>
                    </div>
                    <div class="t-font t-black d-flex justify-content-center ad-el-count-name pt-2">
                        <a href="admin_messages.php" class="unstyled"><h4>Messages recue</h4></a>
                    </div>
                </div>
                <div class="col-lg-3-perso col-md-6-perso col-11 elements-ad p-4 mt-4 ms-1 me-1 nbr-reser">
                    <div class="t-font t-black d-flex justify-content-center p-4">
                        <?php
                            $nRows = $conn->query('select count(*) from reservation')->fetchColumn(); 
                        ?>
                        <h1 class="ad-el-count">
                            <?php echo $nRows;?>
                        </h1>
                    </div>
                    <div class="t-font t-black d-flex justify-content-center ad-el-count-name pt-2">
                        <a href="admin_reservations.php" class="unstyled"><h4>Reservations</h4></a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>