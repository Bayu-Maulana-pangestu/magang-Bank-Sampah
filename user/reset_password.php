<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = $_POST["token"];
    $newPassword = $_POST["new_password"];
    $confirmPassword = $_POST["confirm_password"];

    if ($newPassword !== $confirmPassword) {
        die("Passwords must match");
    }


    $token_hash = hash("sha256", $token);

    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM users WHERE reset_token = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $token_hash);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user === null) {
        die("Token not found");
    }

    if (strtotime($user["reset_expires_at"]) <= time()) {
        die("Token has expired");
    }

    $password_hash = password_hash($newPassword, PASSWORD_DEFAULT);

    $sql = "UPDATE users SET password_hash = ?, reset_token = NULL, reset_expires_at = NULL WHERE id_user = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $password_hash, $user["id_user"]);
    $stmt->execute();

    echo "<script>
            alert('Reset Password Berhasil.');
            window.location.href = 'login_user.php';
          </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="stylelogin.css">
</head>
<body>
    <div class="container">
        <div class="login">
            <form id="resetForm" action="" method="post" onsubmit="return validateForm()">
                <h1>Reset Password</h1>
                <hr>
                <label for="new_password">Password Baru</label>
                <input type="password" name="new_password" id="new_password" class="input" placeholder="Password Baru" required>
                <label for="confirm_password">Konfirmasi Password Baru</label>
                <input type="password" name="confirm_password" id="confirm_password" class="input" placeholder="Konfirmasi Password Baru" required>
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
                <button type="submit" name="reset">Reset Password</button>
                <p><a href="login_user.php">Kembali ke Login</a></p>
                <div id="alert" style="display: none; color: red;"></div>
            </form>
        </div>
        <div class="right">
            <img src="../img/log.png" alt="">
        </div>
    </div>

    <script>
        function validateForm() {
            var newPassword = document.getElementById("new_password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            var alertDiv = document.getElementById("alert");

            if (newPassword !== confirmPassword) {
                alertDiv.style.display = "block";
                alertDiv.innerHTML = "Passwords must match";
                return false;
            }


            return true;
        }
    </script>
</body>
</html>
