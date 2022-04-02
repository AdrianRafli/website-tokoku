<?php
  session_start();
  include "dbconnect.php";
  include "badges.php";

  $idk = $_GET['idkategori'];
  $idp = $_GET['idproduk'];

  if(isset($_POST['addprod'])){
    if (!isset($_SESSION["login"])) {
      header("Location: login.php");
    } else {
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
  }
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/img/favicon/site.webmanifest">

    <!-- ===== CSS ===== -->
    <link rel="stylesheet" href="assets/css/styles.css" />

    <!-- ===== FontAwesome ===== -->
    <link href="assets/icon/css/all.css" rel="stylesheet">

    <!-- ===== Bootstrap ===== -->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">

    <?php 
      $produk = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM produk WHERE idkategori='$idk' AND idproduk='$idp'"));
    ?>
    <title>Tokoku | <?= $produk["namaproduk"] ?></title>
  </head>
  <body>
    <!--===== HEADER =====-->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light scroll-navbar">
      <div class="container-fluid">
        <a class="navbar-brand fs-3" href="./">Tokoku</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link fs-6" href="./">Home</a>
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
          <div class="nav-icon">
            <a href="daftar-order.php">
              <i class="fas fa-list-ul nav-icon me-1"></i>
              <?php if ($orderid !== null && $itungorder3 !== '0') : ?>
                <span class="badge nav-badges rounded-pill bg-danger">
                  <?= $itungorder3 ?>
                <span class="visually-hidden">unseen order</span>
              <?php endif; ?>
            </a>
            <a href="cart.php">
              <i class="fas fa-shopping-cart nav-icon me-1"></i>
              <?php if ($orderidd !== null && $itungtrans3 !== '0') : ?>
                <span class="badge nav-badges rounded-pill bg-danger">
                  <?= $itungtrans3 ?>
                <span class="visually-hidden">unseen cart</span>
                <?php endif; ?>
            </a>
          </div>
          <form class="d-flex" action="search.php" method="post">
              <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search" />
              <button class="btn btn-outline-dark me-2" type="submit">Search</button>
            <?php 
              if(!isset($_SESSION['login'])) {
                echo "<a   href='login.php' class='btn btn-outline-dark me-2' type='button'>Login</a>";
              } else {
                if($_SESSION['role']=='member') {
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
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
          Berhasil menambahkan ke keranjang
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          <meta http-equiv='refresh' content='2; url= display-product.php?idkategori=<?= $idk ?>&idproduk=<?= $idp ?>'/>  

        </div>
      <?php } else if (isset($tambah)) { ?>
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
          Barang sudah dimasukkan ke keranjang, jumlah akan ditambahkan
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          <meta http-equiv='refresh' content='2; url= display-product.php?idkategori=<?= $idk ?>&idproduk=<?= $idp ?>'/>  
        </div>
      <?php } else if (isset($error)) { ?>
        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
          Gagal menambahkan ke keranjang
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php } ?>


      <div class="display-product row">
        <?php
         $produk = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM produk WHERE idkategori='$idk' AND idproduk='$idp'"));
        ?>
          <div class="display-image col-lg-5 col-sm-5 col-md-12">
            <div class="border-product border border-2 rounded" id="magnifying_area">
              <?php if ( $idk == 1 ) { ?>
                <img src="assets/img/produk/<?= $produk['gambar1']?>" alt="" class="image-product-laptop" id="featured" />
              <?php } else if ( $idk == 2 ) { ?>
                <img src="assets/img/produk/<?= $produk['gambar1']?>" alt="" class="image-product-phone" id="featured"/>
              <?php } else if ( $idk == 3 ) { ?>
                <img src="assets/img/produk/<?= $produk['gambar1']?>" alt="" class="image-product-watch" id="featured"/>
              <?php } ?>
            </div>
            <div class="thumbnails">
              <img class="thumbnail border border-2 rounded thumb-active" src="assets/img/produk/<?= $produk['gambar1']?>" alt="">
              <img class="thumbnail border border-2 rounded" src="assets/img/produk/<?= $produk['gambar2']?>" alt="">
              <img class="thumbnail border border-2 rounded" src="assets/img/produk/<?= $produk['gambar3']?>" alt="">
            </div>
          </div>
          
          <div class="display-spec col-lg-4 col-sm-5 col-md-12">
            <h2 class="display-product-name"><?= $produk["namaproduk"] ?></h2>
            <h3 class="display-product-price">Rp <?= number_format($produk['hargaafter']) ?><span>Rp <?= number_format($produk['hargabefore']) ?></span></h3>
            <form action="" method="post">
              <fieldset>
                <input type="hidden" name="idprod" value="<?= $idp ?>">
                <?php 
                if($_SESSION['role']=='admin') {
                  echo "<input type='submit' name='addprod' value='Add to cart' class='button-light' style='opacity: 0.5;' disabled>";
                } else {
                  echo "<input type='submit' name='addprod' value='Add to cart' class='button-light'>";
                }
              ?>
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
              <i class='fas fa-home me-3'> </i> Semarang
            </p>
            <p>
              <i class='fas fa-envelope me-3'> </i> tokoku@gmail.com
            </p>
            <p>
              <i class='fas fa-phone me-3'> </i> 081234567890
            </p>
          </div>
        </div>

        <hr class="mb-4">

        <div class="footer-bottom row align-items-center">
        <div class="col-sm-12 col-lg-8">
            <p class="footer_description">&copy; <script>document.write(new Date().getFullYear())</script> Kelompok 1, XII RPL 1 </p>
          </div>
          <div class="col-sm-12 col-lg-4">
            <ul class="d-flex justify-content-center">
              <li class="list-inline-item">
                <a href="https://www.facebook.com/adrian.m.rafli.9" target="_blank" class="footer_social"><i class="fab fa-facebook-f"></i></a>
              </li>
              <li class="list-inline-item">
                <a href="https://www.instagram.com/adrianrafly_/" target="_blank" class="footer_social"><i class="fab fa-instagram"></i></a>
              </li>
              <li class="list-inline-item">
                <a href="https://twitter.com/ianxven" target="_blank" class="footer_social"><i class="fab fa-twitter"></i></a>
              </li>
              <li class="list-inline-item">
                <a href="https://github.com/AdrianRafli/project-web-bsd" target="_blank" class="footer_social"><i class="fab fa-github"></i></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>

    <!--===== MAIN JS =====-->
    <script src="assets/js/thumbnail.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
