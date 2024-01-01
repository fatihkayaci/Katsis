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
    $email = $_POST['email'];
    $apartID = $_POST['apartID'];

    

    // Rastgele şifre oluştur
    $sifre = randomPassword();
    
    $vehiclePlate = $_POST['vehiclePlate'];
    $gender = $_POST['gender'];

    // SQL sorgusunu hazırla
    $sql = "INSERT INTO tbl_kullanici (fullName, tc, phoneNumber, email, sifre, vehiclePlate, gender,apartmanID) VALUES 
    (:fullName, :tc, :phoneNumber, :email, :sifre, :vehiclePlate, :gender,:apartmanID)";

    // PDO sorgusunu hazırla ve çalıştır
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':fullName', $fullName);
    $stmt->bindParam(':tc', $tc);
    $stmt->bindParam(':phoneNumber', $phoneNumber);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':sifre', $sifre);
    $stmt->bindParam(':vehiclePlate', $vehiclePlate);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':apartmanID', $apartID);
    $stmt->execute();
    echo 1;
} catch (PDOException $e) {
    echo $e;
}
?>
    