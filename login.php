<?php
    include 'db.inc.php';

    session_start();

    if(isset($_SESSION['user']['id'])){
        if($_SESSION['user']['state'] == "admin")
            header('location:admin.php');
        else
            header('location:index.php');
    }
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Se Connecter | Seabens Library</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/all.min.css">
        <link rel="stylesheet" href="https://unpkg.com/aos@3.0.0-beta.6/dist/aos.css">
        <script src="js/all.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/qjzruarw.js"></script>
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
                                <a class="nav-link p-lg-3 p-2" href="index.php">Home</a>
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
                    <div class="search  ps-lg-3 pe-lg-3 d-none d-lg-block">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </div>
            </div>
        </nav>
        
        <div class="login-body container mt-5">
            <?php
            if(isset($_GET['error'])){
                if(($_GET['error'] == "EmailIntrouvable") || ($_GET['error'] == "FalsePassword") || ($_GET['error'] == "EmtyInput")){ ?>
                    <div class="d-flex justify-content-center mb-2">
                        <div class="t-font alert alert-warning d-flex align-items-center" role="alert">
                            <i class="bi flex-shrink-0 me-2 fa-solid fa-triangle-exclamation" role="img" aria-label="Warning:"></i>
                            <div>
                                Connexion refusée. Identifiant inconnu ou mot de passe incorrect.
                            </div>
                        </div>
                    </div>
            <?php }}
            if(isset($_GET['success'])){ 
                if(($_GET['success'] == "CompteCree")){ ?>
                    <div class="d-flex justify-content-center mb-2">
                        <div class="t-font alert alert-success d-flex align-items-center" role="alert">
                            <i class="fa-solid fa-circle-check bi flex-shrink-0 me-2 " role="img" aria-label="Success:"></i>
                            <div>
                                Compte bien crée veuillez se connecter pour continuer
                            </div>
                        </div>
                    </div>
            <?php    }   }   ?>
            <div class="d-flex justify-content-center">
                <h5 class="t-font pb-1">Pour continuer, connectez-vous.</h5>
            </div>
            <hr class="ms-auto me-auto hr1">
            <form method="post" action="loged-in.php">
                <div class="d-flex justify-content-center">
                    <div class="www">
                        <div>
                            <label for="username"><h6 class="t-font pb-2">Email</h6></label>
                            <input 
                                    id="username"
                                    name="email"
                                    type="email" 
                                    placeholder="entrer votre email" 
                                    autocapitalize="none" 
                                    class="p-1 ps-3" 
                                    required 
                                    autocomplete="off">
                        </div>
                        <div>
                            <label for="password"><h6 class="t-font pt-3 pb-2">Mot de passe</h6></label>
                            <input 
                                    id="password" 
                                    type="password" 
                                    name="password"
                                    placeholder="Mot de passe" 
                                    class="p-1 ps-3"
                                    required 
                                    autocomplete="off">
                        </div>
                        <div class="d-flex pt-3 align-items-center">
                            <a 
                                href="#"
                                class="t-font" 
                                title="veuillez contact l'administration de la bibliotheque"
                                data-toggle="popover">
                                    Problème de connexion ?
                            </a>
                            <input type="submit" class="t-font sub ms-auto main-btn rounded-pill p-1" value="Se Connecter" name="connect">
                        </div>
                    </div>
                </div>
            </form>
            <hr class="ms-auto me-auto mt-4 hr1">
            <div class="d-flex justify-content-center">
                <div>
                    <h5 class="t-font">Vous n'avez pas de compte ?</h5>
                    <a class="btn rounded-pill pt-1 main-btn t-font w-100" href="inscrire.php">S'inscrire</a>
                </div>
            </div>
        </div>
    </body>
</html>