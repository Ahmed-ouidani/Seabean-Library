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
        $categorie = $_POST['categorie'];
        $date_ec = $_POST['date_ec'];
    
        if(emptyInpute($img, $book_name, $auteur_name, $etat, $note, $description, $format, $page, $date_ec)){
            header("location: ./admin_ad_bk.php?error=emtyinput");
            exit();
            }
    
        if(bookexist($conn, $book_name, $auteur_name)){
            header("location: ./admin_ad_bk.php?error=nameTake");
            exit();
            }
    
        creatbook($conn, $img, $book_name, $auteur_name, $etat, $note, $description, $format, $page,$date_ec);
        
        addtocat($conn ,$book_name, $auteur_name, $_POST['categorie']);
        
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