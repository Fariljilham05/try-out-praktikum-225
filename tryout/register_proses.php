<?php 
session_start();
// masukan koneksi 
require 'config/koneksi.php';


if($_SERVER['REQUEST_METHOD']==="POST"){
    // ambil input yang ada di index html
    $fullname = htmlspecialchars($_POST['fullname']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $password_confirm = htmlspecialchars($_POST['password_confirm']);


// variable penampung error validasi

$error = [];

// pengecekan input tidak boleh kosong

if(empty($fullname)){
    $error['fullname'] = "Fullname is required";
}

if(empty($email)){
    $error['email'] = "Email is required";
}


if(empty($password)){
    $error['password'] = "Password is required";
}

if(empty($password_confirm)){
    $error['password_confirm'] = "Password confirm is required";
}

// pengecekan password dan confirm password tidak sama
if ($password !== $password_confirm){
    $error['password_confirm'] = "Password and confirm password do not match";
}

// apa bila ada error kirim pesan ke index.php

 if(!empty($error)){
    $_SESSION['error'] = $error;
    $_SESSION['old'] = [
        "fullname" => $fullname,
        "email" => $email,
    ];
    echo "<meta http-equiv='refresh' content='1;url=register.php'>";
    exit();
 }

// jika tidak ada error disetiap input simpan data register ke table
if(empty($error)){
    // password yang di inputkan akan menjadi karakter random sebanyak 225 karkater
    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users(fullname, email, password) VALUES ('$fullname','$email','$hash_password')";

    // simpan 
    if(mysqli_query($conn, $query)){
        echo "<meta http-equiv='refresh' content='1;url=login.php'>";
    }else{
        echo "Error: . mysqli_error($conn)";
    }
}

}
?>