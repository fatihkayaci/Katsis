<?php
include("../../DB/dbconfig.php");

function randomPassword($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $userPass = '';

    for ($i = 0; $i < $length; $i++) {
        $userPass .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $userPass;
}

try {
    // POST verilerini al
    $userName = $_POST['userName'];
    $tc = $_POST['tc'];
    $phoneNumber = $_POST['phoneNumber'];
    $durum = $_POST['durum'];
    $userEmail = $_POST['userEmail'];
    $apartman_id = $_POST['apartman_id'];
    $plate = $_POST['plate'];
    $gender = $_POST['gender'];
    // E-posta adresinin varlığını kontrol et
    $emailCheckSQL = "SELECT COUNT(*) FROM tbl_users WHERE userEmail = :userEmail";
    $emailCheckStmt = $conn->prepare($emailCheckSQL);
    $emailCheckStmt->bindParam(':userEmail', $userEmail);
    $emailCheckStmt->execute();
    
    if ($emailCheckStmt->fetchColumn() > 0) {
        echo "bu email zaten var. lütfen email adresini kontrol edip tekrar deneyiniz.";
    } else {
        // Rastgele şifre oluştur
        $userPass = randomPassword();
        // SQL sorgusunu hazırla
        $sql = "INSERT INTO tbl_users (userName, tc, phoneNumber,durum ,userEmail, userPass, plate, gender, apartman_id, rol, popup) VALUES 
        (:userName, :tc, :phoneNumber, :durum, :userEmail, :userPass, :plate, :gender, :apartman_id, :rol, :popup)";

        // PDO sorgusunu hazırla ve çalıştır
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userName', $userName);
        $stmt->bindParam(':tc', $tc);
        $stmt->bindParam(':phoneNumber', $phoneNumber);
        $stmt->bindParam(':durum', $durum);
        $stmt->bindParam(':userEmail', $userEmail);
        $stmt->bindParam(':userPass', $userPass);
        $stmt->bindParam(':plate', $plate);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':apartman_id', $apartman_id);
        $rol = 3;
        $popup = 0;
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':popup', $popup);
        $stmt->execute();
       
    }
} catch (PDOException $e) {
    echo $e;
}
?>