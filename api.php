<?php

class Api {
  public $koneksi;

  private function purify($req){
    return mysqli_real_escape_string($this->koneksi, $req);
  }

  private function response400(){
    $show = array(
      'status' => 400,
      'message'=> 'Bad Request'
    );
    Flight::json($show);
  }

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

  public function __destruct(){
    mysqli_close($this->koneksi);
  }

  /**
    * Start Bandara
    */

  public function bandara(){
    $q = "SELECT * FROM bandara";
    $hasil = mysqli_query($this->koneksi, $q);
    $show = array();

    while($r = mysqli_fetch_assoc($hasil)){
      array_push($show, $r);
    }

    Flight::json($show);
  }

  public function tambah_bandara(){
    if(!(isset(Flight::request()->data->kode) && isset(Flight::request()->data->nama) && isset(Flight::request()->data->kota) && isset(Flight::request()->data->negara))){
      $this->response400();
      return;
    }

    $kode = $this->purify(Flight::request()->data->kode);
    $nama = $this->purify(Flight::request()->data->nama);
    $kota = $this->purify(Flight::request()->data->kota);
    $negara = $this->purify(Flight::request()->data->negara);

    $q = "
      INSERT INTO bandara VALUES ('$kode', '$nama', '$kota', '$negara')
    ";

    mysqli_query($this->koneksi, $q);

    $show = array(
      'status' => 200,
      'data' => array(
        'kode' => $kode,
        'nama' => $nama,
        'kota' => $kota,
        'negara' => $negara
      )
    );

    Flight::json($show);
  }

  public function update_bandara(){
    if(!(isset(Flight::request()->data->kode) && isset(Flight::request()->data->nama) && isset(Flight::request()->data->kota) && isset(Flight::request()->data->negara))){
      $this->response400();
      return;
    }

    $kode = $this->purify(Flight::request()->data->kode);
    $nama = $this->purify(Flight::request()->data->nama);
    $kota = $this->purify(Flight::request()->data->kota);
    $negara = $this->purify(Flight::request()->data->negara);

    $q = "
      UPDATE bandara SET nama = '$nama', kota = '$kota', negara = '$negara' WHERE kode_bandara = '$kode'
    ";

    mysqli_query($this->koneksi, $q);

    $show = array(
      'status' => 200,
      'data' => array(
        'kode' => $kode,
        'nama' => $nama,
        'kota' => $kota,
        'negara' => $negara
      )
    );

    Flight::json($show);
  }

  /**
    * End Bandara
    */


  /**
    * Start Pesawat
    */

  public function pesawat(){
    $q = "SELECT * FROM pesawat";
    $hasil = mysqli_query($this->koneksi, $q);
    $show = array();

    while($r = mysqli_fetch_assoc($hasil)){
      array_push($show, $r);
    }

    Flight::json($show);
  }

  /**
    ********************
    * End Pesawat
    ********************
    */

  /**
    * Start Take Off
    */

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

  /**
    ********************
    * End Take Off
    ********************
    */

  /**
    * Start Landing
    */

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

  /**
    ********************
    * End Landing
    ********************
    */

}
