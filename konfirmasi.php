<?php
  session_start();
  include "dbconnect.php";

  $idorder = $_GET['id'];

  if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
  }

  if(isset($_POST['confirm']))
	{
		
		$userid = $_SESSION['id'];
		$veriforderid = mysqli_query($conn,"SELECT * FROM cart WHERE orderid='$idorder'");
		$fetch = mysqli_fetch_array($veriforderid);
		$liat = mysqli_num_rows($veriforderid);
		
		if($fetch>0){
      $nama = $_POST['nama'];
      $metode = $_POST['metode'];
      $tanggal = $_POST['tanggal'];
			  
      $kon = mysqli_query($conn,"INSERT INTO konfirmasi (orderid, userid, payment, namarekening, tglbayar) VALUES('$idorder','$userid','$metode','$nama','$tanggal')");
      if ($kon){
      
      $up = mysqli_query($conn,"UPDATE cart SET STATUS='Confirmed' WHERE orderid='$idorder'");
      
      
      $berhasil = true;
		} else { 
      $gagal = true;
		}
	} else {
			$error = true;
	}		
};
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- ===== CSS ===== -->
    <link rel="stylesheet" href="assets/css/styles.css" />

    <!-- ===== BOX ICONS ===== -->
    <link href="https://unpkg.com/boxicons@2.0.8/css/boxicons.min.css" rel="stylesheet" />

    <!-- ===== Bootstrap ===== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <title>Tokoku | Konfirmasi</title>
  </head>
  <body>
    <!--===== HEADER =====-->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light scroll-navbar">
      <div class="container-fluid">
        <a class="navbar-brand fs-3" href="index.php">Tokoku</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link fs-6" href="index.php">Home</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> Product </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <?php 
                  $kat=mysqli_query($conn,"SELECT * FROM kategori ORDER BY idkategori ASC");
                  while($p=mysqli_fetch_array($kat)) :
                ?>
                <li><a class="dropdown-item" href="product.php?idkategori=<?= $p['idkategori'] ?>"><?php echo $p['namakategori'] ?></a></li>
                <?php endwhile; ?>
              </ul>
            </li>
          </ul>
          <form class="d-flex" action="search.php" method="post">
            <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search" />
            <button class="btn btn-outline-dark me-2" type="submit">Search</button>
            <?php 
              if(!isset($_SESSION['login'])) {
                echo "<a   href='login.php' class='btn btn-outline-dark me-2' type='button'>Login</a>";
              } else {
                if($_SESSION['role']=='Member') {
                  echo "<a href='logout.php' class='btn btn-outline-dark me-2' type='button'>Logout</a>";
                } else {
                  echo "<a href='admin' class='btn btn-outline-dark me-2' type='button'>Admin</a>";
                  echo "<a href='logout.php' class='btn btn-outline-dark me-2' type='button'>Logout</a>";
                }
              }
            ?>
          </form>
        </div>
      </div>
    </nav>

    <main class="main">
      <?php if (isset($berhasil)) { ?>
        <div class='alert alert-success'>
            Terima kasih telah melakukan konfirmasi, team kami akan melakukan verifikasi. 
            Informasi selanjutnya akan dikirim via Email
        </div>
        <meta http-equiv='refresh' content='4; url= index.php'/>  "
      <?php } else if (isset($gagal)) { ?>
        <div class='alert alert-danger'>
          Gagal Submit, Silakan ulangi lagi.
        </div>
        <meta http-equiv='refresh' content='3; url= konfirmasi.php'/>
      <?php } else if (isset($error)) { ?>
        <div class='alert alert-danger'>
			      Kode Order tidak ditemukan, harap masukkan kembali dengan benar!
        </div>
        <meta http-equiv='refresh' content='4; url= konfirmasi.php'/> 
      <?php } ?>

      <div class="konfirmasi-page">
      <div class="register" style="padding-top: 20px;">
          <h2 class="login-title">Konfirmasi</h2>
          <form action="" method="post">
            <ul>
              <li class="form">
                <label for="kodeorder">Kode Order</label>
                <input type="text" name="orderid" id="kodeorder" value="<?= $idorder ?>" disabled>
              </li>
              <li class="form">
                <label for="nama">Informasi Pembayaran</label>
                <input type="text" name="nama" id="nama" placeholder="Nama Pemilik Rekening / Sumber Dana" required>
              </li>
              <br>
              <li class="form">
                <label>Rekening Tujuan</label>
                <select name="metode">
                  <?php
                    $metode = mysqli_query($conn,"SELECT * FROM pembayaran");
                    while($a=mysqli_fetch_array($metode)) :
                  ?>
                    <option value="<?= $a['metode'] ?>"><?= $a['metode'] ?> | <?= $a['norek'] ?></option>
                  <?php
                    endwhile;
                  ?>
                </select>
              </li>
              <br>
              <li class="form">
                <label for="tanggal">Tanggal Bayar</label>
                <input type="date" class="form-control" name="tanggal" id="tanggal">
              </li>
              <li style="padding-top: 20px;">
                <input type="submit" name="confirm" class="button-light button-login" value="Kirim">
              </li>
            </ul>
          </form>
        </div>
      </div>
    </main>

    <!--===== FOOTER =====-->
    <footer class="pt-5 pb-4">
      <div class="container text-md-left">
        <div class="footer-top row text-md-left">
          <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
            <h5 class="mb-4 footer_title">Tokoku</h5>
            <p class="footer_description">Produk Baru Gadget di 2021</p>
          </div>
          <div class="footer-product col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
            <h5 class="mb-4">Products</h5>
            <p>
              <a href="product.php?idkategori=1" class="footer_link">Laptop</a>
            </p>
            <p>
              <a href="product.php?idkategori=2" class="footer_link">Phone</a>
            </p>
            <p>
              <a href="product.php?idkategori=3" class="footer_link">Watch</a>
            </p>
          </div>
          <div class="footer-link col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
            <h5 class="mb-4">Link</h5>
            <p>
              <a href="about-us.php" class="footer_link">About Us</a>
            </p>
          </div>
          <div class="footer-contact col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
            <h5 class="mb-4">Contact</h5>
            <p>
              <i class='bx bxs-home me-3'> Semarang</i> 
            </p>
            <p>
              <i class='bx bxs-envelope me-3'> tokoku@gmail.com</i> 
            </p>
            <p>
              <i class='bx bxs-phone me-3'> 081234567890</i>
            </p>
          </div>
        </div>

        <hr class="mb-4">

        <div class="footer-bottom row align-items-center">
          <div class="col-md-7 col-lg-8">
          <p class="footer_description">&copy; <script>document.write(new Date().getFullYear())</script> Kelompok 1, XII RPL 1 </p>
          </div>
          <div class="col-md-5 col-lg-4">
            <ul>
              <li class="list-inline-item">
                <a href="https://www.facebook.com/adrian.m.rafli.9" target="_blank" class="footer_social"><i class='bx bxl-facebook' ></i></a>
              </li>
              <li class="list-inline-item">
                <a href="https://www.instagram.com/adrianrafly_/" target="_blank" class="footer_social"><i class='bx bxl-instagram' ></i></a>
              </li>
              <li class="list-inline-item">
                <a href="https://twitter.com/ianxven" target="_blank" class="footer_social"><i class='bx bxl-twitter' ></i></a>
              </li>
              <li class="list-inline-item">
                <a href="https://github.com/AdrianRafli/project-web-bsd" target="_blank" class="footer_social"><i class='bx bxl-github' ></i></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>

    <!--===== MAIN JS =====-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
