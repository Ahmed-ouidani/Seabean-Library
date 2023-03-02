<?php
    session_start();

    if(isset($_SESSION['user']))
        if($_SESSION['user']['state'] == "admin")
            header('location:admin.php');

    if(isset($_GET['submit'])){
        include 'db.inc.php';
        include 'function.inc.php';
            $name = filter_var($_GET['name'],FILTER_SANITIZE_STRING);
            $email = filter_var($_GET['email'],FILTER_SANITIZE_EMAIL);
            $number = filter_var($_GET['number'],FILTER_SANITIZE_STRING);
            $message = filter_var($_GET['message'],FILTER_SANITIZE_STRING);
    
            if(emptyInpute($name, $email, $number, $message) != false){
                header("location: ./contact.php?error=emtyinput");
            exit();
            }
    
            SendMessages($name, $email, $number, $message,$conn);
    }
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contact | Seabens Library</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/all.min.css">
        <link rel="stylesheet" href="https://unpkg.com/aos@3.0.0-beta.6/dist/aos.css">
        <script src="js/all.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <link rel="icon" href="images/icon.png">
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCA_142Z-Xh5DfBEu2SZuC_U75KwMH4NO4&callback=myMap"></script>
        <script>
            function myMap() {
            var mapProp= {
            center:new google.maps.LatLng(32.328135, -9.268263),
            zoom:5,
            };
            var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
            }
        </script>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Island+Moments&display=swap');
            @import url('https://fonts.googleapis.com/css2?family=Dosis&display=swap');
            body{    background-color: var(--fourth-c);  }
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
                                <a class="nav-link p-lg-3 p-2" aria-current="page" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-lg-3 p-2 " href="books.php">Reservation</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-lg-3 p-2" href="elibrary.php">Elibrary</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-lg-3 p-2" href="about.php">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-lg-3 p-2 active" aria-current="page" href="#">Contact</a>
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
                    <div class="search  ps-lg-3 pe-lg-3 d-none d-lg-block pt-2">
                        <a href="books.php"><i class="fa-solid fa-magnifying-glass"></i></a>
                    </div>
                    <?php
                            if(isset($_SESSION['user']['id'])){
                        ?>
                                <div class="d-flex justify-content-right">
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
                        <?php }else {?>
                            <a class="btn rounded-pill pb-2 main-btn" href="login.php"><span class="t-font f-s-s">Se Connecter</span></a>
                        <?php } ?>
                </div>
            </div>
        </nav>

        <div class="container text-center pt-5 mb-5">
            <div class="nos-conts text-center">
                <h3 class="t-font t-black mb-3">Contacter Nous</h3>
                <div class="underlines">
                    <hr class="h1 ms-auto me-auto mb-1">
                    <hr class="h2 ms-auto me-auto">
                </div>
                <div class="pt-3 fs-2">
                    <p class="t-font-2">
                        N'hésitez pas à nous contacter si vous avez des questions
                    </p>
                    <p class="fs-2 t-font mb-5">
                        Contactez notre equipe par téléphone ou par e-mail
                    </p>
                </div>
                <div class="container contats">
                    <ul class="list-unstyled d-flex container ms-auto me-auto align-items-center justify-centent-center">
                        <li class="col-lg-4 row align-items-center ms-2">
                            <i class="fa-solid fa-house col-1"></i> <h6 class="col-10 pe-0 mb-0">Sidi Bouzid, B.P.4162, 46000 Safi-Maroc</h6>
                        </li>
                        <li class="col-lg-4 row align-items-center ms-2">
                            <i class="fa-solid fa-phone col-1"></i> <div class="col-10"><h6 class="pe-0">+212 524-669357</h6><h6 class="pe-0 mb-0"> +212 524-669516</h6></div>
                        </li>
                        <li class="col-lg-4 row align-items-center ms-2">
                            <i class="fa-solid fa-at col-1"></i> <a class="ps-1 t-black col-10" href="mailto:seabens-lib@gmail.com">seabens-lib@gmail.com</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="complaine mt-5">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="comp col-lg-6">
                            <form action="" method="get">
                                <input type="text" required autocomplete="off" name="name" class="mt-5 p-2" placeholder="Nom"> <br>
                                <input type="text" name="number" required autocomplete="off" class="p-2 mt-3" placeholder="Phone"> <br>
                                <input type="email" name="email" required autocomplete="off" class="p-2 mt-3" placeholder="Email"> <br>
                                <textarea name="message" required autocomplete="off" class="p-2 mt-3" placeholder="Votre message" cols="30" rows="5"></textarea>
                                <input type="submit" name="submit" class=" mt-3 mb-5 sub ms-auto main-btn p-1">
                            </form>
                        </div>
                        <div class="map col-lg-6">
                            <div id="googleMap" style="width:100%;height:400px;"></div>
                            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCA_142Z-Xh5DfBEu2SZuC_U75KwMH4NO4&callback=myMap"></script>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php   include("footer.php") ?>
    </body>
</html>