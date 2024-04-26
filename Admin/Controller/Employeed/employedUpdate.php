<?php
include ("../../../DB/dbconfig.php");

try {
    // POST verilerini al
    $userID = $_POST['userID'];
    $fullName = $_POST['fullName'];
    $phoneNumber = $_POST['phoneNumber'];
    $userEmail = $_POST['userEmail'];
    $task = $_POST['task'];
    // SQL sorgusunu hazırla
    $updateSQL = "UPDATE tbl_employed SET 
            fullName = :fullName,
            phoneNumber = :phoneNumber,
            userEmail = :userEmail,
            task = :task
            WHERE userID = :userID";

    $updateStmt = $conn->prepare($updateSQL);
    $updateStmt->bindParam(':userID', $userID);
    $updateStmt->bindParam(':fullName', $fullName);
    $updateStmt->bindParam(':phoneNumber', $phoneNumber);
    $updateStmt->bindParam(':userEmail', $userEmail);
    $updateStmt->bindParam(':task', $task);
    $updateStmt->execute();
    echo 1;
} catch (PDOException $e) {
    echo $e;
}
?>