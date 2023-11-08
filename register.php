<?php
session_start();
$hostname = "localhost";
$user = "root";
$password = "";
$db_name ="poliklinik";

$koneksi = mysqli_connect($hostname,$user,$password,$db_name) or die (mysqli_error($koneksi));

if (isset($_SESSION['login'])){
	header("location:index.php");
	exit;
  }

if (isset($_POST['submit'])){
    $username = $_POST['username'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    $cek_user = mysqli_query($koneksi,"SELECT * FROM user WHERE username = '$username'");
    $cek_login = mysqli_num_rows($cek_user);


    if ($cek_login > 0) {
      echo" <script>
        alert('Username telag terdaftar');
        window.location = 'register.php';
      </script>";
    } else {
      if ($password1 != $password2){
        echo "<script>
        alert('Konfirmasi password tidak sesuai');
        window.location = 'register.php';
      </script>";
      } else {
        $password = password_hash($password1,PASSWORD_DEFAULT);
        mysqli_query($koneksi,"INSERT INTO user VALUE('','$username','$password')");
        echo "<script>
        alert('Data berhasil di kirim ');
        window.location = 'login.php';
      </script>";
      }
    }
  }


?>
<!DOCTYPE html>
<html>
<head>
<title>Form registrasi akun</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/register.css" rel="stylesheet" type="text/css" media="all" />
<link href="//fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,700,700i" rel="stylesheet">
</head>
<body>
	<div class="main-w3layouts wrapper">
		<h1> Registrasi</h1>
		<div class="main-agileinfo">
			<div class="agileits-top">
				<form action="" method="POST">
					<input class="text email" type="text" name="username" placeholder="username" required="yes">
					<input class="text" type="password" name="password1" placeholder="Password" required="">
					<input class="text w3lpass" type="password" name="password2" placeholder="Confirm Password" required="">
					<input type="submit" value="SIGNUP" name="submit">
				</form>
				<p>Sudah punya akun? <a href="login.php"> Login Sekarang!</a></p>
			</div>
		</div>

		</div>

		<ul class="colorlib-bubbles">
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
		</ul>
	</div>

</body>
</html>