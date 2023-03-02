<?php
    session_start();
    include('db.inc.php');
    if($_SESSION['user']['state'] != "admin")
        header('location:index.php');
    
    if(!isset($_GET['book_id']))
        header('location:books.php');
    $id = $_GET['book_id'];

    if(isset($_POST['add_bk_pdf'])){
        include 'db.inc.php';
        include 'function.inc.php';
        $pdffile = $_POST['f_pdf'];
        $book_id = $_POST['book_id'];

        if(emptyInpute($pdffile, $book_id)){
            header("loaction admin_book.php?book_id=$id&error=EmptyInput");
        }
    
        createlab($conn, $pdffile, $book_id);

        header("location:./admin_book.php?book_id=$book_id&success=LivreAjouter");
    }

    if(isset($_POST['add_to_fav'])){
        include 'db.inc.php';
        include 'function.inc.php';
        $number = $_POST['fav_pc'];
        $book_id = $_POST['book_id'];

        if(emptyInpute($number, $book_id)){
            header("loaction admin_book.php?book_id=$id&error=EmptyInput");
        }
    
        $sql = "UPDATE recomendation SET book_id=? WHERE id=?";
        $conn->prepare($sql)->execute([$book_id, $number]);

        header("location:./admin_book.php?book_id=$book_id&success=LivreAjouterFav");
    }

    $sth = $conn->prepare("SELECT id, book_name, auteur, etat, note, discription, book_format, book_page, img, date_ecriture FROM books where id = '$id'");
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
                    if(($_GET['error'] == "EmptyInput")){ ?>
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
                <?php    }   
                    if(($_GET['success'] == "LivreModifier")){ ?>
                        <div class="d-flex justify-content-center mb-2">
                            <div class="t-font alert alert-success d-flex align-items-center" role="alert">
                                <i class="fa-solid fa-circle-check bi flex-shrink-0 me-2 " role="img" aria-label="Success:"></i>
                                <div>
                                    Le Livre est bien supprimer
                                </div>
                            </div>
                        </div>
                <?php }}   ?>
        </div>

        <div class="container book-it mt-1 mb-4">
            <div class="row pt-3 pb-3">
                <div class="col-md-2 ms-md-3 p-3 img-bk-it p-1 container justify-content-center">
                    <div class="book-img d-md-flex d-block justify-content-center ms-auto">
                        <img src="uploadedimgs/<?php echo $result['img'];?>" alt="" class="img-fluid">
                    </div>
                    <hr class="hr-bk-it">
                    <div class="book-titel">
                        <h5 class="d-flex">
                            <?php echo $result['book_name'];?>
                        </h5>
                        <p class="d-flex">
                            De : <?php echo $result['auteur'];?>.
                        </p>
                    </div>
                    <div class="book-stat <?php echo $result['etat'];?> d-flex  align-items-center">
                        <i class="fa-solid fa-circle"></i> <span class="ms-2"><?= ($result['etat'] == 'NoInfo') ? "Pas d'information" : $result['etat'];?></span>
                    </div>
                </div>
                <div class="col-md-9 pt-3 container">
                    <h2><?php echo $result['book_name'];?><span class="fs-5">(<?php echo $result['date_ecriture'];?>)</span></h2>
                    <p class="pt-2">
                        <span class="t-gold">
                        <?php
                            $n = "<i class='fa-solid fa-star'></i>";
                            for ($i=0; $i <= $result['note']-1; $i++) { 
                                echo $n;
                            }
                        ?>
                        </span>
                        <?php echo $result['note'];?>
                    </p>
                    <div>
                        <h5>Discription : </h5>
                        <p class="p-3">
                        &emsp; <?php echo $result['discription'];?>
                        </p>
                    </div>
                    <div>
                        <h5 class="pb-3">Details : </h5>
                        <span class="fw-semibold pb-2">L'objet physique</span><br>
                        <span class="text-black-50 pe-2 ps-1">Format</span><?php echo $result['book_format'];?><br>
                        <span class="text-black-50 pe-2 ps-1">Pagination</span><?php echo $result['book_page'];?> p<br>
                        <span class="text-black-50 pe-2 ps-1">Identifiant</span><?php echo $result['id'];?> <br>
                    </div>
                    <div class="d-flex">                        
                        <button 
                            type="button" 
                            class="btn main-btn mt-3 rounded-pill me-3">
                                <a class="rounded-pill main-btn p-2" href="admin_books.php?delete=<?php echo $result['id']; ?>" class="delete-btn">Supprimer</a>
                        </button>
                        
                        <div class="me-3">
                            <button 
                                type="button" 
                                class="btn main-btn mt-3 rounded-pill" 
                                data-bs-toggle="modal" 
                                data-bs-target="#favorits" 
                                data-bs-whatever="@getbootstrap">
                                    Recommendation
                            </button>
                            <div class="favorits">
                                <div
                                    class="modal fade" 
                                    id="favorits" 
                                    tabindex="-1" 
                                    aria-labelledby="ModalLabel" 
                                    aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="ModalLabel">Ajouter au recomendation</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="admin_book.php?book_id=1" method="post">
                                                        <div>
                                                            <label for="fav-num" class="col-form-label">Ajouter en : </label><br>
                                                            <select id="fav-num" class="w-100 p-2 mt-1" name="fav_pc" required="">
                                                                <option value="1">Premier</option>
                                                                <option value="2">Deuxiem</option>
                                                                <option value="3">Troisiem</option>
                                                                <option value="4">Quatriem</option>
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <input type="text" name="book_id" hidden value="<?php echo $id; ?>">
                                                        </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal"><span class="t-font">Fermer</span></button>
                                                    <button type="submit" name="add_to_fav" class="p-2 ps-3 pe-3 t-font main-btn rounded-pill">Ajouter</button>  
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>

                        <button 
                            type="button" 
                            class="btn main-btn mt-3 rounded-pill me-3">
                                <a class="rounded-pill main-btn p-2" href="admin_modif.php?book_id=<?php echo $result['id']; ?>" class="delete-btn">Modifier</a>
                        </button>

                        <button 
                            type="button" 
                            class="btn main-btn mt-3 rounded-pill" 
                            data-bs-toggle="modal" 
                            data-bs-target="#elab" 
                            data-bs-whatever="@getbootstrap">
                                Ajouter à elibrary
                        </button>
                        <div class="elab">
                            <div
                                class="modal fade" 
                                id="elab" 
                                tabindex="-1" 
                                aria-labelledby="ModalLabel" 
                                aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="ModalLabel">Ajouter au elibrary</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="admin_book.php?book_id=1" method="post">
                                                    <div class="mb-3">
                                                        <label for="add_pdf" class="col-form-label">Ajouter une version PDF</label>
                                                        <input type="file" class="form-control" name="f_pdf" id="add_pdf">
                                                    </div>
                                                    <div>
                                                        <input type="text" name="book_id" hidden value="<?php echo $id; ?>">
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal"><span class="t-font">Fermer</span></button>
                                                <button type="submit" name="add_bk_pdf" class="p-2 ps-3 pe-3 t-font main-btn rounded-pill">Ajouter</button>  
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            <div class="pt-5">
                <ul class="list-unstyled d-flex gap-3 text-light justify-content-center">
                    <li>
                        <a href="" class="">
                            <i class="fa-brands fa-facebook facebook p-2"></i>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="fa-brands fa-twitter twitter p-2"></i>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="fa-brands fa-instagram instagram p-2"></i>
                        </a>
                    </li>
                </ul>
                <div class="text-white-50 text-center copy pb-5">
                    <p class="mb-1">Copyrights &copy; - 2022 All Rights Reserved by</p>
                    <a href="" class="unstyled d-bock">chi smiya ta3 lgroup</a>
                </div>
            </div>
        </div>

    </body>
</html>