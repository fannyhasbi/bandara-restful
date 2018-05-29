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

  public function pesawat(){
    $q = "SELECT * FROM pesawat";
    $hasil = mysqli_query($this->koneksi, $q);
    $show = array();

    while($r = mysqli_fetch_assoc($hasil)){
      array_push($show, $r);
    }

    Flight::json($show);
  }

  public function takeoff(){
    $q = "
      SELECT t.id_to,
        p.kode_pesawat,
        p.nama AS nama_pesawat,
        m.nama AS nama_maskapai,
        b.kota, b.nama AS nama_bandara,
        t.penumpang,
        DATE_FORMAT(t.waktu, '%e %b \'%y %H:%i') AS waktu
      FROM takeoff t
      INNER JOIN pesawat p
        ON t.kode_pesawat = p.kode_pesawat
      INNER JOIN maskapai m
        ON p.kode_maskapai = m.kode_maskapai
      INNER JOIN bandara b
        ON t.tujuan = b.kode_bandara";

    $hasil = mysqli_query($this->koneksi, $q);
    $show = array();

    while($r = mysqli_fetch_assoc($hasil)){
      array_push($show, $r);
    }

    Flight::json($show);
  }

  public function landing(){
    $q = "
      SELECT l.id_lnd,
        p.kode_pesawat,
        p.nama AS nama_pesawat,
        m.nama AS nama_maskapai,
        b.kota, b.nama AS nama_bandara,
        l.penumpang,
        DATE_FORMAT(l.waktu, '%e %b \'%y %H:%i') AS waktu
      FROM landing l
      INNER JOIN pesawat p
        ON l.kode_pesawat = p.kode_pesawat
      INNER JOIN maskapai m
        ON p.kode_maskapai = m.kode_maskapai
      INNER JOIN bandara b
        ON l.asal = b.kode_bandara";

    $hasil = mysqli_query($this->koneksi, $q);
    $show = array();

    while($r = mysqli_fetch_assoc($hasil)){
      array_push($show, $r);
    }

    Flight::json($show);
  }

}
