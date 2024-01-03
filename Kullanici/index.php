<?php
session_start();

include("../DB/dbconfig.php");

// Çerezleri kontrol et ve otomatik giriş yap
if (isset($_COOKIE['email']) && isset($_COOKIE['sifre'])) {
    $cookieEmail = $_COOKIE['email'];
    $cookieSifre = $_COOKIE['sifre'];

    $email = $cookieEmail;
    $sifre = $cookieSifre;

    // Otomatik giriş yapma işlemleri
    if ($email && $sifre) {
        $sql = "SELECT * FROM tbl_kullanici WHERE email = :email AND sifre = :sifre";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':sifre', $sifre, PDO::PARAM_STR);
        $stmt->execute();

        $rowCount = $stmt->rowCount();

        if ($rowCount > 0) {
            $_SESSION['email'] = $email;

            // Hatırla işareti varsa, çerez oluştur
            if ($hatirla) {
                setcookie('email', $email, time() + (86400 * 30), "/"); // 30 gün süreyle geçerli çerez
                setcookie('sifre', $sifre, time() + (86400 * 30), "/"); // 30 gün süreyle geçerli çerez
            }

            // Kullanıcı bulundu, giriş başarılı
            // Başka bir sayfaya yönlendir
            header("Location: giris.php");
            exit();
        }
    }
}

// Otomatik giriş yapılmadıysa, diğer giriş kontrollerini yap
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $sifre = $_POST["sifre"];
    $hatirla = isset($_POST["hatirla"]) ? true : false;
    

    $sql = "SELECT * FROM tbl_kullanici WHERE email = :email AND sifre = :sifre";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':sifre', $sifre, PDO::PARAM_STR);
    $stmt->execute();

    $rowCount = $stmt->rowCount();

    if ($rowCount > 0) {
        $_SESSION['email'] = $email;

        // Hatırla işareti varsa, çerez oluştur
        if ($hatirla) {
            setcookie('email', $email, time() + (86400 * 30), "/"); // 30 gün süreyle geçerli çerez
            setcookie('sifre', $sifre, time() + (86400 * 30), "/"); // 30 gün süreyle geçerli çerez
        }

        // Kullanıcı bulundu, giriş başarılı
        // Başka bir sayfaya yönlendir
        header("Location: giris.php");
        exit();
    } else {
        // Kullanıcı bulunamadı, hata mesajı
        echo "Kullanıcı adı veya şifre hatalı.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiracı Girişi</title>
</head>

<body>
    <h2>Kiracı Girişi</h2>
    <form method="post">
        <label for="email">email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="sifre">Şifre:</label>
        <input type="password" id="sifre" name="sifre" required><br><br>

        <input type="checkbox" id="hatirla" name="hatirla">
        <label for="hatirla">Beni Hatırla</label><br><br>

        <input type="submit" value="Giriş Yap">
    </form>
</body>

</html>