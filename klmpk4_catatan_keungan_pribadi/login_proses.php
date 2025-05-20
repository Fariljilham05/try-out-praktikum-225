<?php
session_start();

// Masukkan file koneksi
require 'config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Ambil nilai input email dan password
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // Variabel penampung error validasi
    $error = [];

    // Pengecekan input email tidak boleh kosong
    if (empty($email)) {
        $error['email'] = "Email wajib diisi";
    }

    // Pengecekan input password tidak boleh kosong
    if (empty($password)) {
        $error['password'] = "Password wajib diisi";
    }

    // Pengecekan jika ada error
    if (!empty($error)) {
        $_SESSION['login_error'] = $error;
        echo "<meta http-equiv='refresh' content='1;url=login.php'>";
        exit();
    }

    // Cek email dan password yang dikirim ada di database
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        // Kondisi email dan password valid
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['fullname'] = $user['fullname'];
        echo "<meta http-equiv='refresh' content='1;url=dashboard.php'>";
    } else {
        // Kondisi email dan password tidak valid
        $_SESSION['login_error'] = ['email' => 'Email atau password tidak valid'];
        echo "<meta http-equiv='refresh' content='1;url=login.php'>";
    }
}
?>
