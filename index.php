<?php

require 'koneksi.php';

$query = "SELECT * FROM products";

$result = mysqli_query($connect, $query);
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
  <h1>LATIHAN CRUD PHP MYSQL</h1>
    <a href="tambah.php" class="btn btn-primary">Tambah data</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Merek</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Exsperied</th>
                <th>#</th>
            </tr>

    <tbody>

    <?php 

    if (mysqli_num_rows($result) > 0 ){
    $no = 1;
    while ($show = mysqli_fetch_assoc($result)){
    echo "
    <tr>
       <td>$no</td>
       <td>$show[nama_produk]</td>
       <td>$show[merek]</td>
       <td>$show[harga]</td>
       <td>$show[stok]</td>
       <td>$show[experied]</td>
       <td>
       <a href='detail.php?id=$show[id]' class='btn btn-info'>Detail</a>
        <a href='edit.php?id=$show[id]' class='btn btn-warning'>Edit</a>

        <form action='hapus_proses.php' method= 'POST' class='d-inline'>
          <input type='hidden' name='id' value='$show[id]' />
          <button type='submit' class='btn btn-danger'>Delete</button>
        </form>
        </td>
    </tr>
    ";
    $no ++;
    }
    } else {
    echo "<div class='text-danger'>Data tidak ada</div>";
    }
    ?>

    
    </tbody

    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>