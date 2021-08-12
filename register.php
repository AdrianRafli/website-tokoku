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

      $email = $data["email"];
      $username = strtolower(stripslashes($data["username"]));
      $password = mysqli_real_escape_string($conn, $data["password"]);
      $verify = mysqli_real_escape_string($conn, $data["verify"]);

      // cek duplikasi user
      $duplikasi = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
      if (mysqli_fetch_assoc($duplikasi)) {
        echo "<div class='alert alert-warning'>
        Pengguna sudah terdaftar
        </div>
       <meta http-equiv='refresh' content='1; url= register.php'/> ";
       return false;
      }

      // cek konfirmasi password 
      if ($password !== $verify) {
        echo "<div class='alert alert-warning'>
        konfirmasi password tidak sesuai!
        </div>
       <meta http-equiv='refresh' content='1; url= register.php'/> ";
        return false;
      }

      // enkripsi password
      $password = password_hash($password, PASSWORD_DEFAULT);

      // tambahkan user baru ke database 
      mysqli_query($conn, "INSERT INTO users VALUES('','$email', '$username', '$password')");
      return mysqli_affected_rows($conn);
    }
    
    if (registrasi($_POST) > 0) {
      echo " <div class='alert alert-success'>
			Berhasil mendaftar, silakan masuk.
		  </div>
		<meta http-equiv='refresh' content='1; url= login.php'/>  ";
    } else {
      echo "<div class='alert alert-warning'>
			Gagal mendaftar, silakan coba lagi.
		  </div>
		 <meta http-equiv='refresh' content='1; url= register.php'/> ";
    }
  }

  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

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
        <a href="javascript:history.back()"><i class="bx bx-left-arrow-alt icon"></i></a>
        <h2 class="login-title">Register</h2>
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
              <label for="password">Password</label>
              <input type="password" name="password" id="password" required />
            </li>
            <li class="form">
              <label for="verify">Verify Password</label>
              <input type="password" name="verify" id="verify" required />
            </li>
              <input type="submit" name="register" class="button-light button-login" value="Register">
          </ul>
        </form>
      </div>
    </div>
  </body>
</html>
