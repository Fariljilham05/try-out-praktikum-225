<?php

$host = "localhost";          
$user = "root";                
$pass = "";                    
$db   = "auth_faril"; 

$con = mysqli_connect($host, $user, $pass, $db);

if (!$con) {

    die("Koneksi Gagal: " . mysqli_connect_error());
}


?>

