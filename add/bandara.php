<?php
session_start();
if(!isset($_SESSION['login'])){
  header("Location: http://localhost/data_bandara/login.php");
}

include "header.php";
include "../function/koneksi.php";
include "../function/func.php";

if(isset($_POST['tambah'])){
  if(isset($_POST['kode']) && isset($_POST['nama']) && isset($_POST['kota']) && isset($_POST['negara'])){
    $k = purify($_POST['kode']);
    $n = purify($_POST['nama']);
    $t = purify($_POST['kota']);
    $g = purify($_POST['negara']);

    $q = "INSERT INTO bandara VALUES ('". $k ."', '". $n ."', '". $t ."', '". $g ."')";
    if(mysqli_query($con, $q)){
      header("Location: http://localhost/data_bandara/bandara.php");
    }
    else {
      $err = "Terjadi kesalahan, coba beberapa saat lagi";
    }
  }
  else {
    $err = "Semua kolom harus diisi";
  }
}

?>

<div class="jumbotron text-center">
  <h2>Tambah Bandara</h2>
</div>

<div class="container">
  <div class="col-md-4 col-md-offset-4">
    <form action="" method="post">
      <?php if(isset($err)){ ?>
      <div class="form-group">
        <p class="alert alert-danger"><?= $err ?></p>  
      </div>
      <?php } ?>

      <div class="form-group">
        <label for="kode">Kode Bandara</label>
        <input type="text" name="kode" class="form-control" required autofocus>
      </div>

      <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" name="nama" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="kota">Kota</label>
        <input type="text" name="kota" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="negara">Negara</label>
        <input type="text" name="negara" class="form-control" required>
      </div>

      <div class="form-group">
        <input type="submit" name="tambah" class="btn btn-block btn-success" value="TAMBAH">
      </div>
    </form>
  </div>
</div>