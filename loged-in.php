<?php
    session_start();
    if(isset($_SESSION['user']['id'])){
        if($_SESSION['user']['state'] == "admin")
            header('location:admin.php');
        else
            header('location:index.php');
    }

if(isset($_POST['connect'])){
    include 'db.inc.php';
    $password = $_POST['password'];
    $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);

    if(empty($email) || empty($password)){
        header('location: ./login.php?error=EmtyInput');
    }

    $sth = $conn->prepare("SELECT * FROM users WHERE email ='$email'");
    $sth->execute();
    $result = $sth->fetch();

    if(!$result){
        header('location: ./login.php?error=EmailIntrouvable');
    }else{
    
        $pass_hash = $result['pass'];
        
        if(!password_verify($password,$pass_hash)){
            header('location: ./login.php?error=FalsePassword');
        }else{
            $_SESSION['user']=[
                "name"=>$result['name'],
                "email"=>$email,
                "state"=>$result['state'],
                "id"=>$result['id']
                ];
            if($result['state'] == "user")
                header('location: index.php');
            else
                header('location:admin.php');
        }
    }   
}
?>
