<?php
session_start();
if(!isset($_SESSION['login'])){
  header("Location: http://localhost/data_bandara/login.php");
}

include "header.php";
include "../function/koneksi.php";
include "../function/func.php";

if(isset($_POST['tambah'])){
  if(isset($_POST['kode']) && isset($_POST['nama']) && isset($_POST['kapasitas']) && isset($_POST['maskapai']) && isset($_POST['pabrik'])){
    $k = purify($_POST['kode']);
    $n = purify($_POST['nama']);
    $s = purify($_POST['kapasitas']);
    $m = purify($_POST['maskapai']);
    $p = purify($_POST['pabrik']);

    $q = "INSERT INTO pesawat VALUES ('". $k ."', '". $n ."', '". $s ."', '". $m ."', '". $p ."')";
    if(mysqli_query($con, $q)){
      header("Location: http://localhost/data_bandara/pesawat.php");
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
  <h2>Tambah Pesawat</h2>
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
        <label for="kode">Nomor Ekor</label>
        <input type="text" name="kode" class="form-control" required autofocus>
      </div>

      <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" name="nama" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="kapasitas">Kapasitas</label>
        <input type="number" name="kapasitas" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="maskapai">Maskapai</label>
        <!-- <input type="text" name="maskapai" class="form-control" required> -->
        <select name="maskapai" class="form-control">
          <?php
          $q = "SELECT * FROM maskapai";
          $h = mysqli_query($con, $q);
          while($r = mysqli_fetch_assoc($h)){
          ?>
            <option value="<?= $r['kode_maskapai']; ?>"><?= $r['nama']; ?></option>
          <?php
          }
          ?>
        </select>
      </div>

      <div class="form-group">
        <label for="pabrik">Pabrik</label>
        <select name="pabrik" class="form-control">
          <?php
          $q2 = "SELECT * FROM pabrik";
          $h2 = mysqli_query($con, $q2);
          while($r2 = mysqli_fetch_assoc($h2)){
          ?>
            <option value="<?= $r2['kode_pabrik']; ?>"><?= $r2['nama_pabrik']; ?></option>
          <?php
          }
          ?>
        </select>
      </div>

      <div class="form-group">
        <input type="submit" name="tambah" class="btn btn-block btn-success" value="TAMBAH">
      </div>
    </form>
  </div>
</div>