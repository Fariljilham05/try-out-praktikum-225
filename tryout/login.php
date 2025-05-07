<?php 
//Aktifkan session
session_start();
$error =$_SESSION['login_error'] ??'';
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  </head>
  <body>
    <div class="container mt-5">
       <div class="row justify-content-center">
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h3>Login</h3>
                    <?php if ($error): ?>
                      <small class="text-danger"> <?=$error ?></small>
                      <?php endif ?>  
                    <form action="login_proses.php" method="POST" class="mt-3">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>

                    </form>
                    <p class="text-center mt-3">
                     Don't Have an account? <a href="register.php" class="text-decoration-none fw-bold">Register</a>
                </p>
                </div>
            </div>
        </div>
     </div> 
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  </body>
</html>