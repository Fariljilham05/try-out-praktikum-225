<?php
require 'config/koneksi.php';

 $query = mysqli_query($conn, "SELECT * FROM posts") or die("Query gagal: " . mysqli_error($conn));
 $query = "SELECT posts.id, posts.title, posts.create_at, users.fullname 
          FROM posts 
          JOIN users ON posts.user_id = users.id 
          ORDER BY posts.create_at DESC";

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Halaman Post User</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Post</a></li>
        <li class="nav-item"><a class="nav-link" href="login.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <h2>Posts</h2>
  <a href="tambah.php" class="btn btn-primary mb-3">Tambah Post</a>

  <table class="table table-bordered text-center">
    <thead class="table-light">
      <tr>
        <th>No</th>
        <th>Judul</th>
        <th>Pengarang</th>
        <th>Tanggal</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
    <?php
      if (mysqli_num_rows($result) > 0) {
          $no = 1;
          while ($data = mysqli_fetch_assoc($result)) {
              ?>
              <tr>
                  <td><?= $no ?></td>
                  <td><?= htmlspecialchars($data['title']) ?></a></td>
                  <td><?= htmlspecialchars($data['fullname']) ?></td>
                  <td><?= $data['create_at'] ?></td>
                  <td>
                      <form action="hapus_proses.php" method="POST" class="d-inline">
                          <input type="hidden" name="id" value="<?= $data['id'] ?>" />
                          <a href='detail.php?id=$show[id]' class='btn btn-primary btn-sm'>Detail</a>
                          <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data?')">Hapus</button>
                      </form>
                  </td>
              </tr>
              <?php
              $no++;
          }
      } else {
          echo "<tr><td colspan='5' class='text-center text-danger'>Data tidak ditemukan.</td></tr>";
      }
      ?>
  </table>
</div>

</body>
</html>
