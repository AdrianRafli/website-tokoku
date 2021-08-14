<?php
  session_start();
  include 'dbconnect.php';

  $idb = $_GET['idbrand'];
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

    <title>Tokoku | Product</title>
  </head>
  <body>
    <!--===== HEADER =====-->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light scroll-navbar ">
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
                  $kat=mysqli_query($conn,"SELECT * from kategori order by idkategori ASC");
                  while($p=mysqli_fetch_array($kat)) :
                ?>
                <li><a class="dropdown-item" href="product.php?idkategori=<?= $p['idkategori'] ?>"><?= $p['namakategori'] ?></a></li>
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
      <section class="featured section" id="shop">
        <h2 class="section-title">Produk</h2>

        <div class="products">
          <div class="row">
            <div class="col-3">
              <div class="brands rounded">
                <h2>Brands</h2>
                <ul class="list-brands">
                  <?php 
                    $brnd=mysqli_query($conn,"SELECT * from brand order by idbrand ASC");
                    while($p=mysqli_fetch_array($brnd)) :
                  ?>
                    <li>
                      <a href="brand.php?idbrand=<?= $p['idbrand'] ?>"><i class="bx bx-right-arrow-alt button-icon icon-brand"><?= $p['namabrand'] ?></i></a>
                    </li>
                  <?php endwhile; ?>
                </ul>
              </div>
            </div>

            <div class="col-sm products-right">
              <?php 
              	$brgs=mysqli_query($conn,"SELECT * FROM produk WHERE idbrand='$idb' ORDER BY idbrand ASC");
                $x = mysqli_num_rows($brgs);

                if ( $x > 0 ) {
                  while($p=mysqli_fetch_array($brgs)) :
              ?>
                <article class="product product-laptop">
                  <div class="product-layout">
                    <?php if ($p['idkategori'] == 1) {?>
                      <a href="display-product.php?idkategori=<?= $p['idkategori'] ?>&idproduk=<?= $p['idproduk'] ?>"><img src="<?= $p['gambar']?>" alt="Gambar Produk" class="product_img laptop" /></a>
                    <?php } else if ($p['idkategori'] == 2) {?>
                      <a href="display-product.php?idkategori=<?= $p['idkategori'] ?>&idproduk=<?= $p['idproduk'] ?>"><img src="<?= $p['gambar']?>" alt="Gambar Produk" class="product_img phone" /></a>
                    <?php } else if ($p['idkategori'] == 3) {?>
                      <a href="display-product.php?idkategori=<?= $p['idkategori'] ?>&idproduk=<?= $p['idproduk'] ?>"><img src="<?= $p['gambar']?>" alt="Gambar Produk" class="product_img watch" /></a>
                    <?php } ?>
                  </div>
                  <span class="product_name"><?= $p["namaproduk"] ?></span>
                  <span class="product_price">Rp <?php echo number_format($p['hargaafter']) ?></span>
                  <a href="display-product.php?idkategori=<?= $p['idkategori'] ?>&idproduk=<?= $p['idproduk'] ?>" class="button-light">Lihat Produk <i class="bx bx-right-arrow-alt button-icon"></i></a>
                </article>
              <?php
                endwhile;
              } else {
                echo "Data tidak Ditemukan";
              } ?>
            </div>
          </div>
        </div>
      </section>
    </main>

    <!--===== FOOTER =====-->
    <footer class="footer section">
      <div class="footer_container bd-grid">
        <div class="footer_box">
          <h3 class="footer_title">Tokoku</h3>
          <p class="footer_description">New collection of shoes 2021</p>
        </div>

        <div class="footer_box">
          <h3 class="footer_title ms-4">Explore</h3>
          <ul>
            <li><a href="#" class="footer_link">Home</a></li>
            <li><a href="#" class="footer_link">Featured</a></li>
            <li><a href="#" class="footer_link">Women</a></li>
            <li><a href="#" class="footer_link">New</a></li>
          </ul>
        </div>

        <div class="footer_box">
          <h3 class="footer_title ms-4">Support</h3>
          <ul>
            <li><a href="#" class="footer_link">Product Help</a></li>
            <li><a href="#" class="footer_link">Customer Care</a></li>
            <li><a href="#" class="footer_link">Authorized Service</a></li>
          </ul>
        </div>

        <div class="footer_box">
          <a href="#" class="footer_social"><i class="bx bxl-facebook"></i></a>
          <a href="#" class="footer_social"><i class="bx bxl-instagram"></i></a>
          <a href="#" class="footer_social"><i class="bx bxl-twitter"></i></a>
        </div>
      </div>

      <p class="footer_copy">&#169; 2021 Kelompok 1. XII RPL 1</p>
    </footer>

    <!--===== MAIN JS =====-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
