<?php
  session_start();
  include 'dbconnect.php';
  include 'badges.php';

  $s = $_POST['search'];
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

    <title>Tokoku | Product</title>
  </head>
  <body>
    <!--===== HEADER =====-->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light scroll-navbar ">
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
                <li><a class="dropdown-item" href="product.php?idkategori=<?= $p['idkategori'] ?>"><?= $p['namakategori'] ?></a></li>
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
              <input class="form-control me-2" type="search" name="search" placeholder="Cari Nama Barang" aria-label="Search" />
              <button class="btn btn-outline-dark me-2" type="submit">Search</button>
            <?php 
              if(!isset($_SESSION['login'])) {
                echo "<a href='login.php' class='btn btn-outline-dark me-2' type='button'>Login</a>";
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
      <section class="featured section" id="shop">
        <h2 class="section-title">Produk</h2>

        <div class="products">
          <div class="row">
            <div class="products-left col-lg-3 col-md-4">
              <div class="brands rounded">
                <h2>Brands</h2>
                <ul class="list-brands">
                  <?php 
                    $brnd=mysqli_query($conn,"SELECT * from brand order by idbrand ASC");
                    while($p=mysqli_fetch_array($brnd)) :
                  ?>
                    <li>
                      <a href="brand.php?idbrand=<?= $p['idbrand'] ?>"><i class="fas fa-arrow-right button-icon icon-brand"></i><?= $p['namabrand'] ?></a>
                    </li>
                  <?php endwhile; ?>
                </ul>
              </div>
            </div>

            <div class="products-right col-lg-8 col-md-7 col-sm-8">
              <?php 
              	$brgs=mysqli_query($conn,"SELECT p.idproduk, p.idkategori, p.idbrand, p.namaproduk, p.gambar1, p.hargaafter, b.namabrand FROM produk p JOIN brand b USING(idbrand) WHERE p.namaproduk like '%$s%' or b.namabrand like '%$s%' order by idproduk ASC");
                $x = mysqli_num_rows($brgs);

                if ( $x > 0 ) {
                  while($p=mysqli_fetch_array($brgs)) :
              ?>
                <article class="product product-laptop">
                  <div class="product-layout">
                    <?php if ($p['idkategori'] == 1) {?>
                      <a href="display-product.php?idkategori=<?= $p['idkategori'] ?>&idproduk=<?= $p['idproduk'] ?>"><img src="assets/img/produk/<?= $p['gambar1']?>"  alt="Gambar Produk" class="product_img laptop" /></a>
                    <?php } else if ($p['idkategori'] == 2) {?>
                      <a href="display-product.php?idkategori=<?= $p['idkategori'] ?>&idproduk=<?= $p['idproduk'] ?>"><img src="assets/img/produk/<?= $p['gambar1']?>"  alt="Gambar Produk" class="product_img phone" /></a>
                    <?php } else if ($p['idkategori'] == 3) {?>
                      <a href="display-product.php?idkategori=<?= $p['idkategori'] ?>&idproduk=<?= $p['idproduk'] ?>"><img src="assets/img/produk/<?= $p['gambar1']?>"  alt="Gambar Produk" class="product_img watch" /></a>
                    <?php } ?>
                  </div>
                  <span class="product_name"><?= $p["namaproduk"] ?></span>
                  <span class="product_price">Rp <?= number_format($p['hargaafter']) ?></span>
                  <a href="display-product.php?idkategori=<?= $p['idkategori'] ?>&idproduk=<?= $p['idproduk'] ?>" class="button-light">Lihat Produk <i class="fas fa-arrow-right button-icon"></i></a>
                </article>
              <?php
                  endwhile;
                } else {
                  echo "Produk tidak Ditemukan";
                } ?>
            </div>
          </div>
        </div>
      </section>
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
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
