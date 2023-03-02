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
    
    $parPage = 10;

    if(!empty($_GET['search'])){
            $search = $_GET['search'];
            $nRows = $conn->query("SELECT COUNT(*) FROM books WHERE book_name LIKE '%$search%' OR auteur LIKE '%$search%'")->fetchColumn();
        
            $sql = "SELECT * FROM books WHERE auteur LIKE '%$search%' OR book_name LIKE '%$search%' LIMIT :premier, :parpage";

            $pages = ceil($nRows / $parPage);

            $premier = ($currentPage * $parPage) - $parPage;

            $query = $conn->prepare($sql);
            
            $query->bindValue(':premier', $premier, PDO::PARAM_INT);
            $query->bindValue(':parpage', $parPage, PDO::PARAM_INT);
            $query->execute();

            $book = $query->fetchAll();
    }else{
        if(!isset($_GET['genre'])){
            $nRows = $conn->query('SELECT COUNT(*) FROM books')->fetchColumn();

            $sql = "SELECT * FROM books ORDER BY id DESC LIMIT :premier, :parpage ";

            $pages = ceil($nRows / $parPage);

            $premier = ($currentPage * $parPage) - $parPage;

            $query = $conn->prepare($sql);
            
            $query->bindValue(':premier', $premier, PDO::PARAM_INT);
            $query->bindValue(':parpage', $parPage, PDO::PARAM_INT);
            $query->execute();

            $book = $query->fetchAll();
        }else{
            $searchgen = $_GET['genre'];
            $nRows = $conn->query("SELECT COUNT(*) FROM book_cat WHERE categorie_id = '$searchgen'")->fetchColumn();

            $stm = "SELECT * FROM book_cat WHERE categorie_id = '$searchgen' ORDER BY book_id DESC LIMIT :premier, :parpage";

            $pages = ceil($nRows / $parPage);
            $premier = ($currentPage * $parPage) - $parPage;

            $query = $conn->prepare($stm);
            $query->bindValue(':premier', $premier, PDO::PARAM_INT);
            $query->bindValue(':parpage', $parPage, PDO::PARAM_INT);
            $query->execute();
            $genres = $query->fetchAll();
        }
    }     
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Recherche | Seabens Library</title>
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
                                <a class="nav-link p-lg-3 p-2 active" aria-current="page" href="#">Reservation</a>
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
                    <div class="d-flex justify-content-right">
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
            </div>
        </nav>

        <div class="container pb-3">
            <form action="" method="get">
                <div class="row mt-5 align-items-center">
                    <div class="searchbar mb-lg-3 d-flex col-lg-8 container me-4">
                        <input type="text" class="w-100 p-3 ps-4 search-input-bar" name="search" placeholder="rechercher votre livre">
                        <button type="submit" class="p-3 search-input-btn main-btn t-font ps-4 pe-4"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                    <div class="filter dropdown mb-lg-3 ps-4 mb-3 col-lg-2 col-6 container ms-4">
                        <a 
                            class="rounded-pill t-font dropdown-toggle genra-drop p-3" 
                            href="#" 
                            role="button" 
                            data-bs-toggle="dropdown" 
                            aria-expanded="false">
                                Explorer par theme
                        </a>

                        <ul class="dropdown-menu">
                            <?php
                                $sql = "SELECT * FROM categories";
                                $query = $conn->prepare($sql);

                                $query->execute();
                                $categories = $query->fetchall();
                                foreach ($categories as $categorie) { ?>
                                    <li>
                                        <a class="dropdown-item" href="?genre=<?php echo $categorie['id'];?>"><?php echo $categorie['cat_name'];?></a>
                                    </li>
                            <?php    } ?>
                        </ul>
                    </div>
                </div>
            </form>
            <hr class="hr-books">
        </div>

        <div class="container mb-5">
            <div class="row mb-4">
                <?php
                    if(!isset($_GET['genre']))
                        foreach ($book as $result)
                            include 'books_script.php';
                    else{
                        foreach ($genres as $key) {
                            $id = $key['book_id'];
                            $sql = "SELECT * FROM books WHERE id = '$id'";
            
                            $query1 = $conn->prepare($sql);
                            $query1->execute();
                            $book = $query1->fetchAll();
                            foreach ($book as $result)
                                include 'books_script.php';
                        }
                    }
                ?>
                    
            </div>

            <div class="pagination mb-2 d-flex justify-content-center t-font">
                <nav aria-label="Page navigation example">
                <?php
                    if($nRows == 0){
                        if(empty($_GET['search']))
                            echo "Aucun livre est disponible pour le moment.";
                        else
                            echo "Aucun résultat trouvé.";
                    }else { ?>
                    <ul class="pagination">
                            <li class="page-item <?= ($currentPage == 1) ? "dis-aaaa" : "" ?>">
                                <a class="page-link" href="?&page=<?= $currentPage - 1 ?><?php if(!empty($search)){ ?>&search=<?php echo $search;?><?php }?><?php if(!empty($searchgen)){ ?>&genre=<?php echo $searchgen;?><?php } ?>">
                                    Previous
                                </a>
                            </li>
                        <?php for($page = 1;$page <= $pages ; $page++){ ?>
                            <li class="page-item <?= ($currentPage == $page) ? "active-aaaa" : "" ?>">
                                <a class="page-link" href="?page=<?php echo $page;?><?php if(!empty($search)){ ?>&search=<?php echo $search;?><?php } ?><?php if(!empty($searchgen)){ ?>&genre=<?php echo $searchgen;?><?php } ?>">
                                    <?php echo $page;?>
                                </a>
                            </li>
                        <?php } ?>
                            <li class="page-item <?= ($currentPage == $pages) ? "dis-aaaa" : "" ?>">
                                <a class="page-link" href="?page=<?= $currentPage + 1 ?><?php if(!empty($search)){ ?>&search=<?php echo $search;?><?php } ?><?php if(!empty($searchgen)){ ?>&genre=<?php echo $searchgen;?><?php } ?>">
                                    Next
                                </a>
                            </li>
                    </ul>
                    <?php } ?>
                </nav>
            </div>
        </div>

        <?php   include("footer.php") ?>
        
    </body>
</html>