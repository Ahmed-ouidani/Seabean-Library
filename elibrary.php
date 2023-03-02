<?php
    include 'db.inc.php';

    session_start();

    if(isset($_SESSION['user']))
        if($_SESSION['user']['state'] == "admin")
            header('location:admin.php');
    
    if(!empty($_GET['page'])){
        $currentPage = (int) strip_tags($_GET['page']);
    }else{
        $currentPage = 1;
    }

    $nRows = $conn->query('SELECT COUNT(*) FROM elibrary')->fetchColumn();

    $parPage = 9;
    $pages = ceil($nRows / $parPage);
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Elibrary | Seabens Library</title>
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
                            <a class="nav-link p-lg-3 p-2" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                                <a class="nav-link p-lg-3 p-2 " href="books.php">Reservation</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link p-lg-3 p-2 active" href="#">Elibrary</a>
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
        </nav>

        <div class="elib_landing container-fluid pt-5 d-flex justify-content-center">
            <div>
                <div class="d-flex justify-content-center">
                    <h1 class="text-light t-font-2">Votre guide pour lire le bonheur.</h1>
                </div>
                <div class="container d-flex justify-content-center">
                    <p class="container text-light t-font d-flex justify-content-center align-items-center">
                        Présenté par votre bibliothèque locale et construit avec <i class="ms-1 text-danger me-1 fa-solid fa-heart"></i> par Seabens.
                    </p>
                </div>
                <div class="container d-flex justify-content-center">
                    <p class="container text-light t-font d-flex justify-content-center">   
                        Chaleureux, personnel et facile à utiliser, Eseabens est idéal pour les utilisateurs de tous âges.
                    </p>
                </div>
                
            </div>
            
        </div>

        <div class="elab_lan_titre mb-5 container">
            <h3 class="text-center t-font t-black mt-4 mb-3">Nos eBooks</h3>
            <div class="underlines">
                <hr class="h1 ms-auto me-auto mb-1">
                <hr class="h2 ms-auto me-auto">
            </div>
        </div>

        <div class="container">
            <div class="row mb-4 justify-content-start">
                <?php
                    $premier = ($currentPage * $parPage) - $parPage;

                    $sql = "SELECT id, book_id, fpdf FROM elibrary LIMIT :premier, :parpage";
                    $query = $conn->prepare($sql);
                    
                    $query->bindValue(':premier', $premier, PDO::PARAM_INT);
                    $query->bindValue(':parpage', $parPage, PDO::PARAM_INT);
                    $query->execute();
                    while($result = $query->fetch(PDO::FETCH_ASSOC)){
                        $id = $result["book_id"];
                        $sql = "SELECT img, book_name,auteur, id FROM books WHERE id='$id'";
                        $query1 = $conn->prepare($sql);
                        $query1->execute();
                        $result1 = $query1->fetch(PDO::FETCH_ASSOC)
                ?>
                    <div class="col-lg-4 container">
                        <div class="m-3 reco-items book-ad p-2 text-light">
                            <div class="d-flex mb-2 justify-content-center">
                                <img src="uploadedimgs/<?php echo $result1['img'];?>" alt="" class="img-fluid">
                            </div>
                            <h5 class="text-center"><?php echo $result1['book_name'];?></h5>
                            <p class="text-center"> De : <?php echo $result1['auteur'];?>.</p>
                            <div class="d-flex justify-content-center se-mr mb-2">
                                <a class="btn rounded-pill p-1 see-mr-btn me-3" href="book-item.php?book_id=<?php echo $result1['id'];?>"><span>Voir Plus</span></a>
                                <a class="btn rounded-pill p-1 see-mr-btn" href="elibrary/<?php echo $result['fpdf'];?>"><span>Lire</span></a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                </div>  
                <div class="pagination mb-2 d-flex justify-content-center">
                    <nav aria-label="Page navigation example">
                        <?php
                        if($nRows == 0){
                            echo "eBook diponible pour le moment";
                        }else { ?>
                        <ul class="pagination">
                            <li class="page-item <?= ($currentPage == 1) ? "dis-aaaa" : "" ?>"><a class="page-link" href="<?= $currentPage - 1 ?>">Previous</a></li>
                            <?php for($page = 1;$page <= $pages ; $page++){ ?>
                                <li class="page-item <?= ($currentPage == $pages) ? "active-aaaa" : "" ?>"><a class="page-link" href="elibrary.php?page=<?php echo $page;?>"><?php echo $page;?></a></li>
                            <?php } ?>
                            <li class="page-item <?= ($currentPage == $pages) ? "dis-aaaa" : "" ?>"><a class="page-link" href="<?= $currentPage + 1 ?>">Next</a></li>
                        </ul>
                        <?php } ?>
                    </nav>
                </div>
            </div>
        </div>

        <div class="container mt-4 mb-5">
            <div class="underlines mb-4">
                <hr class="h2 ms-auto me-auto mb-2">
                <hr class="h1 ms-auto me-auto">
            </div>
            <p class="container t-font text-center col-10">
                La collection Seabens eBook Library propose des millions d'œuvres des plus grands penseurs des 1 000 dernières années, 
                des œuvres d'Amérique, d'Asie, d'Afrique et d'Europe, dans plus de 300 langues différentes. Notre collection d'articles 
                savants et universitaires a été organisée dans tous les domaines d'études, avec un accent particulier sur l'éducation, 
                la science, la sociologie et la technologie
            </p>
            <div class="underlines">
                <hr class="h1 ms-auto me-auto mb-2">
                <hr class="h2 ms-auto me-auto">
            </div>
        </div>

        <?php   include("footer.php") ?>
    </body>
</html>