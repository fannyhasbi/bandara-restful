<?php

class Api {
  public $koneksi;

  public function __construct(){
    $this->koneksi = mysqli_connect("localhost", "root", "", "bandara") OR die(mysql_error());

    // Mengatasi isu CORS
    header( "Access-Control-Allow-Origin: *");
    header( "Access-Control-Allow-Headers: x-requested-with, x-requested-by");
    header( "Access-Control-Allow-Methods: POST, GET");
    // header( "Access-Control-Allow-Credentials: true");
    // header( "Access-Control-Max-Age: 604800");
    // header( "Access-Control-Request-Headers: x-requested-with");
  }

  public function bandara(){
    $q = "SELECT * FROM bandara";
    $hasil = mysqli_query($this->koneksi, $q);
    $show = array();

    while($r = mysqli_fetch_assoc($hasil)){
      array_push($show, $r);
    }

    Flight::json($show);
  }

}

