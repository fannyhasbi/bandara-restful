<?php
session_start();
if(!isset($_SESSION['login'])){
  header("Location: http://localhost/data_bandara/login.php");
}
else {
  include "../function/koneksi.php";
  include "../function/func.php";

  $kode = purify($_GET['kode']);

  $q = "DELETE FROM pesawat WHERE kode_pesawat = '". $kode ."'";

  if(mysqli_query($con, $q)){
    $_SESSION['del'] = true;
    $_SESSION['del_res'] = true;
    $_SESSION['del_key'] = 'pesawat';
    $_SESSION['del_data'] = $kode;
    header("Location: http://localhost/data_bandara/pesawat.php");
  }
  else {
    $_SESSION['del'] = true;
    $_SESSION['del_res'] = false;
    $_SESSION['del_key'] = 'pesawat';
    $_SESSION['del_data'] = $kode;
    header("Location: http://localhost/data_bandara/pesawat.php");
  }
}