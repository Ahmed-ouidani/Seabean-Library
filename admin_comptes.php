<?php
    session_start();
    include('db.inc.php');
    if($_SESSION['user']['state'] != "admin")
        header('location:index.php');
    
    if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt= $conn->prepare($sql);
        $stmt->execute([$delete_id]);
        header('location:admin_comptes.php?success=UserSupprimer');
    }

    if(!empty($_GET['page'])){
        $currentPage = (int) strip_tags($_GET['page']);
    }else{
        $currentPage = 1;
    }

    $nRows = $conn->query('SELECT COUNT(*) FROM users')->fetchColumn();

    $parPage = 16;
    $pages = ceil($nRows / $parPage);
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Comptes | Seabens Library</title>
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
                                <a class="nav-link p-lg-3 p-2 active" href="#">Comptes</a>
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
                if(isset($_GET['success'])){ 
                    if(($_GET['success'] == "UserSupprimer")){ ?>
                        <div class="d-flex justify-content-center mb-2">
                            <div class="t-font alert alert-success d-flex align-items-center" role="alert">
                                <i class="fa-solid fa-circle-check bi flex-shrink-0 me-2 " role="img" aria-label="Success:"></i>
                                <div>
                                    L'utilisateur est bien supprimer
                                </div>
                            </div>
                        </div>
                <?php    }}   ?>
        </div>

        <div class="content container mt-5 mb-5 comptes">
            <h1 class="t-font t-black d-flex justify-content-center">Comptes</h1>
            <div class="row mt-4">
                <?php
                    $premier = ($currentPage * $parPage) - $parPage;

                    $sql = "SELECT id, name, email, state FROM users LIMIT :premier, :parpage";
                    $query = $conn->prepare($sql);
                    
                    $query->bindValue(':premier', $premier, PDO::PARAM_INT);
                    $query->bindValue(':parpage', $parPage, PDO::PARAM_INT);
                    $query->execute();

                    while($result = $query->fetch(PDO::FETCH_ASSOC)){
                ?>
                    <div class="col-lg-3-perso col-md-6-perso col-11 elements-ad p-4 mt-4 ms-1 me-1">
                        <div class="t-font t-black d-flex justify-content-center p-4 pb-0">
                            <div class="box">
                                <p> user id : <span><?php echo $result['id']; ?></span> </p>
                                <p> username : <span><?php echo $result['name']; ?></span> </p>
                                <p> email : <span><?php echo $result['email']; ?></span> </p>
                                <p> user type : <span><?php echo $result['state']; ?></span> </p>
                                <?php if($result['id'] != $_SESSION['user']['id']) {?>
                                    <a class="rounded-pill main-btn p-2" href="admin_comptes.php?delete=<?php echo $result['id']; ?>" onclick="return confisrm('delete this user?');" class="delete-btn">delete user</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php
                    };
                ?>
            </div>
        </div>

        <div class="pagination mb-2 d-flex justify-content-center t-font">
            <nav aria-label="Page navigation example">
                <?php
                    if($nRows == 0){
                        echo "vous n'avez aucun utilisateur";
                    }else { ?>
                <ul class="pagination">
                    <li class="page-item <?= ($currentPage == 1) ? "dis-aaaa" : "" ?>"><a class="page-link" href="admin_comptes.php?page=<?= $currentPage - 1 ?>">Previous</a></li>
                    <?php for($page = 1;$page <= $pages ; $page++){ ?>
                        <li class="page-item <?= ($currentPage == $page) ? "active-aaaa" : "" ?>"><a class="page-link" href="admin_comptes.php?page=<?php echo $page;?>"><?php echo $page;?></a></li>
                    <?php } ?>
                    <li class="page-item <?= ($currentPage == $pages) ? "dis-aaaa" : "" ?>"><a class="page-link" href="admin_comptes.php?page=<?= $currentPage + 1 ?>">Next</a></li>
                </ul>
                <?php } ?>
            </nav>
        </div>

        <div class="container">
            <div class="d-flex justify-content-center mb-5">
                <a href="admin_ad_admin.php" class="main-btn rounded-pill t-font p-2 ps-3 pe-3">Ajouter un admin</a>
            </div>
        </div>

    </body>
</html>