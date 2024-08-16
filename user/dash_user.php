<?php include "../layouts/header.php" ?>
    <?php 
     session_start();
    ?>
    <h1>
        INI ADALAH HALAMAN USER
    </h1>
    <h1>selamat datang <?php echo $_SESSION["user_username"] ?> </h1>

    <a href="login_user.php">kembali</a>
    <?php include "../layouts/footer.php" ?>