<?php
if(isset($_POST['submit'])){
    header('location:../form-login.php');
}


$username = $_POST['username'];
$password = $_POST['password'];


session_start();

if($username == ''){
    $_SESSION['er_username'] = "Username tidak boleh kosong !";
}
if($password == ''){
    $_SESSION['er_password'] = "Password tidak boleh kosong !";
}

if(
    $username == '' ||
    $password == '' 
){
    header('location:../form-login.php');
    exit();
}



$konek = mysqli_connect('localhost', 'root', '', 'pbo_sems4');
$sql = "SELECT * FROM login WHERE username='$username'";
$obj = mysqli_query($konek, $sql);
$row = mysqli_num_rows($obj);

if($row == 0){
    $_SESSION['er_login'] = "data kamu bermasalah!";
    header('location:../form-login.php');
    exit();
}else{
    $ary = mysqli_fetch_array($obj);
    $pass_hash = $ary['password'];
    if(!password_verify($password, $pass_hash)){
        $_SESSION['er_login'] = "data kamu bermasalah";
        header('location:../form-login.php');
        exit();
    }
}
$_SESSION['login'] = true;
$_SESSION['username'] = $ary['username'];
$_SESSION['kasir'] = $ary['username'];
header('location:../form-login.php');
