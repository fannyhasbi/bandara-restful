<?php
session_start();
if(!isset($_SESSION['login'])){
  header("Location: http://localhost/bandara/login.php");
}
else {
  include "../function/koneksi.php";
  include "../function/func.php";

  $kode = purify($_GET['kode']);

  $q = "DELETE FROM landing WHERE id_lnd = '". $kode ."'";

  if(mysqli_query($con, $q)){
    $_SESSION['del'] = true;
    $_SESSION['del_res'] = true;
    $_SESSION['del_key'] = 'landing';
    $_SESSION['del_data'] = $kode;
    header("Location: http://localhost/bandara/landing.php");
  }
  else {
    $_SESSION['del'] = true;
    $_SESSION['del_res'] = false;
    $_SESSION['del_key'] = 'landing';
    $_SESSION['del_data'] = $kode;
    header("Location: http://localhost/bandara/landing.php");
  }
}