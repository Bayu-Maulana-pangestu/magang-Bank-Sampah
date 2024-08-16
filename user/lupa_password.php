

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link rel="stylesheet" href="stylelogin.css">
</head>
<body>
    <div class="container">
        <div class="login">
            <form action="kirim_reset_password.php" method="post">
                <h1>Lupa Password</h1>
                <hr>
                <p>Masukkan email Anda untuk mereset password</p>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="input" placeholder="Email" required>
                <button type="submit" name="reset">Kirim Link Reset</button>
                <p><a href="login_user.php">Kembali ke Login</a></p>
            </form>
        </div>
        <div class="right">
            <img src="../img/log.png" alt="">
        </div>
    </div>
</body>
</html>
