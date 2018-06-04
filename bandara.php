<?php include "view/header.php"; ?>

<div class="jumbotron text-center">
  <h2>Data Bandara</h2>
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
      <a href="http://localhost/data_bandara/add/bandara.php" class="tombol tombol-info btn-block"><i class="fa fa-plus"></i> Tambah</a>
    </div>
  </div>
  <hr>
  <?php } ?>

  <?php
  if(isset($_SESSION['del'])){
    if($_SESSION['del_key'] == 'bandara'){
  ?>

  <div class="col-lg-12">
    <?php
    if($_SESSION['del_res'])
      echo '<div class="alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert">&times;</a>Bandara dengan kode <strong>'. $_SESSION['del_data'] .'</strong> berhasil dihapus.</p>';
    else
      echo '<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert">&times;</a>Bandara dengan kode '. $_SESSION['del_data'] .' gagal dihapus.</p>';
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
        <th>Nama Bandara</th>
        <th>Kota</th>
        <th>Negara</th>
        <?php if(isset($_SESSION['login'])) echo '<th>Action</th>'; ?>
      </tr>
    </thead>
    <tbody>

    <?php
    include "function/koneksi.php";

    if(isset($_POST['cek'])){
      include "function/func.php";
      $q = purify($_POST['cari']);
      $q = "SELECT * FROM bandara WHERE kode_bandara LIKE '%". $q ."%' OR nama LIKE '%". $q ."%' OR kota LIKE '%". $q ."%' OR negara LIKE '%". $q ."%'";
    }
    else{
      $q = "SELECT * FROM bandara";
    }

    $h = mysqli_query($con, $q);
    while($r = mysqli_fetch_assoc($h)):
    ?>
      <tr>
        <td><?= $r['nama'];?></td>
        <td><?= $r['kota']; ?></td>
        <td><?= $r['negara']; ?></td>
        <?php if(isset($_SESSION['login'])): ?>
        <td>
          <a href="http://localhost/data_bandara/edit/bandara.php?kode=<?= $r['kode_bandara'] ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
          <a href="http://localhost/data_bandara/del/bandara.php?kode=<?= $r['kode_bandara'] ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</a>
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