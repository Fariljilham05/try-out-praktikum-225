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

$sql_masuk = "SELECT SUM(jumlah) AS total_masuk FROM saldo 
              WHERE tipe='pemasukan' AND MONTH(tanggal) = MONTH(CURDATE()) AND YEAR(tanggal) = YEAR(CURDATE())";
$result_masuk = $conn->query($sql_masuk);
$row_masuk = $result_masuk->fetch_assoc();
$total_pemasukan = $row_masuk['total_masuk'] ?? 0;

$sql_keluar = "SELECT SUM(jumlah) AS total_keluar FROM saldo 
               WHERE tipe='pengeluaran' AND MONTH(tanggal) = MONTH(CURDATE()) AND YEAR(tanggal) = YEAR(CURDATE())";
$result_keluar = $conn->query($sql_keluar);
$row_keluar = $result_keluar->fetch_assoc();
$total_pengeluaran = $row_keluar['total_keluar'] ?? 0;

$saldo_dompet = $total_pemasukan - $total_pengeluaran;

$total_semua = $total_pemasukan + $total_pengeluaran;
$persen_masuk = $total_semua > 0 ? ($total_pemasukan / $total_semua) * 100 : 0;
$persen_keluar = 100 - $persen_masuk;

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

$sql = "SELECT * FROM saldo 
        WHERE kategori LIKE '%$keyword%' 
        OR tipe LIKE '%$keyword%' 
        OR tanggal LIKE '%$keyword%' 
        ORDER BY tanggal DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dompet Qu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6fa;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      }

    .navbar {
      background: linear-gradient(to right, #007bff, #00bcd4);
      color: white;
    }

    .navbar-brand,
    .navbar-brand:hover {
      color: white;
    }

    .sidebar .nav-link {
      color: #333;
      font-weight: 500;
      transition: background 0.3s, color 0.3s;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background-color: #e3f2fd;
      color: #007bff;
      border-radius: 8px;
    }

    .main-content {
      padding: 30px 20px;
    }

    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .card-body h6 {
      font-weight: bold;
    }

    .card-icon {
      font-size: 2.5rem;
      color: white;
    }

    .btn {
      border-radius: 10px;
      font-weight: 500;
    }

    .btn-secondary {
      background-color: #6c757d;
      border: none;
    }

    .btn-secondary:hover {
      background-color: #5a6268;
    }

    a.text-decoration-none.fw-bold {
      color: #007bff;
      transition: color 0.2s;
    }

    a.text-decoration-none.fw-bold:hover {
      color: #0056b3;
    }

    .pie-chart-container {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .pie-chart {
    width: 250px;
    height: 250px;
    border-radius: 50%;
    background: conic-gradient(
      #28a745 0% var(--pemasukan),
      #dc3545 var(--pemasukan) 100%
    );
    margin-bottom: 20px;
  }

  .legend .badge {
    margin: 3px;
    font-size: 14px;
    padding: 6px 10px;
  }

  @media (max-width: 768px) {
    .pie-chart {
      width: 200px;
      height: 200px;
    }
  }
    
  </style>
</head>
<body>

  <nav class="navbar bg-light fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#" style="font-style: italic; font-weight: bold;">
        <img src="img/a.png" width="35" height="35" class="me-2">Dompet Qu</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end" id="offcanvasNavbar">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" style="font-style: italic; font-weight: bold;">
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
        <form class="d-flex mt-3" role="search" method="GET" action="riwayat_mutasi.php">
          <input class="form-control me-2" type="search" name="keyword" placeholder="Search" required>
           <button class="btn btn-outline-success" type="submit">Search</button>
        </form>

      </div>
    </div>
  </nav>

  <div class="main-content container-fluid mt-5">
    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <div class="card text-white bg-primary">
          <div class="card-body d-flex align-items-center">
            <div class="me-3 card-icon"></div>
            <div>
              <h6 class="bi bi-wallet2 mb-0"> Saldo Dompet</h6>
              <p class="mb-0">Rp <?= number_format($saldo_dompet, 0, ',', '.') ?></p>
            </div>
          </div>
        </div>
      </div>
    
      <div class="col-md-4">
        <div class="card text-white bg-danger">
          <div class="card-body d-flex align-items-center">
            <div class="me-3 card-icon"></div>
            <div>
              <h6 class="mb-0 bi-file-earmark-minus"> Pengeluaran</h6>
              <p class="mb-0">Rp <?= number_format($total_pengeluaran, 0, ',', '.') ?></p>
            </div>
          </div>
        </div>
      </div>
    
      <div class="col-md-4">
        <div class="card text-white bg-success">
          <div class="card-body d-flex align-items-center">
            <div class="me-3 card-icon"></div>
            <div>
              <h6 class="mb-0 bi-cash-stack"> Pemasukan</h6>
              <p class="mb-0">Rp <?= number_format($total_pemasukan, 0, ',', '.') ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>

   
<div class="row mt-4">
  <div class="col-md-6 mb-4">
    <div class="card h-100">
      <div class="card-body">
        <a href="riwayat_transaksi.php" class="btn btn-secondary mb-3 bi-clock-history"> Riwayat Transaksi</a>
        <h5 class="card-title">Tambah Transaksi</h5>
        <form action="" method="POST">
          <div class="mb-3">
            <label for="tipe" class="form-label">Jenis Transaksi</label>
            <select class="form-select" id="tipe" name="tipe" required>
              <option value="pemasukan">Pemasukan</option>
              <option value="pengeluaran">Pengeluaran</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah Uang (Rp)</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" required>
          </div>
          <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <input type="text" class="form-control" id="kategori" name="kategori" required>
          </div>
          <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
          </div>
          <button type="submit" name="submit" class="btn btn-secondary">Simpan</button>
        </form>
        <div class="d-flex justify-content-between mt-3">
          <a href="dashboard.php" class="text-decoration-none fw-bold bi-arrow-clockwise"> Refresh</a>
          <a href="logout.php" class="text-decoration-none fw-bold bi-box-arrow-right"> Logout</a>
        </div>
      </div>
    </div>
  </div>

 
  <div class="col-md-6 mb-4">
    <div class="card h-100">
      <div class="card-body text-center">
        <h5 class="card-title " style="font-style: italic; ">Grafik Pemasukan dan pengeluaran</h5>
        <div class="pie-chart-container mt-5" style="--pemasukan: <?= $persen_masuk ?>%;">
          <div class="pie-chart"></div>
          <div class="legend mt-3">
            <span class="badge bg-success">Pemasukan: <?= round($persen_masuk) ?>%</span>
            <span class="badge bg-danger">Pengeluaran: <?= round($persen_keluar) ?>%</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

 


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
