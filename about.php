<?php
    session_start();

    if(isset($_SESSION['user']))
        if($_SESSION['user']['state'] == "admin")
            header('location:admin.php');
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sur nous | Seabens Library</title>
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
                                <a class="nav-link p-lg-3 p-2 active" aria-current="page" href="#">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-lg-3 p-2" href="contact.php">Contact</a>
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

        <div class="container justify-content-center">
            <div class="mb-5 container">
                <h3 class="text-center t-font t-black mt-4 mb-3">Sur nous</h3>
                <div class="underlines mb-4">
                    <hr class="h1 ms-auto me-auto">
                    <hr class="h2 ms-auto me-auto mb-2">                   
                </div>
            </div>
            <div class="row mt-5 mb-1 about-lan align-items-center">
                <div class="col-lg-6">
                    <p class="t-font text-center">
                        La salle de lecture de Seabens est une excellente occasion d'obtenir une variété d'informations pour aider le 
                        processus éducatif et satisfaire divers intérêts. La salle de lecture dispose d'un fonds universel de documents, 
                        plus de 12 000 publications, capable de satisfaire presque toutes les demandes des lecteurs. La littérature sur 
                        les sciences naturelles, la technologie, les sciences sociales et humanitaires, ainsi que la fiction, y compris 
                        les œuvres de classiques de la littérature mondiale et russe, sont largement représentées ici. 
                    </p>
                </div>
                <div class="col-lg-6">
                    <div class="">
                        <img src="images/img-about-1.jpg" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
            <div class="row mt-4 mb-5 about-lan align-items-center">
                <div class="col-lg-6">
                    <div class="">
                        <img src="images/img-about-4.jpg" class="img-fluid" alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <p class="t-font text-center">
                        La salle de lecture offre aux visiteurs les publications encyclopédiques, de référence et scientifiquesles plus 
                        précieuses et les plus pertinentes, des manuels, ainsi que plus de 20 titres de magazines. Plus de 2 000 
                        personnes deviennent ses utilisateurs chaque année. Jusqu'à 70 lecteurs peuvent travailler en même temps dans 
                        la salle de lecture. La littérature la meilleure et la plus intéressante est présentée lors d'expositions de 
                        livres et d'illustrations consacrées à des dates mémorables, des questions d'actualité, des thèmes et des 
                        événements.
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-4 mb-4">
            <img src="images/img-about-2.png" class="img-fluid w-100" alt="">
        </div>

        <div class="container justify-content-center">
            <div class="row mt-4 mb-4 about-lan align-items-center justify-content-center">
                <div class="col-lg-8">
                    <div class="underlines mt-4 mb-4">
                        <hr class="h2 ms-auto me-auto mb-2">                        
                        <hr class="h1 ms-auto me-auto">
                    </div>
                    <p class="t-font text-center">
                        La salle de lecture permet non seulement de se 
                        familiariser avec l'actualité littéraire et de préparer des cours, des mémoires ou des rapports scientifiques, 
                        mais aussi d'assister à des soirées littéraires et musicales, des premières de livres et des rencontres créatives
                        avec des écrivains. Les employés compétents de la salle de lecture aideront toujours à la sélection des 
                        publications, conseilleront la littérature nécessaire.
                    </p>
                    <div class="underlines mb-4">
                        <hr class="h1 ms-auto me-auto">
                        <hr class="h2 ms-auto me-auto mb-2">                   
                    </div>
                </div>
            </div>
        </div>  

        <?php   include("footer.php") ?>
    </body>
</html>