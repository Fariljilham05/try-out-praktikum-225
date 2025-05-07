<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "project";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn){
    die("Error " . mysqli_connect_error());
}

?>