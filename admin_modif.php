<?php
    session_start();
    include 'db.inc.php';
    if($_SESSION['user']['state'] != "admin")
        header('location:index.php');
    
    if(!isset($_GET['book_id']))
        header('location:admin_books.php');
    $id = $_GET['book_id']; 
    
    if(isset($_POST['modif_bk'])){
        include 'db.inc.php';
        include 'function.inc.php';

        $etat = $_POST['etat'];
        $note = $_POST['note'];
        $description = filter_var($_POST['description'],FILTER_SANITIZE_STRING);

        if(emptyInpute($etat,$note,$description)){
            header("location: admin_modif.php?book_id=$id&error=emptyinput");
        }
    
        $sql = "UPDATE books SET etat=?, note=?, discription=? WHERE id=?";
        $conn->prepare($sql)->execute([$etat, $note, $description, $id]);
        header("location: admin_book.php?id=$id&success=LivreModifier");
    }

    $sth = $conn->prepare("SELECT id, book_name, auteur, etat, note, discription, book_format, book_page,img, date_ecriture FROM books where id = '$id'");
    $sth->execute();
    $result = $sth->fetch();
?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $result['book_name']; ?> | Seabens Library</title>
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
                                <a class="nav-link p-lg-3 p-2 active" href="admin_books.php">Livres</a>
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

        <div class="container d-flex justify-content-center mt-4">
            <?php
                if(isset($_GET['error'])){
                    if(($_GET['error'] == "emptyinput")){ ?>
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
                    if(($_GET['success'] == "LivreAjouter")){ ?>
                        <div class="d-flex justify-content-center mb-2">
                            <div class="t-font alert alert-success d-flex align-items-center" role="alert">
                                <i class="fa-solid fa-circle-check bi flex-shrink-0 me-2 " role="img" aria-label="Success:"></i>
                                <div>
                                    Le Livre est bien ajouter au eLibrary
                                </div>
                            </div>
                        </div>
                        
                <?php    }   
                    if(($_GET['success'] == "LivreAjouterFav")){ ?>
                        <div class="d-flex justify-content-center mb-2">
                            <div class="t-font alert alert-success d-flex align-items-center" role="alert">
                                <i class="fa-solid fa-circle-check bi flex-shrink-0 me-2 " role="img" aria-label="Success:"></i>
                                <div>
                                    Le Livre est bien ajouter au reccomendation
                                </div>
                            </div>
                        </div>
                <?php }}   ?>
        </div>

        <div class=" container d-flex justify-content-center mt-4 mb-5">
            <div class="ad-add-land">
                <div class="d-flex justify-content-center">
                    <h2 class="mb-4 t-black t-font mt-4">
                        Modifier
                    </h2>
                </div>
                <div>
                    <form action="" method="post" class="p-3">
                        <div class="d-flex justify-content-center m-3">
                            <input type="text" disabled value="<?php echo $result['book_name'];?>" class="in1 w-100 p-2 ps-3">
                        </div>
                        <div class="d-flex justify-content-center m-3">
                            <input type="text" disabled value="<?php echo $result['auteur'];?>" class="in1 w-100 p-2 ps-3">
                        </div>
                        <div class="d-flex justify-content-center m-3 align-items-center row">
                            <div class="col-3">
                                <input type="radio" id="dispo" name="etat" value="disponible" class="me-1">
                                <label for="dispo" class="t-font">Disponible</label>
                            </div>
                            <div class="col-4">
                                <input type="radio" name="etat" id="Noinfo" value="NoInfo" class="ms-1 me-1">
                                <label for="Noinfo" class="t-font">Pas d'information</label>
                            </div>
                            <div class="col-3">
                                <input type="radio" name="etat" id="Indesponible" value="Indesponible" class="ms-2 me-1">
                                <label for="Indespo" class="t-font">Indisponible</label>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center m-3">
                            <input type="text" name="note" autocomplete="off" placeholder="Entrer la note" class="in1 w-100 ps-3 p-2">
                        </div>
                        <div class="d-flex justify-content-center m-3">
                            <input type="text" name="description" autocomplete="off" placeholder="Entrer la discription" class="in1 ps-3 w-100 p-2">
                        </div>
                        <div class="d-flex justify-content-center m-3">
                            <input type="text" disabled value="<?php echo $result['book_format'];?>" class="in1 w-100 ps-3 p-2">
                        </div>
                        <div class="d-flex justify-content-center m-3">
                            <input type="number" disabled value="<?php echo $result['book_page'];?>" class="in1 ps-3 w-100 p-2">
                        </div>
                        <div class="d-flex justify-content-center m-3">
                            <input type="text" disabled value="<?php echo $result['date_ecriture'];?>" class="in1 w-100 ps-3 p-2">
                        </div>
                        <div class="d-flex justify-content-center m-3">
                            <input type="file" disabled id="img" class="w-100 p-2">
                        </div>
                        <div class="row d-flex justify-content-center">

                            <?php
                                $nRows = $conn->query('SELECT COUNT(*) FROM categories')->fetchColumn();

                                $Colomn = 3;
                                $parColomn = ceil($nRows / $Colomn);
                                $premier = (1 * $Colomn) - $Colomn;

                                $sql = "SELECT cat_name,id FROM categories LIMIT :premier, :parColomn";
                                $query = $conn->prepare($sql);

                                $query->bindValue(':premier', $premier, PDO::PARAM_INT);
                                $query->bindValue(':parColomn', $parColomn, PDO::PARAM_INT);
                                $query->execute();

                                ?>
                                <div class="col-3">
                                    <?php
                                        while($result = $query->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                            <input type="checkbox" value="<?php echo $result['id']; ?>" id="<?php echo $result['cat_name']; ?>" name="categorie">
                                            <label for="<?php echo $result['cat_name']; ?>" class="t-font"><?php echo $result['cat_name']; ?></label> <br>
                                    <?php } ?>
                                </div>
                                <?php
                                    $premier = (2 * $Colomn) - $Colomn + 1;

                                    $sql = "SELECT cat_name,id FROM categories LIMIT :premier, :parColomn";
                                    $query = $conn->prepare($sql);

                                    $query->bindValue(':premier', $premier, PDO::PARAM_INT);
                                    $query->bindValue(':parColomn', $parColomn, PDO::PARAM_INT);
                                    $query->execute();

                                    ?>
                                <div class="col-3">
                                    <?php
                                        while($result = $query->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                            <input type="checkbox" value="<?php echo $result['id']; ?>" id="<?php echo $result['cat_name']; ?>" name="categorie">
                                            <label for="<?php echo $result['cat_name']; ?>" class="t-font"><?php echo $result['cat_name']; ?></label> <br>
                                    <?php } ?>
                                </div>
                                <?php
                                    $premier = (3 * $Colomn) - $Colomn + 2;

                                    $sql = "SELECT cat_name,id FROM categories LIMIT :premier, :parColomn";
                                    $query = $conn->prepare($sql);

                                    $query->bindValue(':premier', $premier, PDO::PARAM_INT);
                                    $query->bindValue(':parColomn', $parColomn, PDO::PARAM_INT);
                                    $query->execute();

                                    ?>
                                <div class="col-3">
                                    <?php
                                        while($result = $query->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                            <input type="checkbox" value="<?php echo $result['id']; ?>" id="<?php echo $result['cat_name']; ?>" name="categorie">
                                            <label for="<?php echo $result['cat_name']; ?>" class="t-font"><?php echo $result['cat_name']; ?></label> <br>
                                    <?php } ?>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button 
                                        type="button" 
                                        class="btn main-btn mt-3 rounded-pill t-font" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#add_cat" 
                                        data-bs-whatever="@getbootstrap">
                                            <span class="t-font">Ajouter une categorie</span> 
                                    </button>
                                </div>
                        </div>
                        <div class="m-3 d-flex justify-content-center">
                            <input type="submit" name="modif_bk" class="t-font sub main-btn rounded-pill p-1" value="Modifier">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </body>
</html>