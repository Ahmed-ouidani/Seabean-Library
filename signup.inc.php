<?php

session_start();
if(isset($_SESSION['user']['id'])){
   if($_SESSION['user']['state'] == "admin")
       header('location:admin.php');
   else
       header('location:index.php');
}

if(isset($_POST['submit'])){
   include 'db.inc.php';
   include 'function.inc.php';
      $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);;
      $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
      $passRepeat = filter_var($_POST['passwordRep'],FILTER_SANITIZE_STRING);
      $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
      $date = $_POST['jj']."/".$_POST['month']."/".$_POST['aa'];
      $sex = $_POST['sex'];
      $stt = "user";

      if(pswMatch($password, $passRepeat) == false){
         header("location: ./inscrire.php?error=passwordsDontMatch");
         exit();
      }

      if(emptyInpute($name, $email, $password, $date, $sex) != false){
         header("location: ./inscrire.php?error=emtyinput");
      exit();
      }

     if(uidexist($conn, $name, $email) != false){
         header("location: ./inscrire.php?error=usernameTake");
         exit();
      }

      creatUser($conn, $name, $email, $password, $date, $sex, $stt);

      header('location:login.php?success=CompteCree');
}else{
   header("location: ./inscrire.php");
    exit();
}

?>
