<?php
  session_start();
  include 'dbconnect.php';

  if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
  }

  $uid = $_SESSION['id'];
	$caricart = mysqli_query($conn,"SELECT * FROM cart WHERE userid='$uid' AND STATUS='Cart'");
	$fetc = mysqli_fetch_array($caricart);
	$orderidd = $fetc['orderid'];
	$itungtrans = mysqli_query($conn,"SELECT count(detailid) AS jumlahtrans FROM detailorder WHERE orderid='$orderidd'");
	$itungtrans2 = mysqli_fetch_assoc($itungtrans);
	$itungtrans3 = $itungtrans2['jumlahtrans'];
	
  if(isset($_POST["checkout"])){
    $q3 = mysqli_query($conn, "UPDATE cart SET STATUS='Payment' WHERE orderid='$orderidd'");
    if($q3){
      $berhasil = true;
    } else {
      $error = true;
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

    <title>Tokoku | Checkout</title>
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
                    $kat=mysqli_query($conn,"SELECT * from kategori order by idkategori ASC");
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
        <div class='alert alert-success'>
          Berhasil Check Out
        </div>
        <meta http-equiv='refresh' content='2; url= index.php'/>
      <?php } else if (isset($error)) { ?>
        <div class='alert alert-danger'>
          Gagal Check Out
        </div>
        <meta http-equiv='refresh' content='2; url= index.php'/>
      <?php } ?>

      <div class="checkout-page">
        <div class="container">
          <h2 class="jumlah-barang">Terima Kasih  <?= $_SESSION['username'] ?>, telah membeli <?= $itungtrans3 ?> barang di Tokoku</h2>

          <div class="chekcout">
            <div class="table-responsive">
              <table class="table table-bordered" width="80">
                <thead class="table-dark">
                  <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Produk</th>
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Sub Total</th>
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
                      <a href="display-product.php?idproduk=<?= $b['idproduk'] ?>"><img src="<?= $b['gambar1'] ?>" width="150px" height="150px" /></a>
                    </td>
                    <td><?= $b['namaproduk'] ?></td>
                    <td>
                      <div class="quantity">
                        <div class="quantity-select">
                          <h4><?= $b['qty'] ?></h4>
                        </div>
                      </div>
                    </td>
                    <td>Rp<?= number_format($b['hargaafter']*$b['qty']) ?></td>
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
            
            <div class="checkout-left row">
              <div class="checkout-left-basket col-sm" \>
                <h4>Total Harga yang harus dibayar saat ini</h4>
                <ul>
                  <?php 
                    $brg=mysqli_query($conn,"SELECT * FROM detailorder d, produk p WHERE orderid='$orderidd' AND d.idproduk=p.idproduk ORDER BY d.idproduk ASC");
                    $no=1;
                    $subtotal = 10000;
                    while( $b=mysqli_fetch_array($brg) ){
                    $hrg = $b['hargaafter'];
                    $qtyy = $b['qty'];
                    $totalharga = $hrg * $qtyy;
                    $subtotal += $totalharga;
                    }
                  ?>
                  <h2><input type="text" value="Rp<?= number_format($subtotal) ?>" disabled \ /></h2>
                </ul>
              </div>
              <div class="checkout-left-basket col-sm">
                <h4>Kode Order Anda</h4>
                <h2><input type="text" value="<?= $orderidd ?>" disabled \ /></h2>
              </div>
            </div>
          </div>

          <div class="agree">
            <hr />
            <br />
            <h5>Total harga yang tertera di atas sudah termasuk ongkos kirim sebesar Rp10.000</h5>
            <h5>Bila telah melakukan pembayaran, harap konfirmasikan pembayaran Anda.</h5>
          </div>

          <div class="payment row">
            <?php 
              $metode = mysqli_query($conn,"SELECT * FROM pembayaran");
              while($p=mysqli_fetch_array($metode)) :
            ?>
            <div class="payment-method col">
              <img src="<?= $p['logo'] ?>" /><br />
              <h4>
                <?= $p['metode'] ?> - <?= $p['norek'] ?><br />
                a/n. <?php echo $p['an'] ?>
              </h4>
            </div>
            <?php endwhile; ?>
          </div>

          <div class="submit-checkout">
            <hr />
            <br />
            <h5 class="pb-4">
              Orderan anda Akan Segera kami proses 1x24 Jam Setelah Anda Melakukan Pembayaran ke ATM kami dan menyertakan informasi pribadi yang melakukan pembayaran seperti Nama Pemilik Rekening / Sumber Dana, Tanggal Pembayaran, Metode
              Pembayaran dan Jumlah Bayar.
            </h5>

            <form action="" method="post">
              <input type="submit" class="form-control btn btn-dark" name="checkout" value="I Agree and Check Out" />
            </form>
          </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
