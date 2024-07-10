<?php
include ("../../../DB/dbconfig.php");
require_once 'class.func.php';
try {
    // POST verilerini al
    $userID = $_POST['userID'];
    $userName = $_POST['userName'];
    $tc = $_POST['tc'];
    $phoneNumber = $_POST['phoneNumber'];
    $userEmail = $_POST['userEmail'];
    $task = $_POST['task'];
    // SQL sorgusunu hazırla
    $updateSQL = "UPDATE tbl_users SET 
            userName = :userName,
            tc = :TC,
            phoneNumber = :phoneNumber,
            userEmail = :userEmail,
            task = :task
            WHERE userID = :userID";

    $updateStmt = $conn->prepare($updateSQL);
    $updateStmt->bindParam(':userID', $userID);
    $updateStmt->bindParam(':userName', $userName);
    $updateStmt->bindParam(':TC', $tc);
    $updateStmt->bindParam(':phoneNumber', $phoneNumber);
    $updateStmt->bindParam(':userEmail', $userEmail);
    $updateStmt->bindParam(':task', $task);
    $updateStmt->execute();
    echo "Personeller Başarıyla Güncellenmiştir.";
} catch (PDOException $e) {
    echo $e;
}
?>