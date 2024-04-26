<?php

/*
 echo "apartman_id: " . $apartman_id . "<br>";
    echo "userName: " . $userName . "<br>";
    echo "tc: " . $tc . "<br>";
    echo "phoneNumber: " . $phoneNumber . "<br>";
    echo "userEmail: " . $userEmail . "<br>";
    echo "gender: " . $gender . "<br>";
    echo "educationStatus: " . $educationStatus . "<br>";
    echo "iban: " . $iban . "<br>";
    echo "startingWorking: " . $startingWorking . "<br>";
    echo "task: " . $task . "<br>";
    echo "sigortaNo: " . $sigortaNo . "<br>";
    echo "salary: " . $salary . "<br>";
    echo "unit: " . $unit . "<br>";
    echo "openingBalance: " . $openingBalance . "<br>";
    echo "balanceType: " . $balanceType . "<br>";
    echo "promise: " . $promise . "<br>"; */

session_start();
include ("../../../DB/dbconfig.php");
require_once 'class.func.php';
try {
    //apartman_id, userName, tc, phoneNumber, userEmail, gender, educationStatus,iban, startingWorking, task, sigortaNo, salary, unit, openingBalance, balanceType, promise
    $apartman_id = $_POST['apartman_id'];
    $userName = $_POST['userName'];
    $tc = $_POST['tc'];
    $phoneNumber = $_POST['phoneNumber'];
    $userEmail = !empty($_POST['userEmail']) ? $_POST['userEmail'] : null;
    $gender = $_POST['gender'];
    $educationStatus = $_POST['educationStatus'];
    $iban = $_POST['iban'];
    $startingWorking = $_POST['startingWorking'];
    $task = $_POST['task'];
    $sigortaNo = $_POST['sigortaNo'];
    $salary = $_POST['salary'];
    $unit = $_POST['unit'];
    $openingBalance = !empty($_POST['openingBalance']) ? $_POST['openingBalance'] : null;
    $balanceType = !empty($_POST['balanceType']) ? $_POST['balanceType'] : null;
    $promise = !empty($_POST['promise']) ? $_POST['promise'] : null;


    $emailCheckSQL = "SELECT COUNT(*) FROM tbl_employed WHERE userEmail = :userEmail";
    $emailCheckStmt = $conn->prepare($emailCheckSQL);
    $emailCheckStmt->bindParam(':userEmail', $userEmail);
    $emailCheckStmt->execute();
    if ($emailCheckStmt->fetchColumn() > 0) {
        echo "Bu e-posta adresi zaten var. Lütfen farklı bir e-posta adresi seçiniz.";
    } else {
        $employeedPassword = randomPassword();
        $hashedPassword = base64_encode($employeedPassword);
        $userNO = generateUniqueUserID($conn);
       
        $sql = "INSERT INTO tbl_employed (apartman_id, userNO, employeedPassword, fullName, tc, phoneNumber, userEmail, gender, educationStatus, iban, startingWorking, task, sigortaNo, salary, unit, openingBalance, balanceType, promise) VALUES 
        (:apartman_id, :userNO, :employeedPassword, :fullName, :tc, :phoneNumber, :userEmail, :gender, :educationStatus, :iban, :startingWorking, :task, :sigortaNo, :salary, :unit, :openingBalance, :balanceType, :promise)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':apartman_id', $apartman_id);
        $stmt->bindParam(':userNO', $userNO);
        $stmt->bindParam(':employeedPassword', $hashedPassword);
        $stmt->bindParam(':fullName', $userName);
        $stmt->bindParam(':tc', $tc);
        $stmt->bindParam(':phoneNumber', $phoneNumber);
        $stmt->bindParam(':userEmail', $userEmail);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':educationStatus', $educationStatus);
        $stmt->bindParam(':iban', $iban);
        $stmt->bindParam(':startingWorking', $startingWorking);
        $stmt->bindParam(':task', $task);
        $stmt->bindParam(':sigortaNo', $sigortaNo);
        $stmt->bindParam(':salary', $salary);
        $stmt->bindParam(':unit', $unit);
        $stmt->bindParam(':openingBalance', $openingBalance);
        $stmt->bindParam(':balanceType', $balanceType);
        $stmt->bindParam(':promise', $promise);
        $stmt->execute();
    }
    echo 1;
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>