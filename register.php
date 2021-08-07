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
      <div class="register">
        <a href="javascript:history.back()"><i class="bx bx-left-arrow-alt icon"></i></a>
        <h2 class="login-title">Welcome</h2>
        <form action="" method="post">
          <ul>
            <li class="form">
              <label for="email">Email</label>
              <input type="text" name="email" id="email" />
            </li>
            <li class="form">
              <label for="username">Username</label>
              <input type="text" name="username" id="username" />
            </li>
            <li class="form">
              <label for="password">Password</label>
              <input type="password" name="password" id="password" />
            </li>
            <li class="form">
              <label for="verify">Verify Password</label>
              <input type="password" name="verify" id="verify" />
            </li>
            <li class="button-login">
              <a type="submit" name="register" class="button-light" href="#">register</a>
            </li>
          </ul>
        </form>
      </div>
    </div>
  </body>
</html>
