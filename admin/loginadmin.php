<?php
include("../inc/inc_koneksi.php");
$email   = "";
$password   = "";
$err = "";
if(isset($_POST['login'])){
    $email   = $_POST['email'];
    $password   = $_POST['password'];
    if($email == '' or $password == ''){
        $err .= "<li>Silakhakn masukkan username dan password</li>";
    }
    if(empty($err)){
        $sql1 = "select * from admin where email = '$email'";
        $q1 = mysqli_query($koneksi,$sql1);
        $r1 = mysqli_fetch_array($q1);
        if($r1['password'] != md5($password)){
            $err .= "<li>Akun tidak ditemukan</li>";
        }
        if(empty($err)){
            $_SESSION['admin_email'] = $email;
            header("location:admin.php");
            exit();
        }
    }
}
?>



<!DOCTYPE html>
<html>

<head>
    <title>LOGIN MULTIUSER PHP</title>
    <link rel="stylesheet" type="text/css" href="styleloginadmin.css">
</head>

<body>

    <h1>Halaman Login Admin</h1>

    <?php
 if(isset($_GET['pesan'])){
  if($_GET['pesan']=="gagal"){
   echo "<div class='alert'>email dan Password Salah !</div>";
  }
 }
 ?>

    <div class="login">
        <p class="tulisan_atas">Silahkan Masuk</p>

        <form action="#" method="post">
            <label>Email</label>
            <input type="text" name="email" class="form_login" placeholder="Email" required="required">

            <label>Password</label>
            <input type="password" name="password" class="form_login" placeholder="Password" required="required">

            <input type="submit" name="login" class="tombol_login" value="LOGIN">

            <br />
            <br />

        </form>

    </div>


</body>

</html>