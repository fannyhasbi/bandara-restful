<?php

function purify($stmt){
  global $con;
  $f = trim($stmt);
  $f = stripslashes($f);
  $f = htmlspecialchars($f);
  return mysqli_real_escape_string($con, $f);
}