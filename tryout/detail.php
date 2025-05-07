<?php
session_start();
require "config/koneksi.php";

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

  
    $query = "SELECT fullname FROM users WHERE id = '$user_id'";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $fullname = $user['fullname']; 
    } else {
        $fullname = 'Nama tidak tersedia'; 
    }
} else {
    $fullname = 'User belum login';  
}

$post_id = isset($_GET['post_id']) ? $_GET['post_id'] : 0;


$query_post = "SELECT title, content, create_at FROM posts WHERE id = '$post_id'";
$result_post = mysqli_query($conn, $query_post);

if ($result_post && mysqli_num_rows($result_post) > 0) {
    $post = mysqli_fetch_assoc($result_post);
    $title = $post['title'];
    $content = $post['content'];
    $create_at = $post['create_at'];
} else {
    echo "Post tidak ditemukan.";
    exit;
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Post</title>
</head>
<body>
    <h1>Detail Post</h1>
    <p><strong>Nama Lengkap:</strong> <?php echo $fullname; ?></p> 
    <p><strong>Tanggal:</strong> <?php echo $create_at; ?></p> 
    <p><strong>Content:</strong> <?php echo ($content); ?></p>
</html>
