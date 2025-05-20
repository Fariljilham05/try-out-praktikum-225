<?php
session_start();

$error = $_SESSION['register_error'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['register_error'], $_SESSION['old']);
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #74ebd5, #acb6e5);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }
        .card {
            background-color: #ffffff;
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            border: none;
            font-weight: bold;
        }
        .text-danger {
            font-size: 0.85rem;
        }
        .text-link {
            color: #0d6efd;
            text-decoration: none;
        }
        .text-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-8 col-md-5 col-lg-4">
            <div class="card p-4">
                <div class="card-body">
                    <h3 class="text-center mb-4 fw-bold">Buat Akun!</h3>

                    <?php if ($error): ?>
                        <div class="alert alert-danger text-center" role="alert">
                            <?php foreach ($error as $message): ?>
                                <p><?= $message ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <form action="register_proses.php" method="POST" class="mt-3">
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Nama Lengkap</label>
                            <input type="text" name="fullname" class="form-control" value="<?= $old['fullname'] ?? '' ?>">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= $old['email'] ?? '' ?>">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="password_confirm" class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirm" class="form-control">
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">Daftar</button>
                        </div>
                    </form>

                    <p class="text-center mt-3 mb-0">
                        Sudah punya akun? 
                        <a href="login.php" class="text-link fw-bold">Login Sekarang</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
