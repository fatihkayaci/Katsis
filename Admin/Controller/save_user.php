<?php
session_start();
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
    // E-posta adresi kontrolü
if (empty($userEmail) || trim($userEmail) === "") {
    // E-posta adresi boşsa, kontrol yapmadan kaydet
    $userPass = randomPassword();
    $hashedPassword = base64_encode($userPass);
    $t ="Y";

    $sql = "INSERT INTO tbl_users (userName, tc, phoneNumber, durum, userEmail, userPass, plate, gender, apartman_id, rol, popup, userStatus) VALUES 
    (:userName, :tc, :phoneNumber, :durum, :userEmail, :userPass, :plate, :gender, :apartman_id, :rol, :popup, :userStatus)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userName', $userName);
    $stmt->bindParam(':tc', $tc);
    $stmt->bindParam(':phoneNumber', $phoneNumber);
    $stmt->bindParam(':durum', $durum);
    $stmt->bindValue(':userEmail', null, PDO::PARAM_NULL); // Boş değeri atanır
    $stmt->bindParam(':userPass', $hashedPassword);
    $stmt->bindParam(':plate', $plate);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':userStatus', $t);
    $stmt->bindParam(':apartman_id', $apartman_id);
    $rol = 3;
    $popup = 0;
    $stmt->bindParam(':rol', $rol);
    $stmt->bindParam(':popup', $popup);
    $stmt->execute();

    $_SESSION['lastID'] = $conn->lastInsertId();
    echo 1;
} else {
    // E-posta adresi doluysa, benzersizlik kontrolü yap
    $emailCheckSQL = "SELECT COUNT(*) FROM tbl_users WHERE userEmail = :userEmail";
    $emailCheckStmt = $conn->prepare($emailCheckSQL);
    $emailCheckStmt->bindParam(':userEmail', $userEmail);
    $emailCheckStmt->execute();

    if ($emailCheckStmt->fetchColumn() > 0) {
        echo "Bu e-posta adresi zaten var. Lütfen farklı bir e-posta adresi seçiniz.";
    } else {
        // E-posta adresi benzersiz, kaydetmeye devam et
        $userPass = randomPassword();
        $hashedPassword = base64_encode($userPass);
        $t ="Y";

        $sql = "INSERT INTO tbl_users (userName, tc, phoneNumber, durum, userEmail, userPass, plate, gender, apartman_id, rol, popup, userStatus) VALUES 
        (:userName, :tc, :phoneNumber, :durum, :userEmail, :userPass, :plate, :gender, :apartman_id, :rol, :popup, :userStatus)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userName', $userName);
        $stmt->bindParam(':tc', $tc);
        $stmt->bindParam(':phoneNumber', $phoneNumber);
        $stmt->bindParam(':durum', $durum);
        $stmt->bindParam(':userEmail', $userEmail);
        $stmt->bindParam(':userPass', $hashedPassword);
        $stmt->bindParam(':plate', $plate);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':userStatus', $t);
        $stmt->bindParam(':apartman_id', $apartman_id);
        $rol = 3;
        $popup = 0;
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':popup', $popup);
        $stmt->execute();
        
        $_SESSION['lastID'] = $conn->lastInsertId();
        echo 1;
    }
}

} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>