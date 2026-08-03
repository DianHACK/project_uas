<?php
session_start();

if(isset($_SESSION['login'])){
    header("Location: index.php");
    exit();
}
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | SmartMart</title>
    <link rel="shortcut icon" href="assets/images/logo-swalayan1.png">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #f0f4ff 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border: none;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            animation: fadeIn 0.6s ease-in-out;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .brand-pane {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            position: relative;
            overflow: hidden;
        }
        .brand-pane::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            top: -100px;
            right: -100px;
        }
        .form-control {
            height: 50px;
            border-radius: 12px;
            border: 1px solid #dee2e6;
            font-size: 14px;
            padding-left: 15px;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.12);
        }
        .input-group-text {
            background-color: transparent;
            border-right: none;
            border-radius: 12px 0 0 12px;
            color: #6c757d;
        }
        .input-group .form-control {
            border-left: none;
        }
        .input-group:focus-within {
            border-color: #0d6efd;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.12);
            border-radius: 12px;
        }
        .input-group:focus-within .form-control,
        .input-group:focus-within .input-group-text,
        .input-group:focus-within .btn {
            border-color: #0d6efd !important;
        }
        .btn-login {
            height: 50px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            letter-spacing: 0.5px;
            background: #0d6efd;
            border: none;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background: #0b5ed7;
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(13, 110, 253, 0.3);
        }
        .logo-img {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="row justify-content-center align-items-center">
        <div class="col-xl-9 col-lg-10 col-md-11">
            <div class="card login-card bg-white">
                <div class="row g-0">
                    
                    <!-- LEFT BRANDING SIDE -->
                    <div class="col-lg-5 brand-pane text-white p-5 d-none d-lg-flex flex-column justify-content-between">
                        <div>
                            <?php if(file_exists("assets/images/logo-swalayan1.png")){ ?>
                                <img src="assets/images/logo-swalayan1.png" class="logo-img mb-3 bg-white p-2 rounded-3 shadow-sm">
                            <?php } ?>
                            <h3 class="fw-bold mb-1">SmartMart</h3>
                            <p class="text-white-50 fs-6">Sistem Informasi Penjualan Barang</p>
                        </div>
                        <div>
                            <p class="text-white-50 mb-0" style="font-size: 13px;">
                                Kelola inventaris, rak, kategori, hingga transaksi penjualan kasir dengan cepat, akurat, dan terintegrasi.
                            </p>
                        </div>
                    </div>

                    <!-- RIGHT FORM SIDE -->
                    <div class="col-lg-7 p-4 p-sm-5 d-flex flex-column justify-content-center">
                        
                        <div class="text-center text-lg-start mb-4">
                            <h4 class="fw-bold text-dark mb-1">Selamat Datang! 👋</h4>
                            <p class="text-muted fs-7 mb-0">Silakan masuk menggunakan akun kasir/admin Anda.</p>
                        </div>

                        <!-- ALERT ERROR GLOBAL (Jika data bermasalah dari server) -->
                        <?php if(isset($_SESSION['er_login'])){ ?>
                            <div class="alert alert-danger border-0 bg-danger-subtle text-danger py-2 px-3 rounded-3 mb-3 fs-7">
                                <i class="fa fa-circle-exclamation me-2"></i>
                                <?= $_SESSION['er_login']; ?>
                            </div>
                        <?php } ?>

                        <!-- FORM -->
                        <form action="proses/form-login-proses.php" method="POST" id="loginForm" novalidate>

                            <!-- USERNAME -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold fs-7 text-secondary">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <input type="text" name="username" id="username" class="form-control <?= isset($_SESSION['er_username']) ? 'is-invalid':'' ?>" placeholder="Masukkan username..." autocomplete="off">
                                </div>
                                <div class="invalid-feedback d-block text-danger mt-1 fs-7" id="errorUsername" style="display: none !important;">
                                    <?= $_SESSION['er_username'] ?? 'Username tidak boleh kosong!' ?>
                                </div>
                            </div>

                            <!-- PASSWORD -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold fs-7 text-secondary">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                    <input type="password" name="password" id="password" class="form-control <?= isset($_SESSION['er_password']) ? 'is-invalid' : '' ?>" placeholder="Masukkan password...">
                                    <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword" style="border-radius: 0 12px 12px 0;">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback d-block text-danger mt-1 fs-7" id="errorPassword" style="display: none !important;">
                                    <?= $_SESSION['er_password'] ?? 'Password tidak boleh kosong!' ?>
                                </div>
                            </div>

                            <!-- REMEMBER ME -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label text-muted fs-7" for="remember">Ingat Username</label>
                                </div>
                            </div>

                            <!-- SUBMIT BUTTON -->
                            <div class="d-grid mb-3">
                                <button type="submit" name="submit" id="btnLogin" class="btn btn-primary btn-login text-white">
                                    <span id="btnText">
                                        <i class="fa-solid fa-right-to-bracket me-2"></i> Masuk Sistem
                                    </span>
                                    <span id="btnLoading" style="display:none;">
                                        <span class="spinner-border spinner-border-sm me-2"></span> Memproses...
                                    </span>
                                </button>
                            </div>

                            <!-- FOOTER INFO -->
                            <div class="text-center mt-4">
                                <small class="text-muted" style="font-size: 12px;">
                                    Copyright &copy; <?= date('Y'); ?> <strong>SmartMart</strong>. All rights reserved.
                                </small>
                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

<script>
// SHOW / HIDE PASSWORD
const togglePassword = document.getElementById("togglePassword");
const passwordField = document.getElementById("password");

togglePassword.addEventListener("click", function () {
    const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
    passwordField.setAttribute("type", type);
    this.innerHTML = type === "password" ? '<i class="fa-solid fa-eye"></i>' : '<i class="fa-solid fa-eye-slash"></i>';
});

// CLIENT-SIDE VALIDATION & LOADING STATE
const loginForm = document.getElementById("loginForm");
const usernameField = document.getElementById("username");
const errorUsername = document.getElementById("errorUsername");
const errorPassword = document.getElementById("errorPassword");

// Jika ada error dari server session, tampilkan feedback-nya
<?php if(isset($_SESSION['er_username'])){ ?>
    usernameField.classList.add('is-invalid');
    errorUsername.style.display = 'block';
<?php } ?>

<?php if(isset($_SESSION['er_password'])){ ?>
    passwordField.classList.add('is-invalid');
    errorPassword.style.display = 'block';
<?php } ?>

loginForm.addEventListener("submit", function(e){
    let valid = true;

    // Validasi Username Kosong
    if(usernameField.value.trim() === ""){
        usernameField.classList.add("is-invalid");
        errorUsername.textContent = "Username tidak boleh kosong!";
        errorUsername.style.display = "block";
        valid = false;
    } else {
        usernameField.classList.remove("is-invalid");
        errorUsername.style.display = "none";
    }

    // Validasi Password Kosong
    if(passwordField.value.trim() === ""){
        passwordField.classList.add("is-invalid");
        errorPassword.textContent = "Password tidak boleh kosong!";
        errorPassword.style.display = "block";
        valid = false;
    } else {
        passwordField.classList.remove("is-invalid");
        errorPassword.style.display = "none";
    }

    if(!valid){
        e.preventDefault(); // Batalkan submit jika ada yang kosong
        return;
    }

    // Tampilkan loading jika validasi lolos
    document.getElementById("btnText").style.display = "none";
    document.getElementById("btnLoading").style.display = "inline-block";
    document.getElementById("btnLogin").disabled = true;
});

// REMEMBER USERNAME LOGIC
const rememberCheck = document.getElementById("remember");

window.addEventListener("load", function(){
    const savedUsername = localStorage.getItem("smartmart_username");
    if(savedUsername){
        usernameField.value = savedUsername;
        rememberCheck.checked = true;
    }
});

rememberCheck.addEventListener("change", function(){
    if(this.checked){
        localStorage.setItem("smartmart_username", usernameField.value);
    }else{
        localStorage.removeItem("smartmart_username");
    }
});

usernameField.addEventListener("keyup", function(){
    if(rememberCheck.checked){
        localStorage.setItem("smartmart_username", this.value);
    }
});
</script>

<?php if(isset($_SESSION['success'])){ ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '<?= $_SESSION['success']; ?>',
    confirmButtonColor: '#0d6efd'
});
</script>
<?php unset($_SESSION['success']); } ?>

<?php if(isset($_SESSION['failed'])){ ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Login Gagal',
    text: '<?= $_SESSION['failed']; ?>',
    confirmButtonColor: '#dc3545'
});
</script>
<?php unset($_SESSION['failed']); } ?>

</body>
</html>
<?php
unset($_SESSION['er_login']);
unset($_SESSION['er_username']);
unset($_SESSION['er_password']);
?>