<?php
session_start();
if(!isset($_SESSION['login'])){
  header("Location: http://localhost/bandara/login.php");
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

    $q = "UPDATE bandara SET kode_bandara = '". $k ."', nama = '". $n ."', kota = '". $t ."', negara = '". $g ."' WHERE kode_bandara = '". $_POST['kode_awal'] ."'";
    if(mysqli_query($con, $q)){
      header("Location: http://localhost/bandara/bandara.php");
    }
    else {
      $err = "Terjadi kesalahan, coba beberapa saat lagi";
    }
  }
  else {
    $err = "Semua kolom harus diisi";
  }
}

if(!isset($_GET['kode']))
  header("Location: http://localhost/bandara/login.php");

$kode = purify($_GET['kode']);
$qu = "SELECT * FROM bandara WHERE kode_bandara = '". $kode ."'";
$ro = mysqli_fetch_assoc(mysqli_query($con, $qu));
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
        <input type="text" name="kode" class="form-control" value="<?= $ro['kode_bandara']; ?>" required autofocus>
      </div>

      <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" name="nama" class="form-control" value="<?= $ro['nama']; ?>" required>
      </div>

      <div class="form-group">
        <label for="kota">Kota</label>
        <input type="text" name="kota" class="form-control" value="<?= $ro['kota']; ?>" required>
      </div>

      <div class="form-group">
        <label for="negara">Negara</label>
        <input type="text" name="negara" class="form-control" value="<?= $ro['negara']; ?>" required>
      </div>

      <input type="hidden" name="kode_awal" value="<?= $_GET['kode']; ?>">

      <div class="form-group">
        <input type="submit" name="tambah" class="btn btn-block btn-success" value="UPDATE">
      </div>
    </form>
  </div>
</div>