<?php
  session_start();
  include "dbconnect.php";

  $idk = $_GET['idkategori'];
  $idp = $_GET['idproduk'];

  if(isset($_POST['addprod'])){
    
    $ui = $_SESSION['id'];
    $cek = mysqli_query($conn,"SELECT * FROM cart WHERE userid='$ui' AND STATUS='Cart'");
    $liat = mysqli_num_rows($cek);
    $f = mysqli_fetch_array($cek);
    $orid = $f['orderid'];
          
    //kalo ternyata udeh ada order id nya
    if($liat>0){
                
      //cek barang serupa
      $cekbrg = mysqli_query($conn,"SELECT * FROM detailorder WHERE idproduk='$idp' AND orderid='$orid'");
      $liatlg = mysqli_num_rows($cekbrg);
      $brpbanyak = mysqli_fetch_array($cekbrg);
      $jmlh = $brpbanyak['qty'];
                
        //kalo ternyata barangnya ud ada
        if($liatlg>0){
        $i=1;
        $baru = $jmlh + $i;
                  
          $updateaja = mysqli_query($conn,"UPDATE detailorder SET qty='$baru' WHERE orderid='$orid' AND idproduk='$idp'");
                    
            if($updateaja){
              $tambah = true;
            } else {
              $error = true;
            }
          } else {
            $tambahdata = mysqli_query($conn,"INSERT INTO detailorder (orderid,idproduk,qty) VALUES('$orid','$idp','1')");
            if ($tambahdata){
              $berhasil = true;
            } else { 
              $error = true;
            }
        };
    } else {
      //kalo belom ada order id nya
      $oi = crypt(rand(22,999),time());
              
      $bikincart = mysqli_query($conn,"INSERT INTO cart (orderid, userid) VALUES('$oi','$ui')");
      if($bikincart){
        $tambahuser = mysqli_query($conn,"INSERT INTO detailorder (orderid,idproduk,qty) VALUES('$oi','$idp','1')");
        if ($tambahuser){
          $berhasil = true;
        } else { 
          $error = true;
          }
      } else {
        echo "gagal bikin cart";
      }
    }
  }
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

    <!-- ===== SweetAlert 2 ===== -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


    <?php 
      $produk = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM produk WHERE idkategori='$idk' AND idproduk='$idp'"));
    ?>
    <title>Tokoku | <?= $produk["namaproduk"] ?></title>
  </head>
  <body>
    <!--===== HEADER =====-->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light scroll-navbar">
      <div class="container-fluid">
        <a class="navbar-brand fs-3" href="#">Tokoku</a>
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
                  $kat=mysqli_query($conn,"SELECT * from kategori order by idkategori ASC");
                  while($p=mysqli_fetch_array($kat)) :
                ?>
                <li><a class="dropdown-item" href="product.php?idkategori=<?= $p['idkategori'] ?>"><?php echo $p['namakategori'] ?></a></li>
                <?php endwhile; ?>
              </ul>
            </li>
          </ul>
          <form class="d-flex" action="search.php" method="post">
            <a href="daftar-order.php" class="nav-icon">
              <i class="bx bx-history button-icon me-1"></i>
            </a>
            <a href="cart.php" class="nav-icon">
              <i class="bx bxs-cart button-icon me-3"></i>
            </a>
              <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search" />
              <button class="btn btn-outline-dark me-2" type="submit">Search</button>
            <?php 
              if(isset($_SESSION['login'])) {
                echo "<a href='logout.php' class='btn btn-outline-dark me-2' type='button'>Logout</a>";
              } else {
                echo "<a href='login.php' class='btn btn-outline-dark me-2' type='button'>Login</a>";
              }
            ?>
          </form>
        </div>
      </div>
    </nav>

    <main class="main">

      <?php if (isset($berhasil)) { ?>
        <div class='alert alert-success' style="margin-top: 7px !important;">
          Berhasil menambahkan ke keranjang
        </div>
        <meta http-equiv='refresh' content='2; url= display-product.php?idkategori=<?= $idk ?>&idproduk=<?= $idp ?>'/>  
      <?php } else if (isset($tambah)) { ?>
        <div class='alert alert-success' >
          Barang sudah dimasukkan ke keranjang, jumlah akan ditambahkan
        </div>
        <meta http-equiv='refresh' content='2; url= display-product.php?idkategori=<?= $idk ?>&idproduk=<?= $idp ?>'/>
      <?php } else if (isset($error)) { ?>
        <div class='alert alert-warning' >
          Gagal menambahkan ke keranjang
        </div>
        <meta http-equiv='refresh' content='2; url= display-product.php?idkategori=<?= $idk ?>&idproduk=<?= $idp ?>'/>
      <?php } ?>


      <div class="display-product row">
        <?php
         $produk = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM produk WHERE idkategori='$idk' AND idproduk='$idp'"));
        ?>
          <div class="display-image col-sm-5">
            <div class="border-product border border-2 rounded" id="magnifying_area">
              <?php if ( $idk == 1 ) { ?>
                <img src="<?= $produk['gambar1']?>" alt="" class="image-product-laptop" id="featured" />
              <?php } else if ( $idk == 2 ) { ?>
                <img src="<?= $produk['gambar1']?>" alt="" class="image-product-phone" id="featured"/>
              <?php } else if ( $idk == 3 ) { ?>
                <img src="<?= $produk['gambar1']?>" alt="" class="image-product-watch" id="featured"/>
              <?php } ?>
            </div>
            <div class="thumbnails">
              <img class="thumbnail border border-2 rounded thumb-active" src="<?= $produk['gambar1']?>" alt="">
              <img class="thumbnail border border-2 rounded" src="<?= $produk['gambar2']?>" alt="">
              <img class="thumbnail border border-2 rounded" src="<?= $produk['gambar3']?>" alt="">
            </div>
          </div>
          
          <div class="display-spec col-sm-5">
            <h2 class="display-product-name"><?= $produk["namaproduk"] ?></h2>
            <h3 class="display-product-price">Rp <?= number_format($produk['hargaafter']) ?><span>Rp <?= number_format($produk['hargabefore']) ?></span></h3>
            <form action="" method="post">
              <fieldset>
                <input type="hidden" name="idprod" value="<?= $idp ?>">
                <input type="submit" name="addprod" value="Add to cart" class="button-light">
              </fieldset>
            </form>
            <p class="product-description">
              <span>Description :</span> <br />
              <?= $produk["deskripsi"] ?>
            </p>
          </div>
      </div>
    </main>

    <!--===== FOOTER =====-->
    <footer class="footer container">
      <div class="row">
        <div class="footer_box col">
          <h3 class="footer_title">Tokoku</h3>
          <p class="footer_description">Produk Baru Gadget di 2021</p>
        </div>

        <div class="footer_box col">
          <h3 class="footer_title">Explore</h3>
          <ul>
            <li><a href="#" class="footer_link">Home</a></li>
            <li><a href="product.php?idkategori=1" class="footer_link">Laptop</a></li>
            <li><a href="product.php?idkategori=2" class="footer_link">Phone</a></li>
            <li><a href="product.php?idkategori=3" class="footer_link">Watch</a></li>
          </ul>
        </div>

        <div class="footer_box col">
          <a href="https://www.facebook.com/adrian.m.rafli.9" target="_blank" class="footer_social"><i class="bx bxl-facebook"></i></a>
          <a href="https://www.instagram.com/adrianrafly_/" target="_blank" class="footer_social"><i class="bx bxl-instagram"></i></a>
          <a href="https://twitter.com/ianxven" target="_blank" class="footer_social"><i class="bx bxl-twitter"></i></a>
        </div>
      </div>

      <p class="footer_copy">&#169; 2021 Kelompok 1. XII RPL 1</p>
    </footer>

    <!--===== MAIN JS =====-->
    <script src="assets/js/thumbnail.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
