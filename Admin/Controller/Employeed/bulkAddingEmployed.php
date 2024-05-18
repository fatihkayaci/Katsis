<?php
include ("../../../DB/dbconfig.php");
require_once 'class.func.php';
session_start();

$dataToSendJSON = $_POST['dataToSend'];
$dataToSend = json_decode($dataToSendJSON, true);
$apartman_id = $_SESSION["apartID"];
try {
    foreach ($dataToSend as $dataEntry) {
        $userPass = randomPassword();
        $hashedPassword = base64_encode($userPass);
        $userNO = generateUniqueUserID($conn);

        if (empty($dataEntry['fullName'])) {
            continue; // Boş fullName değerine sahip veriyi atla ve bir sonraki veriye geç
        }
        $sql = "INSERT INTO tbl_employed (apartman_ID, userNO, employeedPassword, fullName, TC, gender, userEmail, phoneNumber, educationStatus, Iban, startingWorking, task, sigortaNo, salary, unit, openingBalance, balanceType, promise)
         VALUES (:apartman_ID, :userNO, :employeedPassword, :fullName, :TC, :gender, :userEmail, :phoneNumber, :educationStatus, :Iban, :startingWorking, :task, :sigortaNo, :salary, :unit, :openingBalance, :balanceType, :promise)";
          
        $stmt = $conn->prepare($sql);
        // Parametreleri bağla
        $stmt->bindParam(':apartman_ID', $_SESSION["apartID"]);
        $stmt->bindParam(':userNO', $userNO);
        $stmt->bindParam(':employeedPassword', $hashedPassword);
        $stmt->bindParam(':fullName', $dataEntry['fullName']);
        $stmt->bindParam(':TC', $dataEntry['TC']);
        $stmt->bindParam(':gender', $dataEntry['gender']);
        $stmt->bindParam(':userEmail', $dataEntry['userEmail']);
        $stmt->bindParam(':phoneNumber', $dataEntry['phoneNumber']);
        $stmt->bindParam(':educationStatus', $dataEntry['educationStatus']);
        $stmt->bindParam(':Iban', $dataEntry['Iban']);
        $stmt->bindParam(':startingWorking', $dataEntry['startingWorking']);
        $stmt->bindParam(':task', $dataEntry['task']);
        $stmt->bindParam(':sigortaNo', $dataEntry['sigortaNo']);
        $stmt->bindParam(':salary', $dataEntry['salary']);
        $stmt->bindParam(':unit', $dataEntry['unit']);
        $stmt->bindParam(':openingBalance', $dataEntry['openingBalance']);
        $stmt->bindParam(':balanceType', $dataEntry['balanceType']);
        $stmt->bindParam(':promise', $dataEntry['promise']);
        $stmt->execute();
    }

    echo "success";
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>
