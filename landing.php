<?php include "view/header.php"; ?>

<div class="jumbotron text-center">
  <h2>Data Landing</h2>
  <form action="" method="post">
    <div class="col-sm-offset-4 col-sm-4">
      <div class="input-group">
        <input type="text" class="form-control" name="cari" placeholder="Cari..." size="10" required autofocus>
        <div class="input-group-btn">
          <button type="submit" class="btn btn-info" name="cek"><i class="fa fa-search"></i></button>
        </div>
      </div>
    </div>
  </form>
</div>

<div class="container" style="margin-bottom:50px">
  <?php if(isset($_SESSION['login'])){ ?>
  <div class="row">
    <div class="col-md-4 col-md-offset-4 text-center">
      <a href="http://localhost/bandara/add/landing.php" class="tombol tombol-info btn-block"><i class="fa fa-plus"></i> Tambah</a>
    </div>
  </div>
  <hr>
  <?php } ?>

  <?php
  if(isset($_SESSION['del'])){
    if($_SESSION['del_key'] == 'landing'){
  ?>

  <div class="col-lg-12">
    <?php
    if($_SESSION['del_res'])
      echo '<div class="alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert">&times;</a>Pesawat dengan kode <strong>'. $_SESSION['del_data'] .'</strong> berhasil dihapus.</p>';
    else
      echo '<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert">&times;</a>Pesawat dengan kode '. $_SESSION['del_data'] .' gagal dihapus.</p>';
    ?>
  </div>

  <?php
    }
    unset($_SESSION['del']);
    unset($_SESSION['del_key']);
    unset($_SESSION['del_res']);
    unset($_SESSION['del_data']);
  }
  ?>
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>Nomor Ekor</th>
        <th>Pesawat</th>
        <!-- <th>Maskapai</th> -->
        <th>Asal</th>
        <th>Penumpang</th>
        <th>Waktu</th>
        <?php if(isset($_SESSION['login'])) echo '<th>Action</th>'; ?>
      </tr>
    </thead>
    <tbody>

    <?php
    include "function/koneksi.php";

    /*$q = "SELECT p.kode_pesawat, CONCAT((SELECT m.nama AS nama_maskapai FROM maskapai m WHERE m.kode_maskapai = p.kode_maskapai), ' - ', p.nama) AS pesawat, CONCAT(b.nama, ', ', b.kota) AS asal, l.penumpang, DATE_FORMAT(l.waktu, '%e %b \'%y %H:%i') AS waktu
            FROM landing l
            INNER JOIN pesawat p
              ON l.kode_pesawat = p.kode_pesawat
            INNER JOIN bandara b
              ON l.asal = b.kode_bandara
            ORDER BY l.id_lnd DESC";*/

    if(isset($_POST['cek'])){
      include "function/func.php";
      $q = purify($_POST['cari']);
      $q = "SELECT * FROM v_landing WHERE kode_pesawat LIKE '%". $q ."%' OR pesawat LIKE '%". $q ."%' OR asal LIKE '%". $q ."%' OR penumpang LIKE '%". $q ."%' OR waktu LIKE '%". $q ."'";
    }
    else {
      $q = "SELECT * FROM v_landing";
    }
    
    $h = mysqli_query($con, $q);

    while($r = mysqli_fetch_assoc($h)):
    ?>
      <tr>
        <td><?= substr($r['kode_pesawat'], 0, 2) . '-' . substr($r['kode_pesawat'], 2);?></td>
        <td><?= $r['pesawat']; ?></td>
        <!-- <td><?= $r['maskapai']; ?></td> -->
        <td><?= $r['asal']; ?></td>
        <td><?= $r['penumpang']; ?></td>
        <td><?= $r['waktu']; ?></td>
        <?php if(isset($_SESSION['login'])): ?>
        <td>
          <a href="http://localhost/bandara/edit/landing.php?kode=<?= $r['id_lnd'] ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
          <a href="http://localhost/bandara/del/landing.php?kode=<?= $r['id_lnd'] ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</a>
        </td>
        <?php endif; ?>
      </tr>
    <?php
    endwhile;
    ?>

    </tbody>
  </table>
</div>

</body>
</html>