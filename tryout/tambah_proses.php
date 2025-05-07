<?php
session_start();
require "config/koneksi.php";

if (!isset($_SESSION["user_id"])) {
    die("User belum login.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $judul = htmlspecialchars($_POST["title"]);
    $pengarang = htmlspecialchars($_POST["content"]);
    $tanggal = htmlspecialchars($_POST["create_at"]);

    $query = "INSERT INTO posts(user_id, title, content, create_at) 
              VALUES ('$user_id','$judul','$pengarang','$tanggal')";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<meta http-equiv='refresh' content='1;url=dashboard.php'>";
    } else {
        echo "Query error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
