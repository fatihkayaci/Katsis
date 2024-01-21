<?php
include("../../DB/dbconfig.php");

function randomPassword($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $sifre = '';

    for ($i = 0; $i < $length; $i++) {
        $sifre .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $sifre;
}

try {
    // POST verilerini al
    $fullName = $_POST['fullName'];
    $tc = $_POST['tc'];
    $phoneNumber = $_POST['phoneNumber'];
    $durum = $_POST['durum'];
    $email = $_POST['email'];
    $apartID = $_POST['apartID'];
    $vehiclePlate = $_POST['vehiclePlate'];
    $gender = $_POST['gender'];

    // E-posta adresinin varlığını kontrol et
    $emailCheckSQL = "SELECT COUNT(*) FROM tbl_users WHERE userEmail = :email";
    $emailCheckStmt = $conn->prepare($emailCheckSQL);
    $emailCheckStmt->bindParam(':email', $email);
    $emailCheckStmt->execute();
    
    if ($emailCheckStmt->fetchColumn() > 0) {
        echo "bu email zaten var. lütfen email adresini kontrol edip tekrar deneyiniz.";
    } else {
        // Rastgele şifre oluştur
        $sifre = randomPassword();
        // SQL sorgusunu hazırla
        $sql = "INSERT INTO tbl_users (userName, tc, phoneNumber,durum ,userEmail, userPass, plate, gender, apartman_id, rol, popup) VALUES 
        (:fullName, :tc, :phoneNumber, :durum, :email, :sifre, :vehiclePlate, :gender, :apartmanID, :rol, :popup)";

        // PDO sorgusunu hazırla ve çalıştır
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':fullName', $fullName);
        $stmt->bindParam(':tc', $tc);
        $stmt->bindParam(':phoneNumber', $phoneNumber);
        $stmt->bindParam(':durum', $durum);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':sifre', $sifre);
        $stmt->bindParam(':vehiclePlate', $vehiclePlate);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':apartmanID', $apartID);
        $stmt->bindParam(':rol', 3);
        $stmt->bindParam(':popup', 0);
        $stmt->execute();
        echo 1;
    }
} catch (PDOException $e) {
    echo $e;
}
?>
