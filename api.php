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

  private function response404(){
    $show = array(
      'status' => 404,
      'message' => 'Not Found'
    );
    Flight::json($show);
  }

  private function responseError(){
    $show = array(
      'status' => 500,
      'message' => 'Internal Error'
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

    try {
      $q = "SELECT * FROM bandara WHERE kode_bandara = '$kode'";
      if(mysqli_query($this->koneksi, $q)->num_rows == 0){
        $q = "
          INSERT INTO bandara VALUES ('$kode', '$nama', '$kota', '$negara')
        ";

        if(!mysqli_query($this->koneksi, $q)){
          $this->responseError();
          return;
        }

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
      else {
        $show = array(
          'status' => 400,
          'message' => 'Cannot add more data with code '. $kode
        );
        Flight::json($show);
      }
    }
    catch(Exception $e){
      $this->responseError();
    }
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

    try {
      $q = "SELECT * FROM bandara WHERE kode_bandara = '$kode'";
      if(mysqli_query($this->koneksi, $q)->num_rows > 0){
        $q = "
          UPDATE bandara SET nama = '$nama', kota = '$kota', negara = '$negara' WHERE kode_bandara = '$kode'
        ";

        if(!mysqli_query($this->koneksi, $q)){
          $this->responseError();
          return;
        }

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
      else {
        $this->response404();
      }
    }
    catch(Exception $e){
      $this->responseError();
    }
  }

  public function delete_bandara(){
    if(!isset(Flight::request()->data->kode)){
      $this->response400();
      return;
    }

    $kode = $this->purify(Flight::request()->data->kode);


    try {
      $q = "SELECT * FROM bandara WHERE kode_bandara = '$kode'";
      if(mysqli_query($this->koneksi, $q)->num_rows > 0){
        $q = "DELETE FROM bandara WHERE kode_bandara = '$kode'";
        
        if(!mysqli_query($this->koneksi, $q)){
          $this->responseError();
          return;
        }

        $show = array(
          'status' => 200,
          'data' => array(
            'kode' => $kode
          )
        );

        Flight::json($show);
      }
      else {
        $this->response404();
        return;
      }
    }
    catch(Exception $e){
      $this->responseError();
    }
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

  public function tambah_pesawat(){
    if(!(isset(Flight::request()->data->kode) && isset(Flight::request()->data->nama) && isset(Flight::request()->data->maskapai) && isset(Flight::request()->data->kapasitas) && isset(Flight::request()->data->pabrik))){
      $this->response400();
      return;
    }

    $kode = $this->purify(Flight::request()->data->kode);
    $nama = $this->purify(Flight::request()->data->nama);
    $maskapai  = $this->purify(Flight::request()->data->maskapai);
    $kapasitas = $this->purify(Flight::request()->data->kapasitas);
    $pabrik    = $this->purify(Flight::request()->data->pabrik);

    try {
      $q = "SELECT * FROM pesawat WHERE kode_pesawat = '$kode'";
      if(mysqli_query($this->koneksi, $q)->num_rows == 0){
        $q = "
          INSERT INTO pesawat VALUES ('$kode', '$nama', ". (int)$kapasitas .", '$maskapai', '$pabrik')
        ";

        if(!mysqli_query($this->koneksi, $q)){
          $this->responseError();
          return;
        }

        $show = array(
          'status' => 200,
          'data' => array(
            'kode' => $kode,
            'nama' => $nama,
            'maskapai'  => $maskapai,
            'kapasitas' => $kapasitas,
            'pabrik'    => $pabrik
          )
        );

        Flight::json($show);
      }
      else {
        $show = array(
          'status' => 400,
          'message' => 'Cannot add more data with code '. $kode
        );
        Flight::json($show);
      }
    }
    catch(Exception $e){
      $this->responseError();
    }
  }

  public function update_pesawat(){
    if(!(isset(Flight::request()->data->kode) && isset(Flight::request()->data->nama) && isset(Flight::request()->data->maskapai) && isset(Flight::request()->data->kapasitas) && isset(Flight::request()->data->pabrik))){
      $this->response400();
      return;
    }

    $kode = $this->purify(Flight::request()->data->kode);
    $nama = $this->purify(Flight::request()->data->nama);
    $maskapai  = $this->purify(Flight::request()->data->maskapai);
    $kapasitas = $this->purify(Flight::request()->data->kapasitas);
    $pabrik    = $this->purify(Flight::request()->data->pabrik);

    try {
      $q = "SELECT * FROM pesawat WHERE kode_pesawat = '$kode'";
      if(mysqli_query($this->koneksi, $q)->num_rows > 0){
        $q = "
          UPDATE pesawat SET nama = '$nama', kode_maskapai = '$maskapai', kapasitas = ". (int)$kapasitas .", kode_pabrik = '$pabrik' WHERE kode_pesawat = '$kode'
        ";

        if(!mysqli_query($this->koneksi, $q)){
          $this->responseError();
          return;
        }

        $show = array(
          'status' => 200,
          'data' => array(
            'kode' => $kode,
            'nama' => $nama,
            'maskapai'  => $maskapai,
            'kapasitas' => $kapasitas,
            'pabrik'    => $pabrik
          )
        );
      }
      else {
        $this->response404();
      }
    }
    catch(Exception $e){
      $this->responseError();
    }

    Flight::json($show);
  }

  public function delete_pesawat(){
    if(!isset(Flight::request()->data->kode)){
      $this->response400();
      return;
    }

    $kode = $this->purify(Flight::request()->data->kode);


    try {
      $q = "SELECT * FROM pesawat WHERE kode_pesawat = '$kode'";
      if(mysqli_query($this->koneksi, $q)->num_rows > 0){
        $q = "DELETE FROM pesawat WHERE kode_pesawat = '$kode'";
        
        if(!mysqli_query($this->koneksi, $q)){
          $this->responseError();
          return;
        }

        $show = array(
          'status' => 200,
          'data' => array(
            'kode' => $kode
          )
        );

        Flight::json($show);
      }
      else {
        $this->response404();
        return;
      }
    }
    catch(Exception $e){
      $this->responseError();
    }
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
