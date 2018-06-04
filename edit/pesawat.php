<?php
session_start();
if(!isset($_SESSION['login'])){
  header("Location: http://localhost/bandara/login.php");
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

    $q = "UPDATE pesawat SET kode_pesawat = '". $k ."', nama = '". $n ."', kapasitas = ". $s .", kode_maskapai = '". $m ."', kode_pabrik = '". $p ."' WHERE kode_pesawat = '". $_POST['kode_awal'] ."'";

    if(mysqli_query($con, $q)){
      header("Location: http://localhost/bandara/pesawat.php");
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
$qu = "SELECT * FROM pesawat WHERE kode_pesawat = '". $kode ."'";
$ro = mysqli_fetch_assoc(mysqli_query($con, $qu));

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
        <input type="text" name="kode" class="form-control" value="<?= $ro['kode_pesawat'] ?>" required autofocus>
      </div>

      <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" name="nama" class="form-control" value="<?= $ro['nama'] ?>" required>
      </div>

      <div class="form-group">
        <label for="kapasitas">Kapasitas</label>
        <input type="number" name="kapasitas" class="form-control" value="<?= $ro['kapasitas'] ?>" required>
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
            <option value="<?= $r['kode_maskapai']; ?>" <?php if($ro['kode_maskapai'] == $r['kode_maskapai']){ echo ' selected';} ?>><?= $r['nama']; ?></option>
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
            <option value="<?= $r2['kode_pabrik']; ?>" <?php if($ro['kode_pabrik'] == $r['kode_pabrik']){ echo ' selected';} ?>><?= $r2['nama_pabrik']; ?></option>
          <?php
          }
          ?>
        </select>
      </div>

      <input type="hidden" name="kode" value="<?= $_GET['kode'] ?>">

      <div class="form-group">
        <input type="submit" name="tambah" class="btn btn-block btn-success" value="TAMBAH">
      </div>
    </form>
  </div>
</div>