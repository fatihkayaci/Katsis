<?php
session_start();
include ("../../DB/dbconfig.php");
require_once 'class.func.php';

try {
    // Kat malikleri ve kiracılar için değişen verileri POST isteğinden alın
    $katMalikleriData = $_POST['katMalikleriData'];
$kiracilarData = $_POST['kiracilarData'];
    // Kat malikleri için veritabanına ekleyin
    foreach ($katMalikleriData as $row) {
        $sql = "INSERT INTO tbl_users (userName, tc, phoneNumber, userEmail, durum) 
        VALUES (:userName, :tc, :phoneNumber, :userEmail, 'katMaliki')";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userName', $row['KatMalikiUserName']);
        $stmt->bindParam(':tc', $row['KatMalikitc']);
        $stmt->bindParam(':phoneNumber', $row['KatMalikiPhone']);
        $stmt->bindParam(':userEmail', $row['KatMalikiEmail']);
        $stmt->execute();
    }

    // Kiracılar için veritabanına ekleyin
    foreach ($kiracilarData as $row) {
        $sql = "INSERT INTO tbl_users (userName, tc, phoneNumber, userEmail, durum) 
        VALUES (:userName, :tc, :phoneNumber, :userEmail, 'kiraci')";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userName', $row['kiraciUserName']);
        $stmt->bindParam(':tc', $row['kiracitc']);
        $stmt->bindParam(':phoneNumber', $row['kiraciPhone']);
        $stmt->bindParam(':userEmail', $row['kiraciEmail']);
        $stmt->execute();
    }

    echo "Veriler başarıyla eklendi.";
} catch (Exception $e) {
    echo 'Hata: ' . $e->getMessage();
}
?>