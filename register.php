<?php 
  session_start();
  include 'dbconnect.php';

  if(!isset($_SESSION['log'])){
    
  } else {
    header('location:index.php');
  };
  
  // Registrasi
  if (isset($_POST["register"])) {

    function registrasi($data) {
      global $conn;
      global $dup;
      global $confirm;

      $email = $data["email"];
      $username = strtolower(stripslashes($data["username"]));
      $alamat = $data["alamat"];
      $password = mysqli_real_escape_string($conn, $data["password"]);
      $verify = mysqli_real_escape_string($conn, $data["verify"]);

      // cek duplikasi user
      $duplikasi = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
      if (mysqli_fetch_assoc($duplikasi)) {
        $dup = true;
        return false;
        exit;
      }

      // cek konfirmasi password 
      if ($password !== $verify) {
        $confirm = true;
        return false;
        exit;
      }

      // enkripsi password
      $password = password_hash($password, PASSWORD_DEFAULT);

      // tambahkan user baru ke database 
      mysqli_query($conn, "INSERT INTO users(email, username, alamat, password) VALUES('$email', '$username','$alamat', '$password')") or trigger_error(mysqli_error($conn));
      return mysqli_affected_rows($conn);
    }
    
    if (registrasi($_POST) > 0) {
      echo " <div class='alert alert-success' style='position: fixed;'>
			Berhasil mendaftar, silakan masuk.
		  </div>
		<meta http-equiv='refresh' content='2; url= login.php'/>  ";
    } else {
      $error = true;
    }
  }

  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/Favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/Favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/Favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/img/Favicon/site.webmanifest">

    <!-- ===== CSS ===== -->
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css" />

    <!-- ===== BOX ICONS ===== -->
    <link href="https://unpkg.com/boxicons@2.0.8/css/boxicons.min.css" rel="stylesheet" />

    <!-- ===== Bootstrap ===== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <title>Tokoku | Register</title>
  </head>
  <body>
    <div class="login-page">
      <div class="register">
        <a href="login.php"><i class="bx bx-left-arrow-alt icon"></i></a>
        <h2 class="login-title">Register</h2>
        <?php if (isset($confirm)) { ?>
          <p class="login-error">Konfirmasi Password Tidak Sesuai</p>
        <?php } else if (isset($dup)) { ?>
          <p class="login-error">Pengguna sudah terdaftar</p>
        <?php } else if (isset($error)) { ?>
          <p class="login-error">Gagal mendaftar, silakan coba lagi.</p>
        <?php } ?>
        <form action="" method="post">
          <ul>
            <li class="form">
              <label for="email">Email</label>
              <input type="text" name="email" id="email" required />
            </li>
            <li class="form">
              <label for="username">Username</label>
              <input type="text" name="username" id="username" required />
            </li>
            <li class="form">
              <label for="alamat">Alamat</label>
              <input type="text" name="alamat" id="alamat" required />
            </li>
            <li class="form">
              <label for="password">Password</label>
              <input type="password" name="password" id="password" required />
            </li>
            <li class="form">
              <label for="verify">Konfirmasi Password</label>
              <input type="password" name="verify" id="verify" required />
            </li>
            <br>
              <input type="submit" name="register" class="button-light button-login" value="Register">
          </ul>
        </form>
      </div>
    </div>
  </body>
</html>
