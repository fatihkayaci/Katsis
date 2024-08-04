<?php
session_start();
include ("../../../DB/dbconfig.php");
require_once '../class.func.php';

try {
    $announcementID = $_POST['announcementID'];
    //echo $userID;
    // SQL sorgusunu hazırla
    $sql = "DELETE FROM tbl_announcement WHERE announcementID = :announcementID";

    // PDO sorgusunu hazırla ve çalıştır
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':announcementID', $announcementID);
    $stmt->execute();
    
    echo 1;
} catch (PDOException $e) {
    echo $e;
}
?>