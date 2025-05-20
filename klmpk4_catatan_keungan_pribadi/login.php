<?php
session_start();
$error = $_SESSION['login_error'] ?? [];
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
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
          transition: background 0.4s ease;
      }

      .btn-primary:hover {
          background: linear-gradient(135deg, #00f2fe, #4facfe);
      }

      .text-danger {
          font-size: 0.85rem;
          font-weight: 500;
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
              <h3 class="text-center mb-4 fw-bold">Login</h3>

        
              <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?php
                    foreach ($error as $key => $message) {
                        echo "<p>$message</p>";
                    }
                    ?>
                </div>
              <?php endif; ?>

              <form action="login_proses.php" method="POST" class="mt-3">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
              </form>

              <p class="text-center mt-3 mb-0">
                Belum punya akun?
                <a href="index.php" class="text-link fw-bold">Daftar sekarang</a>
              </p>

            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
