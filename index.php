<?php
    include 'db.inc.php';

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
        <title>Accueil | Seabens Library</title>
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
                            <a class="nav-link p-lg-3 p-2 active " aria-current="page" href="#">Home</a>
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
                        <?php
                            if(isset($_SESSION['user'])){
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
            </div>
        </nav>

        <div class="container-fluid p-0">
            <div id="carousel_Fade" class="carousel slide carousel-fade landing" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item ind-land active">
                        <img src="images/img-main-1.jpg" class="d-block w-100 img-fluid">
                        <div class="carousel-caption d-none d-md-block landing-cap">
                            <q class="fw-bold">Une heure <span class="citee">de lecture</span> est le souverain remède contre les dégoûts de la vie.</q><br>
                            <span class="name">Montesquieu</span>
                        </div>        
                    </div>
                    <div class="carousel-item ind-land">
                        <img src="images/img-main-2.jpg" class="d-block w-100 img-fluid">
                        <div class="carousel-caption d-none d-md-block landing-cap">
                            <q class="fw-bold"><span class="citee">Lire et écrire</span> sont deux points de résistance à l’absolutisme du monde.</q><br>
                            <span class="name">Christian Bobin</span>
                        </div>      
                    </div>  
                    <div class="carousel-item ind-land">
                        <img src="images/img-main-3.jpg" class="d-block w-100 img-fluid">
                        <div class="carousel-caption d-none d-md-block landing-cap">
                            <q class="fw-bold"><span class="citee">Lire</span> est le seul moyen de vivre plusieurs fois</q><br>
                            <span class="name">Pierre Dumayet</span>
                        </div>        
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel_Fade" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel_Fade" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        
        <div class="trend container-fluid pe-5 ps-5 pt-0 pb-5 d-flex justify-content-center">
            <div>
                <div class="section-head">
                    <h3 class="pt-3 ps-4 ">Acdualités</h3>
                    <hr class="mt-1 mb-0">
                </div>

                <div class="container">
                    <div class="row">

                        <div class="col-lg-7 row justify-content-center">

                            <div class="container ms-4 p-3 mt-4">

                                <div id="carouselExampleCaptions" class="carousel slide container" data-bs-ride="false">
                                    <div class="carousel-indicators">
                                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                    </div>

                                    <div class="carousel-inner">
                                        <?php
                                            $sql = "SELECT * FROM news ORDER BY id DESC LIMIT 3 ";
                                            $query = $conn->prepare($sql);

                                            $query->execute();
                                            while($new = $query->fetch(PDO::FETCH_ASSOC)){
                                        ?>

                                        <div class="carousel-item active">
                                            <img src="images/<?php echo $new['img'];?>" class="d-block w-100 n22" class="img-fluid">
                                            <div class="carousel-caption n21 d-none d-md-block w-100 ps-5 pe-5">
                                                <p class="t-font ps-5 pe-5"><?php echo $new['title'];?></p>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                                
                            </div>
                            
                            <div class="section-head">
                                <h3 class="pt-3 ps-4 ">Nos recommendation</h3>
                                <hr class="mt-1 mb-0">
                            </div>

                            <div>
                                <?php
                                    $sql = "SELECT book_id, id FROM recomendation";
                                    $query = $conn->prepare($sql);

                                    $query->execute();
                                    while($result = $query->fetch(PDO::FETCH_ASSOC)){
                                        $result['book_id'];
                                    
                                        $book_id = $result['book_id'];
                                        $sql = "SELECT img, book_name,auteur, id, etat, note, discription FROM books WHERE id='$book_id'";
                                        $query1 = $conn->prepare($sql);
                                        $query1->execute();
                                        $book = $query1->fetch();
                                ?>
                                    <div class="container">
                                        <div class="m-3 reco-items book-infos d-flex p-2 row d-flex align-items-center text-light col-md-5 col-lg-12">
                                            <div class="col-lg-3 d-flex mb-2 justify-content-center">
                                                <img src="uploadedimgs/<?php echo $book['img'];?>" alt="" class="img-fluid">
                                            </div>
                                            <div class="col-lg-4">
                                                <h5><?php echo $book['book_name'];?></h5>
                                                <p> De : <?php echo $book['auteur'];?>.</p>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="note">
                                                    <i class="fa-solid fa-star"></i> <?php echo $book['note'];?>/5
                                                </div>
                                                <div class="dispo <?php echo $book['etat'];?>">
                                                    <span>Etat</span>
                                                    <i class="fa-solid fa-circle"></i> <?php echo $book['etat'];?>
                                                </div>
                                                <div class="discre">
                                                    <p>
                                                        &emsp; <?php echo $book["discription"];?>
                                                    </p>
                                                </div>
                                                <div class="d-flex justify-content-end se-mr pe-4 mb-2">
                                                    <a class="btn rounded-pill p-1 see-mr-btn" href="book-item.php?book_id=<?php echo $book['id'];?>"><span>Voir Plus</span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>                            
                        </div>

                        <div class="col-lg-4 ms-lg-5 ms-0 more-bk m-3 container">
                            <div class="explore">
                                <h5 class="t-black p-2 t-font pt-4">Explorer par theme</h5>
                                <ul>
                                    
                                <?php
                                    $sql = "SELECT cat_name,id,svg FROM categories";
                                    $query = $conn->prepare($sql);
                                    $query->execute();
                                    $count = 1;
                                ?>
                                <?php
                                    while($result = $query->fetch(PDO::FETCH_ASSOC)){
                                        $id = $result['id'];
                                ?>   
                                    <li class="<?= (($count++ % 2) == 1) ? "f1" : "f2" ?>">
                                        <a href="books.php?genre=<?php echo $id;?>"><?php echo $result['svg']; ?><h6><?php echo $result['cat_name']; ?></h6></a>
                                    </li>
                                <?php }  ?>
                                </ul>
                            </div>
                            <hr class="hr0 mt-5">
                            <div id="contact">
                                <h5 class="t-black p-2 t-font mt-4">Contacter Nous</h5>
                                <ul class="list-unstyled ps-3 pt-4">
                                    <li class="f1">
                                        <i class="fa-solid fa-house"></i> <h6> Sidi Bouzid, B.P. 4162, 46000 Safi - Maroc </h6>
                                    </li>
                                    <li class="f2">
                                        <i class="fa-solid fa-phone"></i> <h6> Tél : (+212) 5 24 66 93 57  </h6>
                                    </li>
                                    <li class="f1">
                                        <i class="fa-solid fa-phone"></i> <h6> Fax : (+212) 5 24 66 95 16 </h6>
                                    </li>
                                    <li class="f2">
                                        <i class="fa-solid fa-at"></i> <a class="ps-1 text-light" href="mailto:seabens-lib@gmail.com">seabens-lib@gmail.com</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php   include("footer.php") ?>
    </body>
</html>
