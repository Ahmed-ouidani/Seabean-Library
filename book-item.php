<?php
    include 'db.inc.php';

    session_start();

    if(!isset($_SESSION['user']['id'])){
        header('location:login.php');
    }

    if(!isset($_GET['book_id']))
        header('location:books.php');
    $id = $_GET['book_id'];
    
    if(isset($_POST['reserver'])){
        include 'db.inc.php';
        include 'function.inc.php';
        $date_pr = $_POST['dpr'];
        $date_rem = $_POST['dre'];
        $user_name = $_SESSION['user']['name'];
        $user_email = $_SESSION['user']['email'];
        $user_id = $_SESSION['user']['id'];
        $book_id = $_POST['bc_id'];

        if(emptyInpute($date_pr, $date_rem)){
            header("loaction book-item.php?book_id=$id&error=EmptyInput");
        }
    
        creatreservation($conn, $date_pr, $date_rem, $user_email, $user_id, $user_name,$book_id);
        header("location:./book-item.php?book_id=$book_id");
    }

    $sth = $conn->prepare("SELECT * FROM books where id = '$id'");
    $sth->execute();
    $result = $sth->fetch();
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $result['book_name'];?> | Seabens Library</title>
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
                        class="navbar-toggler me-3 p-2" 
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
                    </div>
                </div>
            </div>
        </nav>

        <div class="container book-it mt-4 mb-4">
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
                    <div class="reserv">
                        <button 
                            type="button" 
                            class="btn main-btn mt-3 rounded-pill" 
                            data-bs-toggle="modal" 
                            data-bs-target="#reserver" 
                            data-bs-whatever="@getbootstrap">
                                Reserver ce livre
                        </button>

                        <div
                            class="modal fade" 
                            id="reserver" 
                            tabindex="-1" 
                            aria-labelledby="ModalLabel" 
                            aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="ModalLabel">Reserver votre livre</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="book-item.php?book_id=1" method="post">
                                                <div class="mb-3">
                                                    <label 
                                                        for="date_de_pris" 
                                                        class="col-form-label">
                                                            Date de prendre
                                                    </label>
                                                    <input 
                                                        type="date" 
                                                        value="<?php echo date("Y-m-d");?>" 
                                                        class="form-control" 
                                                        name="dpr" 
                                                        id="date_de_pris"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label 
                                                        for="date_de_remis" 
                                                        class="col-form-label">
                                                            Date de remis
                                                    </label>
                                                    <input 
                                                        type="date" 
                                                        required
                                                        class="form-control" 
                                                        id="date_de_remis" 
                                                        name="dre">
                                                </div>
                                                <div>
                                                    <input type="hidden" value="<?php echo $_GET['book_id'];?>" name="bc_id">
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal"><span class="t-font">Fermer</span></button>
                                            <button type="submit" name="reserver" class="p-2 ps-3 pe-3 t-font main-btn rounded-pill">Reserver</button>  
                                        </div>
                                        </form>
                                    </div>
                                </div>
                        </div>
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
                </div>
            </div>
        </div>

        <?php   include("footer.php") ?>
    </body>
</html>