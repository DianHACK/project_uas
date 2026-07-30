<?php
  include "proses/koneksi.php";
  session_start();
  if(!isset($_SESSION['login'])){
    header('location:form-login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">
<?php include('komponen/head.php') ?>
<body>
  <!-- Preloader -->
  <div class="preloader">
    <img src="./assets/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid" />
  </div>
  <div id="main-wrapper">
    <aside class="left-sidebar with-vertical">
      <div>
      <?php include('komponen/sidebar.php') ?>
      </div>
    </aside>
    <!--  konten -->
    <div class="page-wrapper">
      <div class="body-wrapper">

      <?php include('komponen/navbar.php') ?>
        <?php 
          if(!isset($_REQUEST['page'])){
            $_REQUEST['page'] = 'home';
            }
            include("pages/".$_REQUEST['page'].".php");
        ?> 
      </div>
      
      <?php include('komponen/footer.php') ?>
    </div>
    <!--  konten -->
  </div>
  

  <div class="dark-transparent sidebartoggler"></div>
  <?php include('komponen/script.php') ?>
</body>
</html>

