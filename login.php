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
    header('location:index.php');
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
        $_SESSION['login'] = true;

        // cek remember me
        if (isset($_POST['remember'])) {
          // buat cookie

          setcookie('aidi', $row['userid'], time() + 604800); // cookie 1 minggu
          setcookie('yusernem', hash('sha256', $row['username']), time() + 604800); // cookie 1 minggu
        }

        header('location:index.php');
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

    <!-- ===== CSS ===== -->
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css" />

    <!-- ===== BOX ICONS ===== -->
    <link href="https://unpkg.com/boxicons@2.0.8/css/boxicons.min.css" rel="stylesheet" />

    <!-- ===== Bootstrap ===== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <title>Tokoku | Login</title>
  </head>
  <body>
    <div class="login-page">
      <div class="login">
        <a href="index.php"><i class="bx bx-left-arrow-alt icon"></i></a>
        <h2 class="login-title">Login</h2>
        <?php if (isset($error)) : ?>
          <p class="login-error">
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
            </li>
            <li class="remember">
              <input type="checkbox" name="remember" id="remember" />
              <label for="remember">Remember me</label>
            </li>
            <li>
            <input type="submit" name="login" class="button-light button-login" value="Login">
            </li>
            <li class="login-signup">
              <p>Don't have an account? <a href="register.php">Sign Up</a></p>
            </li>
          </ul>
        </form>
      </div>
    </div>
  </body>
</html>
