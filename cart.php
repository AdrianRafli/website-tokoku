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

    <!-- ===== CSS ===== -->
    <link rel="stylesheet" href="assets/css/styles.css" />

    <!-- ===== BOX ICONS ===== -->
    <link href="https://unpkg.com/boxicons@2.0.8/css/boxicons.min.css" rel="stylesheet" />

    <!-- ===== Bootstrap ===== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <title>Tokoku | Cart</title>
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
          <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
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

    <main class="cart-page">
      <div class="container">
        <h2 class="jumlah-barang">Dalam Keranjangmu ada : <span><?= $itungtrans3 ?> barang</span></h2>

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
                <a href="product.php?idproduk=<?= $b['idproduk'] ?>"><img src="<?php echo $b['gambar'] ?>" width="100px" height="100px" /></a>
              </td>
              <td><?= $b['namaproduk'] ?></td>
              <td>
                <div class="quantity">
                  <div class="quantity-select">
                    <input type="number" name="jumlah" class="form-control" height="100px" value="<?= $b['qty'] ?>" \ />
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

        <div class="cart-left">	
          <div class="cart-left-basket">
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
          <div class="cart-right-basket">
            <a href="index.php" ><i class='bx bx-left-arrow-alt button-icon'></i>Continue Shopping</a>
            <a href="checkout.php">Checkout<i class='bx bx-right-arrow-alt button-icon' ></i></a>
          </div>
      </div>

      <div class="clearfix"></div>
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
