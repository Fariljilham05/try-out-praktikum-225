<?php

require 'config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_POST['id'];

    $query = "DELETE FROM posts WHERE id =$id";

    if (mysqli_query($conn, $query)) {
        echo "<meta http-equiv='refresh' content='1;url=dashaboard.php'>";
    }else{
        echo mysqli_error($conn);
        echo "<meta http-equiv='refresh' content='5;url=index.php'>";
    }
}
?>