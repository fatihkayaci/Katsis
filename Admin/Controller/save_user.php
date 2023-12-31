<?php
include("../../DB/dbconfig.php"); 
try {
    // POST verilerini al
    $fullName = $_POST['fullName'];
    $tc = $_POST['tc'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];
    $vehiclePlate = $_POST['vehiclePlate'];
    $gender = $_POST['gender'];



    // SQL sorgusunu    hazırla
    $sql = "INSERT INTO tbl_kullanici (fullName, tc, phoneNumber, email, vehiclePlate, gender) VALUES 
    (:fullName, :tc, :phoneNumber, :email, :vehiclePlate, :gender)";
    // PDO sorgusunu hazırla ve çalıştır
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':fullName', $fullName);
    $stmt->bindParam(':tc', $tc);
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
