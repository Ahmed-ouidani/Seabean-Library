<?php

$dbHost="localhost";
$dbUser="root";
$dbPass="";
$dbName="users_db";

try{
    $conn= new PDO("mysql:host=$dbHost;dbname=$dbName",$dbUser,$dbPass);
    $conn->exec('SET NAMES "UTF8"');
}catch(Exception $e){
    echo $e->getMessage();
    exit();
}