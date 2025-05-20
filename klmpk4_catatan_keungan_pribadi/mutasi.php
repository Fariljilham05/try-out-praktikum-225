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

// Filter query
$where = [];
if (!empty($_GET['dari']) && !empty($_GET['sampai'])) {
    $dari = $_GET['dari'];
    $sampai = $_GET['sampai'];
    $where[] = "tanggal BETWEEN '$dari' AND '$sampai'";
}

if (!empty($_GET['tipe'])) {
    $tipe = $conn->real_escape_string($_GET['tipe']);
    $where[] = "tipe = '$tipe'";
}

$sql_riwayat = "SELECT * FROM saldo";
if (!empty($where)) {
    $sql_riwayat .= " WHERE " . implode(" AND ", $where);
}
$sql_riwayat .= " ORDER BY tanggal DESC";

$result_riwayat = $conn->query($sql_riwayat);
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mutasi Transaksi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f4f6fa; font-family: 'Poppins', sans-serif; }
    .table { background-color: white; border-radius: 10px; }
    .pemasukan { background-color: #cdf7dd; }
    .pengeluaran { background-color: #eab6b6; }
    .section-title { font-weight: 700; font-size: 28px; color: rgb(37, 54, 65); }
  </style>
</head>
<body>
<div class="container mt-5">
  <h2 class="section-title">Mutasi Transaksi</h2>

  <form method="GET" class="row g-3 mb-4">
    <div class="col-md-3">
      <label class="form-label">Dari Tanggal</label>
      <input type="date" class="form-control" name="dari" value="<?= $_GET['dari'] ?? '' ?>">
    </div>
    <div class="col-md-3">
      <label class="form-label">Sampai Tanggal</label>
      <input type="date" class="form-control" name="sampai" value="<?= $_GET['sampai'] ?? '' ?>">
    </div>
    <div class="col-md-3">
      <label class="form-label">Jenis Transaksi</label>
      <select class="form-select" name="tipe">
        <option value="">Semua</option>
        <option value="pemasukan" <?= (isset($_GET['tipe']) && $_GET['tipe'] == 'pemasukan') ? 'selected' : '' ?>>Pemasukan</option>
        <option value="pengeluaran" <?= (isset($_GET['tipe']) && $_GET['tipe'] == 'pengeluaran') ? 'selected' : '' ?>>Pengeluaran</option>
      </select>
    </div>
    <div class="col-md-3 d-flex align-items-end">
      <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
    </div>
  </form>

  <div class="table-responsive">
    <table class="table table-bordered">
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
                $class = $row['tipe'] == 'pemasukan' ? 'pemasukan' : 'pengeluaran';
                echo "<tr class='{$class}'>";
                echo "<td>{$no}</td>";
                echo "<td>" . ucfirst($row['tipe']) . "</td>";
                echo "<td>Rp " . number_format($row['jumlah'], 0, ',', '.') . "</td>";
                echo "<td>{$row['kategori']}</td>";
                echo "<td>{$row['tanggal']}</td>";
                echo "</tr>";
                $no++;
            }
        } else {
            echo "<tr><td colspan='5' class='text-center'>Tidak ada transaksi</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
