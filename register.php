<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register Admin | SmartMart</title>

    <link rel="shortcut icon" href="assets/images/logo-swalayan1.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">

    <style>

        body{

            background:linear-gradient(135deg,#0d6efd,#20c997);

            min-height:100vh;

            display:flex;

            justify-content:center;

            align-items:center;

        }

        .card{

            border:none;

            border-radius:20px;

            box-shadow:0 20px 50px rgba(0,0,0,.2);

        }

    </style>

</head>

<body>

<div class="container">

<div class="row justify-content-center">

<div class="col-lg-5">

<div class="card">

<div class="card-body p-5">

<div class="text-center mb-4">

<img src="assets/images/logo-swalayan1.png" width="70">

<h3 class="mt-3 fw-bold">

Register Admin

</h3>

<p class="text-muted">

SmartMart

</p>

</div>

<?php
if(isset($_SESSION['register_error'])){
?>

<div class="alert alert-danger">

<?= $_SESSION['register_error']; ?>

</div>

<?php
unset($_SESSION['register_error']);
}
?>

<?php
if(isset($_SESSION['register_success'])){
?>

<div class="alert alert-success">

<?= $_SESSION['register_success']; ?>

</div>

<?php
unset($_SESSION['register_success']);
}
?>

<form action="proses/register-proses.php" method="POST">

<div class="mb-3">

<label>Username</label>

<input
type="text"
name="username"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Password</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<div class="mb-4">

<label>Konfirmasi Password</label>

<input
type="password"
name="confirm_password"
class="form-control"
required>

</div>

<button
class="btn btn-success w-100"
name="submit">

<i class="fa fa-user-plus me-2"></i>

Register Admin

</button>

<div class="text-center mt-3">

<a href="form-login.php">

Kembali ke Login

</a>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

</body>

</html>