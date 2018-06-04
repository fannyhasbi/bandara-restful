<?php
session_start();
if(!isset($_SESSION['login'])){
  header("Location: http://localhost/bandara/login.php");
}
else {
  include "../function/koneksi.php";
  include "../function/func.php";

  $kode = purify($_GET['kode']);

  $q = "DELETE FROM bandara WHERE kode_bandara = '". $kode ."'";

  if(mysqli_query($con, $q)){
    $_SESSION['del'] = true;
    $_SESSION['del_res'] = true;
    $_SESSION['del_key'] = 'bandara';
    $_SESSION['del_data'] = $kode;
    header("Location: http://localhost/bandara/bandara.php");
  }
  else {
    $_SESSION['del'] = true;
    $_SESSION['del_res'] = false;
    $_SESSION['del_key'] = 'bandara';
    $_SESSION['del_data'] = $kode;
    header("Location: http://localhost/bandara/bandara.php");
  }
}