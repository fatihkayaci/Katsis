<?php
session_start();
include ("../../../DB/dbconfig.php");
require_once '../class.func.php';

try {
    $phoneID = $_POST['phoneID'];
    //echo $userID;
    // SQL sorgusunu hazırla
    $sql = "DELETE FROM tbl_phone_directory WHERE phoneID = :phoneID";

    // PDO sorgusunu hazırla ve çalıştır
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':phoneID', $phoneID);
    $stmt->execute();
    
    echo 1;
} catch (PDOException $e) {
    echo $e;
}
?>