<?php
session_start();
if(isset($_SESSION['login']))
  header("Location: ./");

include "function/koneksi.php";
include "function/func.php";

if(isset($_POST['login'])){
  $un = purify($_POST['username']);
  $pa = purify($_POST['password']);

  $q = "SELECT * FROM admin WHERE username = '". $un ."'";
  $h = mysqli_query($con, $q);
  $r = mysqli_fetch_assoc($h);

  if(password_verify($pa, $r['password'])){
    $_SESSION['login'] = true;
    $_SESSION['username'] = $r['username'];
    header("Location: pesawat.php");
  }
  else {
    $error = "Hmmm";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Bandar Udara Ahmad Yani</title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>

<div class="jumbotron text-center">
  <h2>LOGIN ADMINISTRATOR</h2>
</div>

<div class="container">
  <div class="col-md-offset-4 col-md-4">
    <form action="" method="post">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username" required autofocus>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password" required>
      </div>
      <?php if(isset($error)){ ?>
        <div>
          <p class="form-control alert alert-warning"><?= $error ?></p>
        </div>
      <?php } ?>
      <div class="form-group">
        <input type="submit" class="btn btn-success btn-block btn-lg" name="login" value="Login">
      </div>
    </form>
  </div>
</div>

</body>
</html>