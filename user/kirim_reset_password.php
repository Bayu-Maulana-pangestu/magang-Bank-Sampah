<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];

    $token = bin2hex(random_bytes(16));
    $token_hash = hash("sha256", $token);
    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

    $mysqli = require __DIR__ . "/database.php";

    $sql = "UPDATE users
            SET reset_token = ?,
                reset_expires_at = ?
            WHERE email = ?";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sss", $token_hash, $expiry, $email);
    $stmt->execute();

    if ($mysqli->affected_rows) {
        $mail = require __DIR__ . "/mailer.php";
        $mail->setFrom("banksampahbjm21@gmail.com");
        $mail->addAddress($email);
        $mail->Subject = "Password Reset";
        $mail->Body = <<<END
        Click <a href="http://localhost/sampah/user/reset_password.php?token=$token">here</a> 
        to reset your password.
        END;

        try {
            $mail->send();
            echo "<script>
                    alert('Link reset password telah dikirim. Silakan cek kotak masuk Anda.');
                    window.location.href = 'login_user.php';
                  </script>";
        } catch (Exception $e) {
            echo "<script>
                    alert('Pesan tidak dapat dikirim. Kesalahan Mailer: {$mail->ErrorInfo}');
                  </script>";
        }
    } else {
        echo "<script>
                alert('Email tidak ditemukan di database kami.');
              </script>";
    }
}
?>