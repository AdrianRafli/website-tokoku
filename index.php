<?php 
  session_start();
  include "dbconnect.php";
  include "badges.php";

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
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css" />

    <!-- ===== FontAwesome ===== -->
    <link href="assets/icon/css/all.css" rel="stylesheet">

    <!-- ===== Bootstrap ===== -->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">

    <title>Tokoku | Belanja Gadget Serba Baru</title>
  </head>
  <body>
    <!--===== HEADER =====-->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light" id="navbar">
      <div class="container-fluid">
        <a class="navbar-brand fs-3" href="./">Tokoku</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active fs-6" href="#">Home</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> Product </a>
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
          <div class="nav-icon me-4">
            <a href="daftar-order.php">
              <i class="fas fa-list-ul me-1"></i>
              <?php if ($orderid !== null && $itungorder3 !== '0') : ?>
                <span class="badge nav-badges rounded-pill bg-danger">
                  <?= $itungorder3 ?>
                <span class="visually-hidden">unseen order</span>
              <?php endif; ?>
            </a>
            <a href="cart.php">
              <i class="fas fa-shopping-cart me-1"></i>
              <?php if ($orderidd !== null && $itungtrans3 !== '0') : ?>
                <span class="badge nav-badges rounded-pill bg-danger">
                  <?= $itungtrans3 ?>
                <span class="visually-hidden">unseen cart</span>
                <?php endif; ?>
            </a>
          </div>
          <form class="d-flex" action="search.php" method="POST">
            <input class="form-control me-2" type="search" name="search" placeholder="Cari Nama Barang" aria-label="Search" />
            <button class="btn btn-outline-dark me-2" type="submit">Search</button>
            <?php 
              if(!isset($_SESSION['login'])) { ?>
                <a   href='login.php' class='btn btn-outline-dark me-2' type='button'>Login</a>
                <?php
              } else {
                if($_SESSION['role']=='member') { ?>
                  <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                      <img src="assets/img/profile/profile.svg" class="width: 100%;" alt="profile picture">
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><a href='logout.php' class='btn btn-outline-dark me-2' type='button'>Logout</a></li>
                    </ul>
                  </div>
                <?php
                } else { ?>
                  <a href='admin' class='btn btn-outline-dark me-2' type='button'>Admin</a>
                  <a href='logout.php' class='btn btn-outline-dark me-2' type='button'>Logout</a>
                  <?php
                }
              }
            ?>
          </form>
        </div>
      </div>
    </nav>

    <main class="main">
      <!--===== HOME =====-->
      <section class="home" id="home">
        <div class="home_container bd-grid">
          <div class="home_product d-flex justify-content-center align-items-center">
            <div class="home_shape"></div>
            <img src="assets/img/Hero.png"  alt="products" class="home_img" />
          </div>

          <div class="home_data">
            <span class="home_new">New in</span>
            <h1 class="home_title">
              GADGET TERBARU <br />
              HARGA TERJANGKAU
            </h1>
            <p class="home_description">Jelajahi Semua Produk Terbaru</p>
            <a href="#category" class="button">Jelajahi Produk</a>
          </div>
        </div>
      </section>

      <!--===== Category =====-->
      <section class="category section" id="category">
        <h2 class="section-title">Category</h2>

        <div class="category_container bd-grid">
          <div class="category_card">
            <div class="category_data">
              <h3 class="category_name">Laptop</h3>
              <p class="category_description">Produk Baru 2021</p>
              <a href="product.php?idkategori=1" class="button-light">Lihat Produk <i class="fas fa-arrow-right button-icon"></i></a>
            </div>

            <a href="product.php?idkategori=1"><img src="assets/img/produk/ROG Flow X13 Depan.png"  alt="category" class="category_img laptop" /></a>
          </div>

          <div class="category_card">
            <div class="category_data">
              <h3 class="category_name">Phone</h3>
              <p class="category_description">Produk Baru 2021</p>
              <a href="product.php?idkategori=2" class="button-light">Lihat Produk <i class="fas fa-arrow-right button-icon"></i></a>
            </div>

            <a href="product.php?idkategori=2"><img src="assets/img/produk/noteOnyx Gray.png"  alt="category" class="category_img phone-home" /></a>
          </div>

          <div class="category_card">
            <div class="category_data">
              <h3 class="category_name">Watch</h3>
              <p class="category_description">Produk Baru 2021</p>
              <a href="product.php?idkategori=3" class="button-light">Lihat Produk <i class="fas fa-arrow-right button-icon"></i></a>
            </div>

            <a href="product.php?idkategori=3"><img src="assets/img/produk/Mi Watch.png"  alt="category" class="category_img watch-home" /></a>
          </div>
        </div>
      </section>

      <!--===== FEATURED =====-->
      <section class="featured section" id="featured">
        <h2 class="section-title">Featured</h2>

        <div class="featured_container bd-grid">
          <article class="product-home ">
            <div class="product_sale">Sale</div>
            <div class="product-layout">
              <a href="display-product.php?idkategori=1&idproduk=7"><img src="assets/img/produk/ROG Flow X13 Belakang.png"  alt="Featured 1" class="product_img laptop" /></a>
            </div>
            <span class="product_name">ROG Flow X13 GV301</span>
            <span class="product_price">Rp 27.499.000</span>
            <a href="display-product.php?idkategori=1&idproduk=7" class="button-light">Lihat Produk <i class="fas fa-arrow-right button-icon"></i></a>
          </article>

          <article class="product-home">
            <div class="product_sale">Sale</div>
            <div class="product-layout">
              <a href="display-product.php?idkategori=1&idproduk=10"><img src="assets/img/produk/Zenbook Pro Belakang.png"  alt="Featured 1" class="product_img laptop" /></a>
            </div>
            <span class="product_name">Zenbook Pro Duo</span>
            <span class="product_price">Rp 41.499.000</span>
            <a href="display-product.php?idkategori=1&idproduk=10" class="button-light">Lihat Produk <i class="fas fa-arrow-right button-icon"></i></a>
          </article>

          <article class="product-home">
            <div class="product_sale">Sale</div>
            <div class="product-layout">
              <a href="display-product.php?idkategori=1&idproduk=12"><img src="assets/img/produk/Vivobook 14 M413 Belakang.png"  alt="Featured 1" class="product_img laptop" /></a>
            </div>
            <span class="product_name">Vivobook 14 M413</span>
            <span class="product_price">Rp 11.399.000</span>
            <a href="display-product.php?idkategori=1&idproduk=12" class="button-light">Lihat Produk <i class="fas fa-arrow-right button-icon"></i></a>
          </article>
        </div>
      </section>

      <!--===== Best Seller =====-->
      <section class="best-seller section" id="best-seller">
        <h2 class="section-title">Best Seller</h2>
        
        <div class="best-seller_container bd-grid">
          <article class="product-home">
            <div class="product-layout">
              <a href="display-product.php?idkategori=1&idproduk=13"><img src="assets/img/produk/Ideapad S340 Depan.png"  alt="Featured 1" class="product_img laptop" /></a>
            </div>
            <span class="product_name">Ideapad S340</span>
            <span class="product_price">Rp 8.099.000</span>
            <a href="display-product.php?idkategori=1&idproduk=13" class="button-light">Lihat Produk <i class="fas fa-arrow-right button-icon"></i></a>
          </article>
          <article class="product-home">
            <div class="product-layout">
              <a href="display-product.php?idkategori=1&idproduk=12"><img src="assets/img/produk/Vivobook 14 M413 Depan.png"  alt="Featured 1" class="product_img laptop" /></a>
            </div>
            <span class="product_name">VivoBook 14 M413</span>
            <span class="product_price">Rp 11.399.000</span>
            <a href="display-product.php?idkategori=1&idproduk=12" class="button-light">Lihat Produk <i class="fas fa-arrow-right button-icon"></i></a>
          </article>
          <article class="product-home">
            <div class="product-layout">
              <a href="display-product.php?idkategori=1&idproduk=10"><img src="assets/img/produk/Zenbook Pro Depan.png"  alt="Featured 1" class="product_img laptop" /></a>
            </div>
            <span class="product_name">Zenbook Pro Duo</span>
            <span class="product_price">Rp 41.499.000</span>
            <a href="display-product.php?idkategori=1&idproduk=10" class="button-light">Lihat Produk <i class="fas fa-arrow-right button-icon"></i></a>
          </article>
        </div>
      </section>

      <!--===== OFFER =====-->
      <section class="offer section">
        <div class="offer_container bd-grid">
          <div class="offer_data">
            <h3 class="offer_title">15%</h3>
            <p class="offer_description">Semua Produk Xiaomi</p>
            <a href="brand.php?idbrand=5" class="button-light">Lihat Produk</a>
          </div>

          <img src="assets/img/produk/mi11Horizon Blue.png"  alt="offer" class="offer_img phone-home" />
        </div>
      </section>

      <!--===== New Product =====-->
      <section class="new section" id="new">
        <h2 class="section-title">Produk Baru</h2>

        <div class="new_container bd-grid">
          <div class="new_mens">
            <img src="assets/img/produk/Mi Smart Band 5.png"  alt="New" class="new_img watch-home" />
            <h3 class="new_title">Mi Band 5</h3>
            <span class="new_price">Mulai dari Rp 400.000</span>
            <a href="display-product.php?idkategori=3&idproduk=25" class="button-light">Lihat Produk <i class="fas fa-arrow-right button-icon"></i></a>
          </div>

          <div class="new_product">
            <div class="new_product-card">
              <img src="assets/img/produk/Realme Watch.png"  alt="New" class="new_mens-img watch" />
              <div class="new_product-overlay">
                <a href="display-product.php?idkategori=3&idproduk=29" class="button">Lihat Produk</a>
              </div>
            </div>

            <div class="new_product-card">
              <img src="assets/img/produk/realmeBlack.png"  alt="New" class="new_mens-img" width="70px" />
              <div class="new_product-overlay">
                <a href="display-product.php?idkategori=3&idproduk=28" class="button">Lihat Produk</a>
              </div>
            </div>

            <div class="new_product-card">
              <img src="assets/img/produk/pocoPhantom Black.png"  alt="New" class="new_mens-img phone-home" />
              <div class="new_product-overlay">
                <a href="display-product.php?idkategori=2&idproduk=23" class="button">Lihat Produk</a>
              </div>
            </div>

            <div class="new_product-card">
              <img src="assets/img/produk/mi11Midnight Gray.png"  alt="New" class="new_mens-img phone-home" />
              <div class="new_product-overlay">
                <a href="display-product.php?idkategori=2&idproduk=22" class="button">Lihat Produk</a>
              </div>
            </div>

            <div class="new_product-card">
              <img src="assets/img/produk/mi11Horizon Blue.png"  alt="New" class="new_mens-img phone-home" />
              <div class="new_product-overlay">
                <a href="display-product.php?idkategori=2&idproduk=22" class="button">Lihat Produk</a>
              </div>
            </div>

            <div class="new_product-card">
              <img src="assets/img/produk/noteGlacier Blue.png"  alt="New" class="new_mens-img phone-home" />
              <div class="new_product-overlay">
                <a href="display-product.php?idkategori=2&idproduk=24" class="button">Lihat Produk</a>
              </div>
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
            <p>Produk Baru Gadget di 2021</p>
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
            <p class="footer_description">&copy; <script>document.write(new Date().getFullYear())</script> Kelompok 2, XII RPL 1 </p>
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

    <!--===== JavaScript =====-->
    <script src="assets/js/homeHeader.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
