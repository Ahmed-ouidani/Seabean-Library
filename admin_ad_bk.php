<?php
    session_start();
    include 'db.inc.php';
    if($_SESSION['user']['state'] != "admin")
        header('location:index.php');
    
    if(isset($_POST['add_bk'])){
        include 'db.inc.php';
        include 'function.inc.php';
        $img = $_POST['img'];
        $book_name = $_POST['nom'];
        $auteur_name = $_POST['auteur'];
        $etat = $_POST['etat'];
        $note = $_POST['note'];
        $description = $_POST['description'];
        $format = $_POST['format'];
        $page = $_POST['page'];
        $categories = $_POST['categorie'];
        $date_ec = $_POST['date_ec'];

        $categorie = "";

        foreach ($categories as $cat) {
            $categorie .=$cat;
        }
    
        if(emptyInpute($img, $book_name, $auteur_name, $etat, $note, $description, $format, $page, $date_ec, $categorie))
            header("location: ./admin_ad_bk.php?error=emtyinput");
    
        if(bookexist($conn, $book_name, $auteur_name))
            header("location: ./admin_ad_bk.php?error=exist");
    
        creatbook($conn, $img, $book_name, $auteur_name, $etat, $note, $description, $format, $page,$date_ec, $categorie);
        
        header('location:./admin_ad_bk.php?success=LivreAjouter');
    }

    if(isset($_POST['cat_add'])){
        include 'db.inc.php';
        include 'function.inc.php';
        $svg = $_POST['cat_svg'];
        $categorie_name = filter_var($_POST['cat_name'],FILTER_SANITIZE_STRING);
    
        if(emptyInpute($svg, $categorie_name)){
            header("location: ./admin_ad_bk.php?error=emtyinput");
            exit();
        }
    
        creatcategorie($conn, $svg, $categorie_name);
        header('location:./admin_ad_bk.php?success=CategorieAjouter');
    }
?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ajouter un livre | Seabens Library</title>
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
                        if(($_GET['error'] == "exist")){ ?>
                            <div class="d-flex justify-content-center mb-2">
                                <div class="t-font alert alert-warning d-flex align-items-center" role="alert">
                                    <i class="bi flex-shrink-0 me-2 fa-solid fa-triangle-exclamation" role="img" aria-label="Warning:"></i>
                                    <div>
                                        Le livre existe dans la bibliotheque
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
                        if(($_GET['success'] == "LivreAjouter")){ ?>
                            <div class="d-flex justify-content-center mb-2">
                                <div class="t-font alert alert-success d-flex align-items-center" role="alert">
                                    <i class="fa-solid fa-circle-check bi flex-shrink-0 me-2 " role="img" aria-label="Success:"></i>
                                    <div>
                                        Le nouveau Livre est bien ajouter
                                    </div>
                                </div>
                            </div>
                        
                <?php    }   
                    if(($_GET['success'] == "CategorieAjouter")){ ?>
                        <div class="d-flex justify-content-center mb-2">
                            <div class="t-font alert alert-success d-flex align-items-center" role="alert">
                                <i class="fa-solid fa-circle-check bi flex-shrink-0 me-2 " role="img" aria-label="Success:"></i>
                                <div>
                                    La nouvelle Categorie est bien ajouter
                                </div>
                            </div>
                        </div>
                <?php }}   ?>
        </div>

        <div class=" container d-flex justify-content-center mt-1 mb-5">
            <div class="ad-add-land">
                <div class="d-flex justify-content-center">
                    <h2 class="mb-4 t-black t-font mt-4">
                        Ajouter un livre
                    </h2>
                </div>
                <div>
                    <form action="" method="post" class="p-3">
                        <div class="d-flex justify-content-center m-3">
                            <input 
                                type="text" 
                                autocomplete="off"
                                required
                                placeholder="Entrer le nom de livre" 
                                name="nom" 
                                class="in1 w-100 p-2 ps-3">
                        </div>
                        <div class="d-flex justify-content-center m-3">
                            <input 
                                type="text" 
                                autocomplete="off"
                                required
                                placeholder="Entrer le nom d'auteur" 
                                name="auteur" 
                                class="in1 w-100 p-2 ps-3">
                        </div>
                        <div class="d-flex justify-content-center m-3 align-items-center row">
                            <div class="col-3">
                                <input 
                                    type="radio" 
                                    id="dispo" 
                                    name="etat" 
                                    value="disponible" 
                                    class="me-1">
                                <label 
                                    for="dispo" 
                                    class="t-font">
                                        Disponible
                                </label>
                            </div>
                            <div class="col-4">
                                <input 
                                    type="radio" 
                                    name="etat" 
                                    id="Noinfo"
                                    value="NoInfo" 
                                    class="ms-1 me-1">
                                <label 
                                    for="Noinfo" 
                                    class="t-font">
                                        Pas d'information
                                </label>
                            </div>
                            <div class="col-3">
                                <input 
                                    type="radio" 
                                    name="etat" 
                                    id="Indespo" 
                                    value="Indesponible" 
                                    class="ms-2 me-1">
                                <label 
                                    for="Indespo" 
                                    class="t-font">
                                        Indisponible
                                </label>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center m-3">
                            <input 
                                type="text" 
                                name="note" 
                                autocomplete="off"
                                required
                                placeholder="Entrer la note" 
                                class="in1 w-100 ps-3 p-2">
                        </div>
                        <div class="d-flex justify-content-center m-3">
                            <input 
                                type="text" 
                                name="description" 
                                autocomplete="off" 
                                required
                                placeholder="Entrer la discription" 
                                class="in1 ps-3 w-100 p-2">
                        </div>
                        <div class="d-flex justify-content-center m-3">
                            <input 
                                type="text" 
                                name="format" 
                                autocomplete="off" 
                                required
                                placeholder="Entrer la format" 
                                class="in1 w-100 ps-3 p-2">
                        </div>
                        <div class="d-flex justify-content-center m-3">
                            <input 
                                type="number" 
                                name="page" 
                                autocomplete="off" 
                                required
                                placeholder="entrer le nombre des pages" 
                                class="in1 ps-3 w-100 p-2">
                        </div>
                        <div class="d-flex justify-content-center m-3">
                            <input 
                                type="text" 
                                name="date_ec" 
                                autocomplete="off" 
                                placeholder="Entrer la date d'ecriture" 
                                class="in1 w-100 ps-3 p-2"
                                required>
                        </div>
                        <div class="d-flex justify-content-center m-3">
                            <input 
                                type="file" 
                                name="img" 
                                id="img" 
                                required
                                class="w-100 p-2">
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
                                            <input type="checkbox" value="<?php echo $result['id']; ?>" id="<?php echo $result['cat_name']; ?>" name="categorie[]">
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
                                            <input 
                                                type="checkbox" 
                                                value="<?php echo $result['id']; ?>" 
                                                id="<?php echo $result['cat_name']; ?>" 
                                                name="categorie[]">
                                            <label 
                                                for="<?php echo $result['cat_name']; ?>"
                                                class="t-font">
                                                    <?php echo $result['cat_name']; ?>
                                            </label> <br>
                                    <?php } ?>
                                </div>
                                <?php
                                    $premier = (3 * $Colomn) - $Colomn + 2;

                                    $sql = "SELECT * FROM categories LIMIT :premier, :parColomn";
                                    $query = $conn->prepare($sql);

                                    $query->bindValue(':premier', $premier, PDO::PARAM_INT);
                                    $query->bindValue(':parColomn', $parColomn, PDO::PARAM_INT);
                                    $query->execute();

                                    ?>
                                <div class="col-3">
                                    <?php
                                        while($result = $query->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                            <input type="checkbox" value="<?php echo $result['id']; ?>" id="<?php echo $result['cat_name']; ?>" name="categorie[]">
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
                            <input 
                                type="submit" 
                                name="add_bk" 
                                class="t-font sub main-btn rounded-pill p-1" 
                                value="Ajouter">
                        </div>
                    </form>
                    <div class="add_cat">
                        <div
                            class="modal fade" 
                            id="add_cat" 
                            tabindex="-1" 
                            aria-labelledby="ModalLabel" 
                            aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="ModalLabel">Ajouter une categorie</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="" method="post">
                                                <div>
                                                    <label for="cate_ne" class="col-form-label">Nom de categorie : </label><br>
                                                    <input type="text" id="cate_ne" name="cat_name" class="w-100 p-2" required="">
                                                </div>
                                                <div>
                                                    <label for="cate_svg" class="col-form-label">Categorie SVG : </label><br>
                                                    <input type="text" id="cate_svg" name="cat_svg" class="w-100 p-2" required="">
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal"><span class="t-font">Fermer</span></button>
                                            <button type="submit" name="cat_add" class="p-2 ps-3 pe-3 t-font main-btn rounded-pill">Ajouter</button>  
                                        </div>
                                        </form>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>