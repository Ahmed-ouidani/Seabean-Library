<?php
    include 'db.inc.php';

function pswMatch($pass, $passRepeat){

    $result;
    if ($pass == $passRepeat){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function uidexist($conn, $name ,$email){

    $stm="SELECT name or email FROM users WHERE email ='$email' or name='$name'";
    $q=$conn->prepare($stm);
    $q->execute();
    $data=$q->fetch();
 
    if($data){
        $result = true;
    }else {
        $result = false;
    }
    return $result;
}

function creatUser($conn, $name, $email, $pass, $date, $sex, $stt){

    $password=password_hash($pass,PASSWORD_DEFAULT);
    $stm="INSERT INTO users (name,email,pass,date,sex,state) VALUES ('$name','$email','$password','$date','$sex','$stt')";
    $conn->prepare($stm)->execute();
}

function SendMessages($name, $email, $number, $message,$conn){
    
    $stm="INSERT INTO messages (name,email,number,message) VALUES ('$name','$email','$number','$message')";
    $conn->prepare($stm)->execute();

    header('location:contact.php');
}

function emptyInpute(...$input){
   
    $result;
    foreach ($input as $key) {
        if(empty($key))
            return true;
    }
        return false;
}

function bookexist($conn, $book_name, $auteur_name){
    
    $stm="SELECT book_name and auteur FROM books WHERE book_name ='$book_name' and auteur='$auteur_name'";
    $q=$conn->prepare($stm);
    $q->execute();
    $data=$q->fetch();
 
    if($data){
        $result = true;
    }else {
        $result = false;
    }
    return $result;
}

function creatbook($conn, $img, $book_name, $auteur_name, $etat, $note, $description, $format, $page, $date_ec, $categorie){
    
    $stm="INSERT INTO books (book_name,auteur,etat,note,discription,book_format,book_page,img,date_ecriture,categorie) VALUES ('$book_name','$auteur_name','$etat','$note','$description','$format','$page','$img','$date_ec','$categorie')";
    $conn->prepare($stm)->execute();
}

function creatreservation($conn, $date_pr, $date_rem, $user_email, $user_id, $user_name,$book_id){
    $stm="INSERT INTO reservation (date_prendre,date_remis,email,user_id,name,book_id) VALUES ('$date_pr','$date_rem','$user_email','$user_id','$user_name','$book_id')";
    $conn->prepare($stm)->execute();
}

function createlab($conn, $pdffile, $book_id){
    $stm="INSERT INTO elibrary (fpdf, book_id) VALUES ('$pdffile','$book_id')";
    $conn->prepare($stm)->execute();
}

function creatcategorie($conn, $svg, $categorie_name){
    $stm="INSERT INTO categories (cat_name, svg) VALUES ('$categorie_name', '$svg')";
    $conn->prepare($stm)->execute();
}

function addtocat($conn, $book_name, $auteur_name, $categorie){
    $sql = "SELECT id FROM books WHERE book_name= '$book_name' and auteur='$auteur_name'";
    $query = $conn->prepare($sql);
    $query->execute();

    $result = $query->fetch(PDO::FETCH_ASSOC);
    $book_id = $result['id'];

    foreach($categorie as $cat) {
        $stm="INSERT INTO book_cat (book_id,categorie_id) VALUES ('$book_id','$cat')";
        $conn->prepare($stm)->execute();
    }
}


function creatNews($conn, $title, $news, $img, $date){
    
    $stm="INSERT INTO news (title, img, the_new, la_date) VALUES ('$title','$img','$news','$date')";
    $conn->prepare($stm)->execute();
}