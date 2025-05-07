<?php
session_start();
//Masukkan file koneksi
require "config/koneksi.php";

if ($_SERVER['REQUEST_METHOD']=== "POST") {
    //Ambil nilai email password
    $email= htmlspecialchars($_POST['email']);
    $password= htmlspecialchars ($_POST['password']);

    //Cek Apakah input email dan password tidak kosong

if(empty($email)|| empty ($password)) {
    $_SESSION['login_error'] = "Email or Password are Required";
    echo "<meta http-equiv='refresh' content='1;url=login.php'>";
    exit();
}

//Cek email dan password yang dikirimkan ada di database
$query="SELECT * FROM users WHERE email ='$email'";
$result=mysqli_query($conn,$query);
$user=mysqli_fetch_assoc($result);

if($user && password_verify($password,$user['password'])){
//Kondisi email dan password valid
//Bawa id dan fullname user yang login ke dashboard.php
$_SESSION['user_id']=$user['id'];
$_SESSION['fullname']=$user['fullname'];
echo "<meta http-equiv='refresh' content='1;url=dashboard.php'>";
}else {
//Kondisi email dan password tidak valid
$_SESSION['login_error'] ="Invalid email or password";
echo"<meta http-equiv='refresh' content='1;url=login.php'>";
}
}

