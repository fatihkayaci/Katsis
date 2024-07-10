<?php
include ("../../../DB/dbconfig.php");
require_once 'class.func.php';
session_start();

$dataToSendJSON = $_POST['dataToSend'];
$dataToSend = json_decode($dataToSendJSON, true);
$rol = 6;
$popup = 0;
$durum = "Personel";
try {
    foreach ($dataToSend as $dataEntry) {
        $userPass = randomPassword();
        $hashedPassword = base64_encode($userPass);
        $userNO = generateUniqueUserID($conn);

        if (empty($dataEntry['userName'])) {
            continue; // Boş fullName değerine sahip veriyi atla ve bir sonraki veriye geç
        }
        $sql = "INSERT INTO tbl_users (apartman_id, user_no, userPass, userName, tc, phoneNumber, userEmail, popup, rol, durum, gender, educationStatus, Iban, startingWorking, task, sigortaNo, salary, openingBalance, balanceType, promise) VALUES 
        (:apartman_id, :user_no, :userPass, :userName, :tc, :phoneNumber, :userEmail, :popup, :rol, :durum, :gender, :educationStatus, :Iban, :startingWorking, :task, :sigortaNo, :salary, :openingBalance, :balanceType, :promise)";
          
        $stmt = $conn->prepare($sql);
        // Parametreleri bağla
        $stmt->bindParam(':apartman_id', $_SESSION["apartID"], PDO::PARAM_INT);
            $stmt->bindParam(':user_no', $userNO);
            $stmt->bindParam(':userPass', $hashedPassword);
            $stmt->bindParam(':userName', $dataEntry['userName']);
            $stmt->bindParam(':tc', $dataEntry['tc']);
            $stmt->bindParam(':phoneNumber', $dataEntry['phoneNumber']);
            $stmt->bindParam(':userEmail', $dataEntry['userEmail']);
            $stmt->bindParam(':popup', $popup);
            $stmt->bindParam(':rol', $rol);
            $stmt->bindParam(':durum', $durum);
            $stmt->bindParam(':gender', $dataEntry['gender']);
            $stmt->bindParam(':educationStatus', $dataEntry['educationStatus']);
            $stmt->bindParam(':Iban', $dataEntry['Iban']);
            $stmt->bindParam(':startingWorking', $dataEntry['startingWorking']);
            $stmt->bindParam(':task', $dataEntry['task']);
            $stmt->bindParam(':sigortaNo', $dataEntry['sigorta']);
            $stmt->bindParam(':salary', $dataEntry['salary']);
            $stmt->bindParam(':openingBalance', $dataEntry['openingBalance']);
            $stmt->bindParam(':balanceType', $dataEntry['balanceType']);
            $stmt->bindParam(':promise', $dataEntry['promise']);
        $stmt->execute();
    }
    echo "Personeller Başarıyla Kaydedilmiştir";
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>
