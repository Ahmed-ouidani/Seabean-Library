<?php
    session_start();
    include('db.inc.php');
    if($_SESSION['user']['state'] != "admin")
        header('location:index.php');

    if(isset($_POST['ad_news'])){
        include 'function.inc.php';
        $title = filter_var($_POST['title'],FILTER_SANITIZE_STRING);;
        $news = filter_var($_POST['the-news'],FILTER_SANITIZE_STRING);
        $img = $_POST['image'];
        $date = $_POST['date'];

        if(emptyInpute($title, $news, $img)){
            header("location: ./admin_ad_admin.php?error=emtyinput");
        exit();
        }

        creatNews($conn, $title, $news, $img, $date);
        header("location:news_admin_ad.php");
    }
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ajouter un article | Seabens Library</title>
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
            body{
            background-color: var(--fourth-c);
            }
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
                                <a class="nav-link p-lg-3 p-2" href="admin.php">Admin</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-lg-3 p-2" href="admin_books.php">Livres</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-lg-3 p-2" href="admin_reservations.php">Reservations</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-lg-3 p-2 active" href="#">Actualités</a>
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

                        <div class="user-drmn dropstart">
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
            </div>
        </nav>
        <div class=" container d-flex justify-content-center mt-4 mb-5">
            <div class="ad-add-land">
                <div class="d-flex justify-content-center">
                    <h2 class="mb-4 t-black t-font mt-4">
                        Ajouter un article
                    </h2>
                </div>
                <div>
                    <form action="" method="post" class="p-3">
                        <div class="d-flex justify-content-center m-3">
                            <input type="date" value="<?php echo date('Y-m-d');?>" hidden name="date">
                        </div>
                        <div class="d-flex justify-content-center m-3">
                            <input 
                                type="text" 
                                placeholder="Entrer le titre" 
                                name="title" 
                                class="in1 w-100 p-2 ps-3"
                                required 
                                autocomplete="off">
                        </div>
                        <div class="d-flex justify-content-center m-3">
                            <textarea 
                                name="the-news" 
                                class="in1 w-100 p-2 ps-3" 
                                placeholder="Entrer l'article" 
                                cols="30" 
                                rows="5"
                                required 
                                autocomplete="off"></textarea>
                        </div>
                        <div class="d-flex justify-content-center m-3">
                            <input 
                                type="file" 
                                name="image" 
                                id="img" 
                                class="w-100 p-2"
                                required 
                                autocomplete="off">
                        </div>
                        <div class="m-3 d-flex justify-content-center">
                            <input type="submit" class="t-font sub main-btn rounded-pill p-1" value="Ajouter" name="ad_news">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>