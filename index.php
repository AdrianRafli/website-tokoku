<?php 
  include "dbconnect.php";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- ===== CSS ===== -->
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css" />

    <!-- ===== BOX ICONS ===== -->
    <link href="https://unpkg.com/boxicons@2.0.8/css/boxicons.min.css" rel="stylesheet" />

    <!-- ===== Bootstrap ===== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <title>Tokoku | Belanja Gadget Serba Baru</title>
  </head>
  <body>
    <!--===== HEADER =====-->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light" id="navbar">
      <div class="container-fluid">
        <a class="navbar-brand fs-3" href="index.html">Tokoku</a>
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
          <form class="d-flex">
            <a href="daftar-order.html" class="nav-icon">
              <i class="bx bx-history button-icon me-1"></i>
            </a>
            <a href="cart.html" class="nav-icon">
              <i class="bx bxs-cart button-icon me-3"></i>
            </a>
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
            <a class="btn btn-outline-dark me-2" type="submit">Search</a>
            <a href="login.html" class="btn btn-outline-dark me-2" type="button">Login</a>
          </form>
        </div>
      </div>
    </nav>

    <main class="main">
      <!--===== HOME =====-->
      <section class="home" id="home">
        <div class="home_container bd-grid">
          <div class="home_product">
            <div class="home_shape"></div>
            <img src="assets/img/Hero.png" alt="products" class="home_img" />
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
              <a href="product-laptop.html" class="button-light">Lihat Produk <i class="bx bx-right-arrow-alt button-icon"></i></a>
            </div>

            <img src="assets/img/Laptop/Lenovo/Yoga/Yoga Slim 9I/Yoga Slim 9I Belakang.png" alt="category" class="category_img laptop" />
          </div>

          <div class="category_card">
            <div class="category_data">
              <h3 class="category_name">Phone</h3>
              <p class="category_description">Produk Baru 2021</p>
              <a href="product-phone.html" class="button-light">Lihat Produk <i class="bx bx-right-arrow-alt button-icon"></i></a>
            </div>

            <img src="assets/img/Phone/Xiaomi/Redmi Note 10 Pro/Onyx Gray.png" alt="category" class="category_img phone" />
          </div>

          <div class="category_card">
            <div class="category_data">
              <h3 class="category_name">Watch</h3>
              <p class="category_description">Produk Baru 2021</p>
              <a href="product-watch.html" class="button-light">Lihat Produk <i class="bx bx-right-arrow-alt button-icon"></i></a>
            </div>

            <img src="assets/img/Watch/Mi Watch/Mi Watch.png" alt="category" class="category_img watch-home" />
          </div>
        </div>
      </section>

      <!--===== FEATURED =====-->
      <section class="featured section" id="featured">
        <h2 class="section-title">Featured</h2>

        <div class="featured_container bd-grid">
          <article class="product product-home">
            <div class="product_sale">Sale</div>
            <div class="product-layout">
              <img src="assets/img/Laptop/Asus/ROG/ROG Flow X13 GV301/ROG Flow X13 Belakang.png" alt="Featured 1" class="product_img laptop" />
            </div>
            <span class="product_name">ROG Flow 13</span>
            <span class="product_price">Rp 30.000.000</span>
            <a href="display-product.php" class="button-light">Lihat Produk <i class="bx bx-right-arrow-alt button-icon"></i></a>
          </article>

          <article class="product product-home">
            <div class="product_sale">Sale</div>
            <div class="product-layout"><img src="assets/img/Laptop/Asus/Zenbook/Zenbook Pro Duo 15' Oled/Zenbook Pro Belakang.png" alt="Featured 1" class="product_img laptop" /></div>
            <span class="product_name">Zenbook Pro Duo</span>
            <span class="product_price">Rp 20.000.000</span>
            <a href="#" class="button-light">Lihat Produk <i class="bx bx-right-arrow-alt button-icon"></i></a>
          </article>

          <article class="product product-home">
            <div class="product_sale">Sale</div>
            <div class="product-layout">
              <img src="assets/img/Laptop/Asus/Vivobook/Vivobook 14 (M413 AMD Ryzen 5000 Series)/Vivobook 14 M413 Belakang.png" alt="Featured 1" class="product_img laptop" />
            </div>
            <span class="product_name">Vivobook 14</span>
            <span class="product_price">Rp 10.000.000</span>
            <a href="#" class="button-light">Lihat Produk <i class="bx bx-right-arrow-alt button-icon"></i></a>
          </article>
        </div>
      </section>

      <!--===== Best Seller =====-->
      <section class="best-seller section" id="best-seller">
        <h2 class="section-title">Best Seller</h2>

        <div class="best-seller_container bd-grid">
          <article class="product product-home">
            <div class="product-layout">
              <img src="assets/img/Laptop/Lenovo/Ideapad/Ideapad S340/Ideapad S340 Depan.png" alt="Featured 1" class="product_img laptop" />
            </div>
            <span class="product_name">Ideapad S340</span>
            <span class="product_price">Rp 8.500.000</span>
            <a href="#" class="button-light">Lihat Produk <i class="bx bx-right-arrow-alt button-icon"></i></a>
          </article>
          <article class="product product-home">
            <div class="product-layout">
              <img src="assets/img/Laptop/Asus/Vivobook/Vivobook 14 (M413 AMD Ryzen 5000 Series)/Vivobook 14 M413 Depan.png" alt="Featured 1" class="product_img laptop" />
            </div>
            <span class="product_name">VivoBook 14</span>
            <span class="product_price">Rp 10.500.000</span>
            <a href="#" class="button-light">Lihat Produk <i class="bx bx-right-arrow-alt button-icon"></i></a>
          </article>
          <article class="product product-home">
            <div class="product-layout">
              <img src="assets/img/Laptop/Asus/Zenbook/Zenbook Pro Duo 15' Oled/Zenbook Pro Depan.png" alt="Featured 1" class="product_img laptop" />
            </div>
            <span class="product_name">Zenbook Pro</span>
            <span class="product_price">Rp 18.500.000</span>
            <a href="#" class="button-light">Lihat Produk <i class="bx bx-right-arrow-alt button-icon"></i></a>
          </article>
        </div>
      </section>

      <!--===== OFFER =====-->
      <section class="offer section">
        <div class="offer_container bd-grid">
          <div class="offer_data">
            <h3 class="offer_title">15%</h3>
            <p class="offer_description">Semua Produk Xiaomi</p>
            <a href="#" class="button-light">Lihat Produk</a>
          </div>

          <img src="assets/img/Phone/Xiaomi/MI 11 Ultra/Horizon Blue.png" alt="offer" class="offer_img phone" />
        </div>
      </section>

      <!--===== New Product =====-->
      <section class="new section" id="new">
        <h2 class="section-title">Produk Baru</h2>

        <div class="new_container bd-grid">
          <div class="new_mens">
            <img src="assets/img/Watch/Mi Smart Band 5/Mi Smart Band 5.png" alt="New" class="new_img watch-home" />
            <h3 class="new_title">Mi Band 5</h3>
            <span class="new_price">Mulai dari Rp 800.000</span>
            <a href="#" class="button-light">Lihat Produk <i class="bx bx-right-arrow-alt button-icon"></i></a>
          </div>

          <div class="new_product">
            <div class="new_product-card">
              <img src="assets/img/Watch/Realme Watch/Realme Watch.png" alt="New" class="new_mens-img watch" />
              <div class="new_product-overlay">
                <a href="#" class="button">Lihat Produk</a>
              </div>
            </div>

            <div class="new_product-card">
              <img src="assets/img/Watch/Realme Watch Pro 2/Black.png" alt="New" class="new_mens-img" width="70px" />
              <div class="new_product-overlay">
                <a href="#" class="button">Lihat Produk</a>
              </div>
            </div>

            <div class="new_product-card">
              <img src="assets/img/Phone/Xiaomi/Poco X3 Pro/Phantom Black.png" alt="New" class="new_mens-img phone-home" />
              <div class="new_product-overlay">
                <a href="#" class="button">Lihat Produk</a>
              </div>
            </div>

            <div class="new_product-card">
              <img src="assets/img/Phone/Xiaomi/MI 11 Ultra/Midnight Gray.png" alt="New" class="new_mens-img phone-home" />
              <div class="new_product-overlay">
                <a href="#" class="button">Lihat Produk</a>
              </div>
            </div>

            <div class="new_product-card">
              <img src="assets/img/Phone/Xiaomi/MI 11 Ultra/Horizon Blue.png" alt="New" class="new_mens-img phone-home" />
              <div class="new_product-overlay">
                <a href="#" class="button">Lihat Produk</a>
              </div>
            </div>

            <div class="new_product-card">
              <img src="assets/img/Phone/Xiaomi/Redmi Note 10 Pro/Glacier Blue.png" alt="New" class="new_mens-img phone-home" />
              <div class="new_product-overlay">
                <a href="#" class="button">Lihat Produk</a>
              </div>
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
          <p class="footer_description">Produk Baru Gadget di 2021</p>
        </div>

        <div class="footer_box">
          <h3 class="footer_title ms-4">Explore</h3>
          <ul>
            <li><a href="#" class="footer_link">Home</a></li>
            <li><a href="./product.html" class="footer_link">Product</a></li>
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
    <!--===== JavaScript =====-->
    <script src="assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>