<?php
session_start();
if(isset($_SESSION['login'])){
    header('location:index.php');
    exit();
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="./assets/images/logo-swalayan1.png" />
    <title>Super Market - Login</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <!-- Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0d6efd, #0dcaf0);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #0d6efd;
        }
        .input-group-text {
            background-color: #f8f9fa;
        }
    </style>
  </head>
  <body>
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-5 col-lg-4">
                <form action="proses/form-login-proses.php" method="post">
                    <div class="bg-white p-4 p-md-5 login-card">
                        
                        <!-- Logo & Header Section -->
                        <div class="text-center mb-4">
                            <div class="d-flex justify-content-center align-items-center gap-2 mb-2">
                                <?php if(file_exists('assets/images/logo-swalayan1.png')): ?>
                                    <img width="50" src="assets/images/logo-swalayan1.png" alt="Logo 1">
                                <?php endif; ?>
                                <?php if(file_exists('assets/images/logo-swalayan2.png')): ?>
                                    <img width="90" height="50" class="object-fit-contain" src="assets/images/logo-swalayan2.png" alt="Logo 2">
                                <?php endif; ?>
                            </div>
                            <h4 class="fw-bold text-dark mt-3">Form Login</h4>
                            <p class="text-muted small">Silakan masuk menggunakan akun Anda</p>
                            <hr class="text-muted opacity-25">
                        </div>

                        <!-- Error Alert Global (Backend Compatible) -->
                        <?php
                        if(isset($_SESSION['er_login'])){
                            ?>
                            <div class="alert alert-danger alert-dismissible fade show py-2 small" role="alert">
                                <i class="fa-solid fa-triangle-exclamation me-1"></i> <?= $_SESSION['er_login'] ?>
                                <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php
                        }
                        ?>

                        <!-- Input Username (Backend Compatible) -->
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-semibold">Username</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0"><i class="fa-solid fa-user text-muted"></i></span>
                                <input type="text" class="form-control form-control-lg border-start-0 fs-6 <?= isset($_SESSION['er_username'])? 'is-invalid':null ?>" name="username" placeholder="Masukkan username" autocomplete="off">
                                <div class="invalid-feedback">
                                    <?= $_SESSION['er_username'] ?? '' ?>
                                </div>
                            </div>
                        </div>

                        <!-- Input Password (Backend Compatible) -->
                        <div class="mb-4">
                            <label class="form-label text-secondary small fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0"><i class="fa-solid fa-lock text-muted"></i></span>
                                <input type="password" class="form-control form-control-lg border-start-0 fs-6 <?= isset($_SESSION['er_password'])? 'is-invalid':null ?>" name="password" placeholder="Masukkan password">
                                <div class="invalid-feedback">
                                    <?= $_SESSION['er_password'] ?? '' ?>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Login (Backend Compatible) -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg py-2 fw-bold shadow-sm" name="submit">
                                <i class="fa-solid fa-right-to-bracket me-2"></i> Login
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  </body>
</html>