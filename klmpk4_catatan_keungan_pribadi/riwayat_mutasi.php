<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<meta http-equiv='refresh' content='1;url=login.php'>";
    exit();
}

$conn = new mysqli("localhost", "root", "", "auth_faril");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$tipe = $_GET['tipe'] ?? 'semua';
$dari = $_GET['dari'] ?? date('Y-m-d', strtotime('-7 days'));
$sampai = $_GET['sampai'] ?? date('Y-m-d');

$query = "SELECT * FROM saldo WHERE tanggal BETWEEN ? AND ?";
$params = [$dari, $sampai];
$types = "ss";

if ($tipe !== 'semua') {
    $query .= " AND tipe = ?";
    $params[] = $tipe;
    $types .= "s";
}

$query .= " ORDER BY tanggal DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Mutasi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body { background-color: #f5f5f5; padding: 20px; font-family: sans-serif; }
    .mutasi-box { background: white; padding: 20px; border-radius: 10px; margin-bottom: 20px; }
    .debit { color: red; }
    .kredit { color: blue; }
    .tanggal { font-weight: bold; font-size: 16px; }

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
  </style>
</head>
<body>
    <!-- navbar -->
<nav class="navbar bg-light fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#" style="font-style: italic; font-weight: bold;">
    <img src="img/a.png" width="40" height="40" class="me-2">Dompet Qu</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" style="font-style: italic; font-weight: bold;">
        <img src="img/a.png" width="35" height="35" class="me-2">Dompet Qu</h5>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
      </div>
      <div class="sidebar d-flex flex-column p-3">
        <nav class="nav flex-column">
        <a class="nav-link active bi-house-door" href="dashboard.php"> Dashboard</a>
      
        <a class="nav-link bi-clock-history" href="riwayat_transaksi.php">Riwayat Transaksi</a>
        </nav>
      </div>
      <form class="d-flex mt-3" role="search">
        <input class="form-control me-2" type="search" placeholder="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav><br>


<div class="container mt-5" >
  <h3 class="mb-4">Riwayat Transaksi</h3>

  <form method="get" class="row g-3">
    <div class="col-md-3">
      <label>Dari Tanggal:</label>
      <input type="date" name="dari" class="form-control" value="<?= $dari ?>" max="<?= date('Y-m-d') ?>">
    </div>
    <div class="col-md-3">
      <label>Sampai Tanggal:</label>
      <input type="date" name="sampai" class="form-control" value="<?= $sampai ?>" max="<?= date('Y-m-d') ?>">
    </div>
    <div class="col-md-3">
      <label>Jenis Transaksi:</label>
      <select name="tipe" class="form-select">
        <option value="semua" <?= $tipe === 'semua' ? 'selected' : '' ?>>Semua</option>
        <option value="pemasukan" <?= $tipe === 'pemasukan' ? 'selected' : '' ?>>Pemasukan</option>
        <option value="pengeluaran" <?= $tipe === 'pengeluaran' ? 'selected' : '' ?>>Pengeluaran</option>
      </select>
    </div>
    <div class="col-md-3 align-self-end">
      <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
    </div>
  </form>

  <hr>

  <?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="mutasi-box">
        <div class="tanggal"><?= date('d/m/Y', strtotime($row['tanggal'])) ?></div>
        <div class="<?= $row['tipe'] === 'pengeluaran' ? 'debit' : 'kredit' ?>">
          Rp <?= number_format($row['jumlah'], 0, ',', '.') ?> 
          (<?= strtoupper($row['tipe']) ?>)
        </div>
        <div>Kategori: <?= htmlspecialchars($row['kategori']) ?></div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <div class="alert alert-warning">Tidak ada transaksi ditemukan pada periode tersebut.</div>
  <?php endif; ?>


  <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
