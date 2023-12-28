<?php
include("../../DB/dbconfig.php");
try {
    // POST verilerini al
    $kullanıcıID = $_POST['kullanıcıID'];
    $fullName = $_POST['fullName'];
    $TC = $_POST['TC'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];
    $vehiclePlate = $_POST['vehiclePlate'];
    $gender = $_POST['gender'];
    // SQL sorgusunu hazırla
    $sql = "UPDATE tbl_kullanici SET 
            fullName = :fullName,
            TC = :TC,
            phoneNumber = :phoneNumber,
            email = :email,
            vehiclePlate = :vehiclePlate,
            gender = :gender
            WHERE kullanıcıID = :kullaniciID";

    // PDO sorgusunu hazırla ve çalıştır
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':kullaniciID', $kullanıcıID);
    $stmt->bindParam(':fullName', $fullName);
    $stmt->bindParam(':TC', $TC);
    $stmt->bindParam(':phoneNumber', $phoneNumber);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':vehiclePlate', $vehiclePlate);
    $stmt->bindParam(':gender', $gender);
    $stmt->execute();
    echo 1;
} catch (PDOException $e) {
    echo 0;
}
?>
