<?php
include("../../DB/dbconfig.php");
try {
    // POST verilerini al
    $kullaniciID = $_POST['kullaniciID'];
    $fullName = $_POST['fullName'];
    $tc = $_POST['tc'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];
    $sifre = $_POST['sifre'];
    $vehiclePlate = $_POST['vehiclePlate'];
    $gender = $_POST['gender'];
    

    // SQL sorgusunu hazırla
    $sql = "UPDATE tbl_kullanici SET 
            fullName = :fullName,
            tc = :tc,
            phoneNumber = :phoneNumber,
            email = :email,
            sifre = :sifre,
            vehiclePlate = :vehiclePlate,
            gender = :gender
            WHERE kullaniciID = :kullaniciID";

    // PDO sorgusunu hazırla ve çalıştır
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':kullaniciID', $kullaniciID);
    $stmt->bindParam(':fullName', $fullName);
    $stmt->bindParam(':tc', $tc);
    $stmt->bindParam(':phoneNumber', $phoneNumber);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':sifre', $sifre);
    $stmt->bindParam(':vehiclePlate', $vehiclePlate);
    $stmt->bindParam(':gender', $gender);
    $stmt->execute();
    echo 1;
} catch (PDOException $e) {
    echo 0;
}
?>
