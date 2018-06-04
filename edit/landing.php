<?php
session_start();
if(!isset($_SESSION['login'])){
  header("Location: http://localhost/bandara/login.php");
}

include "header.php";
include "../function/koneksi.php";
include "../function/func.php";

date_default_timezone_set('Asia/Jakarta');
$tgl = date('Y-m-d');
$wkt = date('H:i');

if(isset($_POST['tambah'])){
  if(isset($_POST['tujuan']) && isset($_POST['tanggal']) && isset($_POST['waktu']) && isset($_POST['pesawat']) && isset($_POST['penumpang'])){
    $t = purify($_POST['tujuan']);
    $g = purify($_POST['tanggal']);
    $w = purify($_POST['waktu']);
    $p = purify($_POST['pesawat']);
    $n = purify($_POST['penumpang']);

    $waktu = $g ." ". $w .":00";

    $q = "UPDATE landing SET asal = '". $t ."', waktu = '". $waktu ."', kode_pesawat = '". $p ."', penumpang = ". $n ." WHERE id_lnd = ". $_POST['kode_awal'];
    
    if(mysqli_query($con, $q)){
      header("Location: http://localhost/bandara/landing.php");
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
$qu = "SELECT * FROM landing WHERE id_lnd = '". $kode ."'";
$ro = mysqli_fetch_assoc(mysqli_query($con, $qu));

?>

<div class="jumbotron text-center">
  <h2>Tambah Penerbangan</h2>
</div>

<div class="container">
  <div class="col-md-6 col-md-offset-3">
    <form action="" method="post">
      <?php if(isset($err)){ ?>
      <div class="form-group">
        <p class="alert alert-danger"><?= $err ?></p>  
      </div>
      <?php } ?>

      <div class="form-group">
        <label for="tujuan">Asal</label>
        <select name="tujuan" class="form-control" required>
          <?php
          $q = "SELECT * FROM bandara";
          $h = mysqli_query($con, $q);
          while($r = mysqli_fetch_assoc($h)){
          ?>
            <option value="<?= $r['kode_bandara']; ?>" <?php if($ro['asal'] == $r['kode_bandara']){ echo " selected";}?>><?= $r['nama']; ?></option>
          <?php
          }
          ?>
        </select>
      </div>

      <div class="form-group">
        <div class="row">
          <div class="col-md-6">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="<?= $tgl ?>" required>
          </div>
          <div class="col-md-6">
            <label for="waktu">Waktu</label>
            <input type="time" name="waktu" class="form-control" value="<?= $wkt ?>" required>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label for="pesawat">Pesawat</label>
        <select name="pesawat" class="form-control">
          <?php
          $q = "SELECT p.kode_pesawat, p.nama, m.kode_maskapai, m.nama AS maskapai FROM pesawat p INNER JOIN maskapai m ON p.kode_maskapai = m.kode_maskapai ORDER BY kode_maskapai";
          $h = mysqli_query($con, $q);
          while($r = mysqli_fetch_assoc($h)){
          ?>
            <option value="<?= $r['kode_pesawat']; ?>" <?php if($ro['kode_pesawat'] == $r['kode_pesawat']){ echo " selected";}?>><?= $r['maskapai'] ." - ". $r['nama']; ?></option>
          <?php
          }
          ?>
        </select>
      </div>

      <div class="form-group">
        <label for="penumpang">Penumpang</label>
        <input type="number" name="penumpang" class="form-control" value="<?= $ro['penumpang']; ?>" required>
      </div>      

      <input type="hidden" name="kode_awal" value="<?= $_GET['kode']; ?>">

      <div class="form-group">
        <input type="submit" name="tambah" class="btn btn-block btn-success" value="UPDATE">
      </div>
    </form>
  </div>
</div>