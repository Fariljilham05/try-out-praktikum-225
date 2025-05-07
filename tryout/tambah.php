<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="container mt-5">
    <h2>Tambah Post</h2>
    <form action="tambah_proses.php" method="POST">
      
        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-control">Pengarang</label>
            <input type="text" name="content" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="create_at" class="form-control">Tanggal</label>
            <input type="datetime-local" name="create_at" class="form-control" required>
        </div>
       
        <button type="submit" class="btn btn-md btn-primary">Simpan</button>
    </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
