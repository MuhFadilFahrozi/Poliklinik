<?php
session_start();
include 'koneksi.php';

if (isset($_SESSION['login'])){
  header("location:index.php");
  exit;
}

if (isset($_POST['login'])) {
  $username = $_POST['user'];
  $password = $_POST['pass'];

  $_SESSION['login'] = $_POST['login'];

  $ambil = mysqli_query($koneksi,"SELECT * FROM user WHERE username = '$username'");

  if (mysqli_num_rows($ambil) === 1) {
    $data = mysqli_fetch_assoc($ambil);

    if (password_verify($password,$data['password'])){
      $_SESSION['username'] = $data['username'];
      header("location:index.php");
      exit();
    }else {
      echo "<script>
      alert('Username atau password salah');
      window.location = 'login.php';
      </script>";
    }

  } else {
    echo "<script>
    alert('Username atau password salah');
    window.location = 'login.php';
    </script>";
  }
}

?>
<!DOCTYPE html>
<html>

<head>

  <meta charset="UTF-8">

  <title> Log-in</title>

  <link rel='stylesheet' href='http://codepen.io/assets/libs/fullpage/jquery-ui.css'>

    <link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />

</head>

<body>

  <div class="login-card">
    <h1>Log-in</h1><br>
  <form action="" method="POST">
    <input type="text" name="user" placeholder="Username" required>
    <input type="password" name="pass" placeholder="Password" required>
    <input type="submit" name="login" class="login login-submit" value="login">
  </form>

  <div class="login-help">
    <a href="register.php">Register</a> 
  </div>
</div>


  <script src='http://codepen.io/assets/libs/fullpage/jquery_and_jqueryui.js'></script>

</body>

</html>