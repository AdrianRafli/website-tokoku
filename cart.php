<?php 
  session_start();
  include 'dbconnect.php';

  if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
  }

    $uid = $_SESSION['id'];
    $caricart = mysqli_query($conn,"SELECT * FROM cart WHERE userid='$uid' AND status='Cart'");
    $fetc = mysqli_fetch_array($caricart);
    $orderidd = $fetc['orderid'];
    $itungtrans = mysqli_query($conn,"SELECT count(detailid) AS jumlahtrans FROM detailorder WHERE orderid='$orderidd'");
    $itungtrans2 = mysqli_fetch_assoc($itungtrans);
    $itungtrans3 = $itungtrans2['jumlahtrans'];
    
  if (isset($_POST["update"])) {
    $kode = $_POST['idproduknya'];
    $jumlah = $_POST['jumlah'];
    $q1 = mysqli_query($conn, "UPDATE detailorder set qty='$jumlah' where idproduk='$kode' and orderid='$orderidd'");
    if($q1){
      echo "Berhasil Update Cart
      <meta http-equiv='refresh' content='2; url= cart.php'/>";
    } else {
      echo "Gagal update cart
      <meta http-equiv='refresh' content='2; url= cart.php'/>";
    }
  } else if(isset($_POST["hapus"])) {
    $kode = $_POST['idproduknya'];
    $q2 = mysqli_query($conn, "DELETE from detailorder where idproduk='$kode' and orderid='$orderidd'");
    if($q2){
      echo "Berhasil Hapus";
    } else {
      echo "Gagal Hapus";
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

    <title>Tokoku | Cart</title>
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
                  <li><a class="dropdown-item" href="product.php?idkategori=<?= $p['idkategori'] ?>"><?= $p['namakategori'] ?></a></li>
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

    <main class="cart-page">
      <div class="container">
        <h2 class="jumlah-barang">Dalam Keranjangmu ada : <span><?= $itungtrans3 ?> barang</span></h2>

        <div class="table-responsive">
          <table class="table table-bordered" width="80">
            <thead class="table-dark">
              <tr>
                <th scope="col">No.</th>
                <th scope="col">Produk</th>
                <th scope="col">Nama Produk</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Harga Satuan</th>
                <th scope="col">Hapus</th>
              </tr>
            </thead>

            
            <tbody>
              <?php 
                $brg=mysqli_query($conn,"SELECT * FROM detailorder d, produk p WHERE orderid='$orderidd' AND d.idproduk=p.idproduk ORDER BY d.idproduk ASC");
                $no=1;
                while($b=mysqli_fetch_array($brg)) :
              ?>
              <tr class="rem1">
                <form action="" method="post">
                <th><?= $no++ ?></th>
                <td>
                  <a href="display-product.php?idkategori=<?= $b['idkategori'] ?>&idproduk=<?= $b['idproduk'] ?>"><img src="assets/img/produk/<?= $b['gambar1'] ?>" width="100px" height="100px" /></a>
                </td>
                <td><?= $b['namaproduk'] ?></td>
                <td>
                  <div class="quantity">
                    <div class="quantity-select">
                      <input type="number" name="jumlah" class="form-control" height="100px" min="1" max="10" value="<?= $b['qty'] ?>" \ />
                    </div>
                  </div>
                </td>
                <td><?= number_format($b['hargaafter']) ?></td>
                <td>
                  <div class="rem">
                    <input type="submit" name="update" class="form-control" value="Update" \ />
                    <input type="hidden" name="idproduknya" value="<?= $b['idproduk'] ?>" \ />
                    <input type="submit" name="hapus" class="form-control" value="Hapus" \ />
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
            </tbody>
          </table>
        </div>
        

        <div class="cart-left row">	
          <div class="cart-left-basket col-lg-4 col-sm-4 col-md-5">
            <h4>Total Harga</h4>
            <ul>
              <?php 
              $brg=mysqli_query($conn,"SELECT * FROM detailorder d, produk p WHERE orderid='$orderidd' AND d.idproduk=p.idproduk ORDER BY d.idproduk ASC");
              $no=1;
              $subtotal = 10000;
              while($b=mysqli_fetch_array($brg)):
              $hrg = $b['hargaafter'];
              $qtyy = $b['qty'];
              $totalharga = $hrg * $qtyy;
              $subtotal += $totalharga;
              ?>
              <li><?= $b['namaproduk']?><i> - </i> <span>Rp <?= number_format($totalharga) ?></span></li>
              <?php endwhile; ?>
              <li class="total">Total (inc. 10k Ongkir)<i> - </i> <span>Rp <?= number_format($subtotal) ?></span></li>
            </ul>
          </div>
          <div class="cart-right-basket col-lg-6 col-sm-6 col-md-6">
            <a href="./" ><i class='fas fa-arrow-left button-icon'></i>Continue Shopping</a>
            <?php if ($subtotal > 10000) { ?>
              <a href="checkout.php" >Checkout<i class='fas fa-arrow-right button-icon col'></i></a>
            <?php } ?>
          </div>
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

    <!--===== MAIN JS =====-->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
