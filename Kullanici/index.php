<?php
// Formdan gelen verileri al
$email = $_POST['email'];
$password = $_POST['password'];

// Şifreyi güvenli bir şekilde hashle ve veritabanındaki ile karşılaştır
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Şifreyi kontrol et
    if (password_verify($password, $row['password'])) {
        // Giriş başarılı
        echo "Giriş başarılı!";
    } else {
        // Şifre yanlış
        echo "Hatalı şifre!";
    }
} else {
    // Kullanıcı bulunamadı
    echo "Kullanıcı bulunamadı!";
}

// Veritabanı bağlantısını kapat
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
