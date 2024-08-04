<?php
session_start();
include ("../../../DB/dbconfig.php");
require_once '../class.func.php';

try {
    // POST verilerini al
    if (isset($_POST['userName'], $_POST['unvan'], $_POST['phoneNumber'])) {
        $apartmanID = $_SESSION['apartID'];
        $userName= $_POST['userName'];
        $unvan = $_POST['unvan'];
        $phoneNumber = $_POST['phoneNumber'];

        $sql = "INSERT INTO tbl_phone_directory (apartmanID, userName, unvan, phoneNumber) 
        VALUES (:apartmanID, :userName, :unvan, :phoneNumber)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':apartmanID', $apartmanID);
        $stmt->bindParam(':userName', $userName);
        $stmt->bindParam(':unvan', $unvan);
        $stmt->bindParam(':phoneNumber', $phoneNumber);
        $stmt->execute();

    } else {
        echo "Gerekli POST verileri eksik.";
    }
} catch (PDOException $e) {
    echo "Veritabanı hatası: " . $e->getMessage();
} catch (Exception $e) {
    echo "Hata: " . $e->getMessage();
}
?>
 