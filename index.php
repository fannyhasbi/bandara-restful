<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Bandar Internasional Ahmad Yani</title>
  <meta charset="utf-8">

  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">

</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigasi">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="<?= 'http://localhost/data_bandara'?>" class="navbar-brand">Ahmad Yani</a>
    </div>
    <div class="collapse navbar-collapse" id="navigasi">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="pesawat.php">Pesawat</a></li>
        <li><a href="bandara.php">Bandara</a></li>
        <li><a href="takeoff.php">Data Takeoff</a></li>
        <li><a href="landing.php">Data Landing</a></li>
        <?php
          if(!isset($_SESSION['login']))
            echo '<li><a href="login.php">Masuk <i class="fa fa-sign-in"></i></a></li>';
          else
            echo '<li><a href="logout.php">Keluar <i class="fa fa-sign-out"></i></a></li>';
        ?>
      </ul>
    </div>
  </div>
</nav>

<header id="header" class="jumbotron vertical-center">
  <div class="container">
    <h1>Bandar Udara Internasional Ahmad Yani</h1>
    <h2>Aksi Menginspirasi, Melayani Sepenuh Hati</h2>
  </div>
</header>

</body>
</html>