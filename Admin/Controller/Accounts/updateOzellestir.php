<?php
session_start();
include ("../../../DB/dbconfig.php");
require_once '../class.func.php';
try {
    $userID = $_POST['userID'];
    $userNo = $_POST['userNo'];
    $userName = $_POST['userName'];
    $phoneNumber=$_POST['phoneNumber']; 
    $gender= $_POST['gender'];
    $tc = $_POST['tc'];
    $password = base64_encode($_POST['password']);
    $userEmail = $_POST['userEmail'];
    $plate = $_POST['plate'];
    
    $updateSQL = "UPDATE tbl_users SET 
    user_no = :user_no,
    userName = :userName,
    tc = :tc,
    phoneNumber = :phoneNumber,
    gender = :gender,
    userPass = :userPass,
    userEmail = :userEmail,
    plate = :plate
    WHERE userID = :userID";

    $updateStmt = $conn->prepare($updateSQL);
    $updateStmt->bindParam(':userID', $userID);
    $updateStmt->bindParam(':user_no', $userNo);
    $updateStmt->bindParam(':userName', $userName);
    $updateStmt->bindParam(':tc', $tc);
    $updateStmt->bindParam(':phoneNumber', $phoneNumber);
    $updateStmt->bindParam(':gender', $gender);
    $updateStmt->bindParam(':userPass', $password);
    $updateStmt->bindParam(':userEmail', $userEmail);
    $updateStmt->bindParam(':plate', $plate);
    $updateStmt->execute();
    echo 1;
}catch (PDOException $e){
    echo $e;
}
?>