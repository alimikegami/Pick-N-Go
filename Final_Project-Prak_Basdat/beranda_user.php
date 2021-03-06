<?php 
  session_start();
  require 'functions.php';
  $tuples = read("SELECT * FROM tipe_kendaraan ORDER BY harga_sewa;");
  if(!isset($_SESSION["login_pelanggan"])) {
    header("location: form_login.php");
    exit;
  }
  if(isset($_POST["search-model-user"])) {
    $keyword = $_POST["keyword-search-model-user"];
    $tuples = read("SELECT tipe_kendaraan.ID_model, model, manufaktur, harga_sewa, gambar, jumlah_unit FROM tipe_kendaraan LEFT JOIN (SELECT ID_model, COUNT(ID_kendaraan) AS jumlah_unit FROM unit_kendaraan GROUP BY ID_model) AS n ON tipe_kendaraan.ID_model = n.ID_model WHERE model LIKE '%$keyword%';");
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styling.css">
    <link rel="icon" href="Images/Logo/logo_square.png" type="image/x-icon" />
    <title>Pick N Go</title>
  </head>
  <body>
  	<input type="checkbox" id="hamburger-menu">
  	<nav>
  		<a href="index.php" class="logo"><img src="Images/Logo/logo.png" style="max-height:60px;" class="img-fluid"></a>
      <button type="button" id = "logout-button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalLogout">
        Logout
      </button>

  		<label for="hamburger-menu" class="hamburger"><i class="fa fa-bars"></i></label>
  	</nav>

  	<div class="sidebar">
  		<h2>
  			<?= $_SESSION["username"]?>
  		</h2>
  		<a href="profil_user.php"><i class="fa fa-user"></i><span>Profil</span></a>
  		<a href="beranda_user.php" style="background-color: #b34509;"><i class="fa fa-truck"></i><span>Beranda</span></a>
  		<a href="request_peminjaman_user.php"><i class = "fa fa-hourglass"></i><span>Request Peminjaman</span></a>
  		<a href="list_peminjaman_user.php"><i class = "fa fa-credit-card-alt"></i><span>List Peminjaman</span></a>
      <a href="list_pengembalian_user.php"><i class = "fa fa-list-alt"></i><span>List Pengembalian</span></a>
  		<a href="" class = "logout" data-bs-toggle="modal" data-bs-target="#modalLogout"><span>Logout</span></a>
  	</div>

    <div class = "content">
      
      <form action="" method="post" autocomplete="off" class="search-form">
          <div class="utility-bar">
            <div></div>
            <div class="input-group">
              <div class="form-floating">
                <input type="text" class="form-control" id="floatingInput" placeholder="Cari berdasarkan nama" name="keyword-search-model-user">
                <label for="floatingInput">Cari Berdasarkan Nama</label>
              </div>
              <button type="submit" class="fa fa-search btn btn-dark searchbtn" name="search-model-user"></button>
            </div>
        </div>
      </form>
      <div class="row card-container"> 
        <?php foreach ($tuples as $tuple): ?>
          <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="card mt-5 mx-auto shadow" style="width: 18rem; border-radius:20px; margin-bottom:20px;">
              <img class="card-img-top" src="Images/TipeMobil/<?= $tuple["gambar"]; ?>" alt="Gambar <?= $tuple["model"] ?>">
              <div class="card-body">
                <h5 class="card-title"><?= $tuple["model"] ?></h5>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><?= $tuple["manufaktur"] ?></li>
                <li class="list-group-item">Harga: Rp.<?= $tuple["harga_sewa"] ?>/hari</li>
              </ul>
              <div class="card-body text-center">
                <a class="btn btn-primary" href="halaman_peminjaman_user.php?p_k_model=<?= $tuple["ID_model"]; ?>" role="button">Sewa Sekarang</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->

      <!-- Modal -->
      <div class="modal" id="modalLogout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Logout</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Apakah anda yakin akan logout?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
              <a href="logoutlogic.php" class="btn btn-danger">Logout</a>
            </div>
          </div>
        </div>
      </div>
  </body>
</html>