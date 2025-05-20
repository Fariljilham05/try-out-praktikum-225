<?php
session_start();
require 'config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $fullname = htmlspecialchars($_POST['fullname']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $password_confirm = htmlspecialchars($_POST['password_confirm']);

  
    $error = [];

   
    if (empty($fullname)) {
        $error['fullname'] = "Nama lengkap harus diisi";
    }

    if (empty($email)) {
        $error['email'] = "Email harus diisi";
    }

    if (empty($password)) {
        $error['password'] = "Password harus diisi";
    }

    if (empty($password_confirm)) {
        $error['password_confirm'] = "Konfirmasi password harus diisi";
    }

    if ($password !== $password_confirm) {
        $error['password_confirm'] = "Password dan konfirmasi password tidak cocok";
    }

   
    if (!empty($error)) {
        $_SESSION['register_error'] = $error;
        $_SESSION['old'] = [
            "fullname" => $fullname,
            "email" => $email,
        ];
        header('Location: index.php'); 
        exit();
    }

    
    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users(fullname, email, password) VALUES ('$fullname', '$email', '$hash_password')";

    if (mysqli_query($con, $query)) {
        header('Location: login.php'); 
    } else {
        $_SESSION['register_error'] = ['general' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.'];
        header('Location: index.php');
    }
}
?>
