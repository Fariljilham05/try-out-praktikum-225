<?php 
session_start();

if (!isset($_SESSION['user_id'])){
    echo "<meta http-equiv='refresh' content='1;url=login.php'>";
    exit();
}

$host = "localhost";
$user = "root"; 
$pass = "";  
$db   = "auth_faril";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $tipe = $_POST['tipe'];
    $kategori = $_POST['kategori'];
    $jumlah = (int) $_POST['jumlah'];
    $tanggal = $_POST['tanggal'];

    $stmt = $conn->prepare("INSERT INTO saldo (tipe, kategori, jumlah, tanggal) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $tipe, $kategori, $jumlah, $tanggal);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil disimpan!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<div class='alert alert-danger'>Gagal menyimpan data.</div>";
    }

    $stmt->close();
}

$sql_masuk = "SELECT SUM(jumlah) AS total_masuk FROM saldo WHERE tipe='pemasukan'";
$result_masuk = $conn->query($sql_masuk);
$row_masuk = $result_masuk->fetch_assoc();
$total_pemasukan = $row_masuk['total_masuk'] ?? 0;

$sql_keluar = "SELECT SUM(jumlah) AS total_keluar FROM saldo WHERE tipe='pengeluaran'";
$result_keluar = $conn->query($sql_keluar);
$row_keluar = $result_keluar->fetch_assoc();
$total_pengeluaran = $row_keluar['total_keluar'] ?? 0;

$saldo_dompet = $total_pemasukan - $total_pengeluaran;

$sql_riwayat = "SELECT * FROM saldo ORDER BY tanggal DESC";
$result_riwayat = $conn->query($sql_riwayat);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
      body {
        background-color: #f4f6fa;
        font-family: 'Poppins', sans-serif;
      }
      .table {
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      }
      thead.table-light th {
        background-color: #e9ecef;
        color: #333;
      }
      .table-bordered th, .table-bordered td {
        vertical-align: middle;
      }
      .btn-secondary {
        border-radius: 10px;
        font-weight: 500;
      }
      h3 {
        font-weight: 600;
        margin-bottom: 20px;
      }
      select.form-select {
        border-radius: 8px;
      }
      .navbar {
        background: linear-gradient(to right, #007bff, #00bcd4);
      }
      .navbar-brand {
        color: white !important;
        font-style: italic;
        font-weight: bold;
      }
      .nav-link {
        color: #333;
      }
      .nav-link.active {
        font-weight: bold;
        color: #007bff !important;
      }
      .table tbody tr.pemasukan {
        background-color: rgb(205, 247, 221);
      }
      .table tbody tr.pengeluaran {
        background-color: rgb(218, 167, 167); 
      }
      .section-title {
        font-weight: 700;
        font-size: 28px;
        color: rgb(37, 54, 65);
      }
    </style>
  </head>
  <body>
    <!-- navbar -->
    <nav class="navbar bg-light fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">
          <img src="img/a.png" width="35" height="35" class="me-2">Dompet Qu
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title">
              <img src="img/a.png" width="35" height="35" class="me-2">Dompet Qu
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
          </div>
          <div class="sidebar d-flex flex-column p-3">
            <nav class="nav flex-column">
              <a class="nav-link active bi-house-door" href="dashboard.php"> Dashboard</a>
              <a class="nav-link bi-journal-text" href="riwayat_mutasi.php"> Mutasi</a>
            </nav>
          </div>
          <form class="d-flex mt-3" role="search">
            <input class="form-control me-2" type="search" placeholder="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </div>
      </div>
    </nav><br><br><br>

    <div class="card mt-4">
      <div class="card-body">
        <h2 class="section-title">Riwayat Transaksi</h2>

        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead class="table-light">
              <tr>
                <th>No</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Kategori</th>
                <th>Tanggal</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($result_riwayat->num_rows > 0) {
                  $no = 1;
                  while ($row = $result_riwayat->fetch_assoc()) {
                      $tipe_class = ($row['tipe'] === 'pemasukan') ? 'pemasukan' : 'pengeluaran';
                      echo "<tr class='{$tipe_class}'>";
                      echo "<td>{$no}</td>";
                      echo "<td>" . ucfirst($row['tipe']) . "</td>";
                      echo "<td>Rp " . number_format($row['jumlah'], 0, ',', '.') . "</td>";
                      echo "<td>{$row['kategori']}</td>";
                      echo "<td>{$row['tanggal']}</td>";
                      echo "</tr>";
                      $no++;
                  }
              } else {
                  echo "<tr><td colspan='5' class='text-center'>Belum ada transaksi</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
