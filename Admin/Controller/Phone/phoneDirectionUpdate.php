<?php
session_start();
include ("../../../DB/dbconfig.php");
require_once '../class.func.php';

try {
    $phoneID = $_POST['phoneID'];
    $userName = $_POST['userName'];
    $unvan = $_POST['unvan'];
    $phoneNumber= $_POST['phoneNumber'];
    
    $sql = "UPDATE tbl_phone_directory
    SET userName = :userName,
        unvan = :unvan,
        phoneNumber = :phoneNumber
    WHERE phoneID = :phoneID";

    // PDO sorgusunu hazırla ve çalıştır
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':phoneID', $phoneID);
    $stmt->bindParam(':userName', $userName);
    $stmt->bindParam(':unvan', $unvan);
    $stmt->bindParam(':phoneNumber', $phoneNumber);
    $stmt->execute();
    echo "1";
} catch (PDOException $e) {
    echo $e;
}
?>