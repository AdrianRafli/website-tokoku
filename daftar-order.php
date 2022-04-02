<?php
  session_start();
  include 'dbconnect.php';

  if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
  }

  $id = $_SESSION['id'];
	$itungtrans = mysqli_query($conn,"SELECT count(orderid) AS jumlahtrans FROM cart WHERE userid='$id' AND status!='Cart'");
	$itungtrans2 = mysqli_fetch_assoc($itungtrans);
	$itungtrans3 = $itungtrans2['jumlahtrans'];
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

    <title>Tokoku | Daftar Order</title>
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

    <main class="cart-page" style="padding-bottom: 50px;">
      <div class="container">
        <h2 class="jumlah-barang">Kamu memiliki <span><?=$itungtrans3 ?> transaksi</h2>

        <div class="table-responsive">
          <table class="table table-bordered">
            <thead class="table-dark">
              <tr>
                <th scope="col">No.</th>
                <th scope="col">Kode Order</th>
                <th scope="col">Tanggal Order</th>
                <th scope="col">Total</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $brg=mysqli_query($conn,"SELECT DISTINCT(idcart), c.orderid, tglorder, status FROM cart c, detailorder d WHERE c.userid='$id' AND d.orderid=c.orderid AND status!='Cart' ORDER BY tglorder DESC");
                $no=1;
                while($b=mysqli_fetch_array($brg)):
              ?>
              <tr>
                <form action="" method="post">
                  <th><?= $no++ ?></th>
                  <td><?= $b['orderid'] ?></td>
                  <td><?= $b['tglorder'] ?></td>
                  <td>
                    <?php 
                      $ongkir = 10000;
                      $ordid = $b['orderid'];
                      $result1 = mysqli_query($conn,"SELECT SUM(qty*hargaafter)+$ongkir AS count FROM detailorder d, produk p WHERE d.orderid='$ordid' AND p.idproduk=d.idproduk ORDER BY d.idproduk ASC");
                      $cekrow = mysqli_num_rows($result1);
                      $row1 = mysqli_fetch_assoc($result1);
                      $count = $row1['count'];
                      if($cekrow > 0){
                    ?>
                      Rp <?= number_format($count); ?>
                    <?php 
                      } else {
                        echo 'No data';
                      }
                    ?>
                  </td>
                  <td>
                    <div class="rem">
                      <?php 
                        if($b['status']=='Payment'){
                          echo '
                          <a href="konfirmasi.php?id='.$b['orderid'].'" class="form-control btn-outline-dark">Konfirmasi Pembayaran</a>';
                        } else if($b['status']=='Diproses'){
                          echo 'Pesanan Diproses (Pembayaran Diterima)';
                        } else if($b['status']=='Dikirim'){
                            echo 'Pesanan Dikirim';
                        } else if($b['status']=='Selesai'){
                            echo 'Pesanan Selesai';
                        } else if($b['status']=='Dibatalkan'){
                            echo 'Pesanan Dibatalkan';
                        } else {
                            echo 'Konfirmasi diterima';
                        }
                      ?>
                    </div>
                    <script>$(document).ready(function(c) {
                      $('.close1').on('click', function(c){
                        $('.rem1').fadeOut('slow', function(c){
                          $('.rem1').remove();
                        });
                        });	  
                      });
                    </script>
                  </td>
                </form>
              </tr>
              <?php endwhile; ?>
            </tbody>
            <!--quantity-->
              <script>
                $('.value-plus').on('click', function(){
                  var divUpd = $(this).parent().find('.value'), newVal = parseInt(divUpd.text(), 10)+1;
                  divUpd.text(newVal);
                });

                $('.value-minus').on('click', function(){
                  var divUpd = $(this).parent().find('.value'), newVal = parseInt(divUpd.text(), 10)-1;
                  if(newVal>=1) divUpd.text(newVal);
                });
              </script>
            <!--quantity-->
          </table>
        </div>
        
      <div class="clearfix"></div>
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
    <script src="vendor/bootstrap//js/bootstrap.bundle.min.js"></script>
  </body>
</html>
