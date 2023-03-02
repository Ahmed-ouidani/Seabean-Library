<?php
    session_start();
    include 'db.inc.php';
    if($_SESSION['user']['state'] != "admin")
        header('location:index.php');

    if(isset($_POST['admin-ad'])){
        include 'function.inc.php';
        $name = $_POST['name'];
        $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
        $passRepeat = $_POST['passwordRep'];
        $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
        $date = $_POST['jj']."/".$_POST['month']."/".$_POST['aa'];
        $sex = $_POST['sex'];
        $stt = "admin";

        if(pswMatch($password, $passRepeat) == false){
            header("location: ./admin_ad_admin.php?error=PasswordsDontMatch");
            exit();
        }

        if(emptyInpute($name, $email, $password, $date, $sex)){
            header("location: ./admin_ad_admin.php?error=emtyinput");
        exit();
        }

        if(uidexist($conn, $name, $email) != false){
            header("location: ./admin_ad_admin.php?error=usernameTake");
            exit();
        }

        creatUser($conn, $name, $email, $password, $date, $sex, $stt);

        header('location:admin_ad_admin.php?success=AdminBienCree');
    }

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Nouveaux Admin | Seabens Library</title>
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
                                <a class="nav-link p-lg-3 p-2" href="admin.php">Admin</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-lg-3 p-2" href="admin_books.php">Livres</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-lg-3 p-2" href="admin_reservations.php">Reservations</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-lg-3 p-2" href="news_admin_ad.php">Actualités</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-lg-3 p-2 active" href="admin_comptes.php">Comptes</a>
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
        <div class="login-body container pt-5 pb-5">
            <?php
                if(isset($_GET['error'])){
                    if(($_GET['error'] == "PasswordsDontMatch")){ ?>
                        <div class="d-flex justify-content-center mb-2">
                            <div class="t-font alert alert-warning d-flex align-items-center" role="alert">
                                <i class="bi flex-shrink-0 me-2 fa-solid fa-triangle-exclamation" role="img" aria-label="Warning:"></i>
                                <div>
                                    Veuillez entrer deux mot de pass identique
                                </div>
                            </div>
                        </div>
                <?php }
                    if(($_GET['error'] == "usernameTake")){ ?>
                        <div class="d-flex justify-content-center mb-2">
                            <div class="t-font alert alert-warning d-flex align-items-center" role="alert">
                                <i class="bi flex-shrink-0 me-2 fa-solid fa-triangle-exclamation" role="img" aria-label="Warning:"></i>
                                <div>
                                    Veuillez choisir un autre nom d'utilisateur ou un autre email
                                </div>
                            </div>
                        </div>
                <?php }
                    if(($_GET['error'] == "emtyinput")){ ?>
                        <div class="d-flex justify-content-center mb-2">
                            <div class="t-font alert alert-warning d-flex align-items-center" role="alert">
                                <i class="bi flex-shrink-0 me-2 fa-solid fa-triangle-exclamation" role="img" aria-label="Warning:"></i>
                                <div>
                                    Veuillez remplir tout les cases
                                </div>
                            </div>
                        </div>
                <?php }}
                if(isset($_GET['success'])){ 
                    if(($_GET['success'] == "AdminBienCree")){ ?>
                        <div class="d-flex justify-content-center mb-2">
                            <div class="t-font alert alert-success d-flex align-items-center" role="alert">
                                <i class="fa-solid fa-circle-check bi flex-shrink-0 me-2 " role="img" aria-label="Success:"></i>
                                <div>
                                    Le nouveau admin est bien ajouter
                                </div>
                            </div>
                        </div>
            <?php    }   }   ?>
            <div class="d-flex justify-content-center">
                <h5 class="t-font pb-1">Ajouter les information de nouveau Admine</h5>
            </div>
            <hr class="ms-auto me-auto hr1">
            <form method="post" action="admin_ad_admin.php">
            <div class="d-flex justify-content-center">
                <div class="www">
                    <div>
                        <label for="email"><h6 class="t-font pb-2">Quelle est son adresse e-mail ?</h6></label>
                        <input 
                                id="email" 
                                type="email" 
                                name="email"
                                placeholder="Saisissez l'email" 
                                autocapitalize="none"
                                class="p-1 ps-3"
                                autocomplete="off"
                                required>
                    </div>
                    <div>
                        <label for="password"><h6 class="t-font pt-3 pb-2">Créez un mot de passe</h6></label>
                        <input 
                                id="password" 
                                type="password"
                                name="password"
                                placeholder="Créez un mot de passe" 
                                class="p-1 ps-3"
                                autocomplete="off"
                                required>
                    </div>
                    <div>
                        <label for="passRep"><h6 class="t-font pt-3 pb-2">Confirmer la mot de pass</h6></label>
                        <input 
                                id="passRep" 
                                type="password"
                                name="passwordRep"
                                placeholder="Confirmer la mot de pass" 
                                class="p-1 ps-3"
                                autocomplete="off"
                                required>
                    </div>
                    <div>
                        <label for="username"><h6 class="t-font pt-3 pb-2">Comment doit-on lui appeler ?</h6></label>
                        <input 
                                id="username" 
                                type="text" 
                                name="name"
                                autocomplete="off"
                                placeholder="Saisissez le nom d'utilisateur" 
                                class="p-1 ps-3"
                                required>
                    </div>
                    <h6 class="t-font pt-3">Quelle est sa date de naissance ?</h6>
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
                    <h6 class="t-font pt-3 pb-2">Quel est son sexe ?</h6>
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
                        <input type="submit" class="t-font sub main-btn rounded-pill p-1" value="Ajouter" name="admin-ad" >
                    </div>
                </div>
            </div>
            </form>
            <hr class="ms-auto me-auto mt-4 hr1">
            <div class="d-flex justify-content-center align-items-center">
                <h6 class="t-font mb-0">Assurer que les information sont correcte.</h6>
            </div>
        </div>
    </body>
</html>