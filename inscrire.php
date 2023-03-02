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
        <title>S'inscrire | Seabens Library</title>
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
                        <a href="books.php"><i class="fa-solid fa-magnifying-glass"></i></a>
                    </div>
                </div>
            </div>
        </nav>
        
        <div class="login-body container pt-5 pb-5">
            <div class="d-flex justify-content-center">
                <h5 class="t-font pb-1">Inscrivez-vous gratuitement pour une une meilleure expérience.</h5>
            </div>
            <hr class="ms-auto me-auto hr1">
            <form method="post" action="signup.inc.php">
            <div class="d-flex justify-content-center">
                <div class="www">
                    <div>
                        <label for="email"><h6 class="t-font pb-2">Quelle est votre adresse e-mail ?</h6></label>
                        <input 
                                id="email" 
                                type="email" 
                                name="email"
                                placeholder="Saisissez votre email" 
                                autocapitalize="none"
                                class="p-1 ps-3" 
                                required 
                                autocomplete="off">
                    </div>
                    <div>
                        <label for="password"><h6 class="t-font pt-3 pb-2">Créez un mot de passe</h6></label>
                        <input 
                                id="password" 
                                type="password"
                                name="password"
                                placeholder="Créez un mot de passe" 
                                class="p-1 ps-3"
                                required 
                                autocomplete="off">
                    </div>
                    <div>
                        <label for="passRep"><h6 class="t-font pt-3 pb-2">Confirmer votre mot de passe</h6></label>
                        <input 
                                id="passRep" 
                                type="password"
                                name="passwordRep"
                                placeholder="Confirmer votre mot de pass" 
                                class="p-1 ps-3"
                                required 
                                autocomplete="off">
                    </div>
                    <div>
                        <label for="username"><h6 class="t-font pt-3 pb-2">Comment doit-on vous appeler ?</h6></label>
                        <input 
                                id="username" 
                                type="text" 
                                name="name"
                                autocomplete="off"
                                placeholder="Saisissez le nom d'utilisateur" 
                                class="p-1 ps-3"
                                required>
                    </div>
                    <h6 class="t-font pt-3">Quelle est votre date de naissance ?</h6>
                    <div class="d-flex align-items-center">
                        <div class="pe-1">
                            <label for="jour"><h6 class="t-font pt-3 pb-2">Jour</h6></label>
                            <input 
                                    id="jour" 
                                    type="text" 
                                    name="jj"
                                    placeholder="JJ" 
                                    autocomplete="off"
                                    class="p-1 ps-3"
                                    maxlength="2"
                                    required>
                        </div>
                        <div class="pe-1">
                            <label for="month"><h6 class="t-font pt-3 pb-2">Mois</h6></label>
                            <select name="month" id="month" class="ps-3" required="">
                                <option value="" disabled selected="">Mois</option>
                                <option value="1">janvier</option>
                                <option value="2">février</option>
                                <option value="3">mars</option>
                                <option value="4">avril</option>
                                <option value="5">mai</option>
                                <option value="6">juin</option>
                                <option value="7">juillet</option>
                                <option value="8">août</option>
                                <option value="9">septembre</option>
                                <option value="10">octobre</option>
                                <option value="11">novembre</option>
                                <option value="12">décembre</option>
                            </select>
                        </div>
                        <div>
                            <label for="annee"><h6 class="t-font pt-3 pb-2">Année</h6></label>
                            <input  
                                    id="annee" 
                                    type="text"
                                    name="aa"
                                    placeholder="AAAA"
                                    autocomplete="off"
                                    class="p-1 ps-3"
                                    maxlength="4"
                                    required>
                        </div>
                    </div>
                    <h6 class="t-font pt-3 pb-2">Quel est votre sexe ?</h6>
                    <div class="d-flex justify-content-start align-items-center">
                            <input 
                                    id="sexm"
                                    name="sex"
                                    type="radio" 
                                    value='M'
                                    required
                                    class="sex">
                            <label for="sexm"> Masculin</label>
                            <input 
                                    id="sexf"
                                    name="sex"
                                    type="radio"
                                    value='F'
                                    required
                                    class="sex ms-4">
                            <label for="sexf">Féminin</label>
                    </div>
                    <div class="d-flex pt-3 align-items-center justify-content-center">
                        <input type="submit" class="t-font sub main-btn rounded-pill p-1" value="s'inscrire" name="submit" >
                    </div>
                </div>
            </div>
            </form>
            <hr class="ms-auto me-auto mt-4 hr1">
            <div class="d-flex justify-content-center align-items-center">
                <h6 class="t-font mb-0">Vous avez déjà un compte ?</h6> <a href="login.php" class="ms-1 t-gold link-aaa">Connectez-vous.</h5></a>
            </div>
        </div>
    </body>
</html>