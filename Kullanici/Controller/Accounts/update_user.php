<?php
include ("../../../DB/dbconfig.php");

try {
    // POST verilerini al
    $userID = $_POST['userID'];
    $userName = $_POST['userName'];
    $tc = $_POST['tc'];
    $phoneNumber = $_POST['phoneNumber'];
    // SQL sorgusunu hazırla
    $updateSQL = "UPDATE tbl_users SET 
             userName = :userName,
             tc = :tc,
            phoneNumber = :phoneNumber
            WHERE userID = :userID";

    $updateStmt = $conn->prepare($updateSQL);
    $updateStmt->bindParam(':userID', $userID);
    $updateStmt->bindParam(':userName', $userName);
    $updateStmt->bindParam(':tc', $tc);
    $updateStmt->bindParam(':phoneNumber', $phoneNumber);
    $updateStmt->execute();
    echo 1;
} catch (PDOException $e) {
    echo $e;
}
?>