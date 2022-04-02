<?php 
  session_start();
  include 'dbconnect.php';

  // cek cookie
  if ( isset($_COOKIE['aidi']) && isset($_COOKIE['yusernem']) ) {
    $id = $_COOKIE['aidi'];
    $username = $_COOKIE['yusernem'];

    // ambil username berdasarkan id
    $akun = mysqli_query($conn, "SELECT username FROM users WHERE userid ='$id'");
    $row = mysqli_fetch_assoc($akun);

    // cek cookie
    if ($username === hash('sha256', $row['username'])) {
      $_SESSION['login'] = true;
    }
  }

  if(isset($_SESSION['login'])){
    header('location:./');
    exit;
  } 
  
  if (isset($_POST["login"])) {
    
    $email = $_POST["email"];
    $password = $_POST["password"];

    // pengecekkan akun
    $akun = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    $row = mysqli_fetch_assoc($akun);
    if (mysqli_num_rows($akun) === 1) {
      // cek password
      if (password_verify($password, $row["password"])) {
        // cek session
        $_SESSION['id'] = $row['userid'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['login'] = true;
        
        if($_SESSION['role'] == 'admin') {
          $_SESSION['admin'] = true;
        }

        // cek remember me
        if (isset($_POST['remember'])) {
          // buat cookie

          setcookie('aidi', $row['userid'], time() + 604800); // cookie 1 minggu
          setcookie('yusernem', hash('sha256', $row['username']), time() + 604800); // cookie 1 minggu
        }

        header('location:./');
      } 
    }
    $error = true;
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
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

    <title>Tokoku | Login</title>
  </head>
  <body>
    <div class="login-page d-flex justify-content-center align-items-center">
      <div class="login">
        <a href="./"><i class="fas fa-arrow-left icon"></i></a>
        <h2 class="login-title">Login</h2>
        <?php if (isset($error)) : ?>
          <p class="login-error px-1">
            Gagal Login, Mungkin Email atau Password Salah!
          </p>
        <?php endif; ?>
        <form action="" method="post">
          <ul>
            <li class="form">
              <label for="email">Email</label>
              <input type="text" name="email" id="email" required />
            </li>
            <li class="form">
              <label for="password">Password</label>
              <input type="password" name="password" id="password" required />
              <i class="fas fa-eye pass-icon" onclick="visible()" id="pass-icon"></i>
            </li>
            <li class="remember">
              <input type="checkbox" name="remember" id="remember" />
              <label for="remember">Remember me</label>
            </li>
            <li>
            <button type="submit" class="btn btn-dark button-login" name="login">LOGIN</button>
            </li>
            <li class="login-signup">
              <p>Don't have an account? <a href="register.php">Sign Up</a></p>
            </li>
          </ul>
        </form>
      </div>
    </div>

    <script src="assets/js/password.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
