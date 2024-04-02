<?php
include("../../DB/dbconfig.php");
require_once 'class.func.php';
session_start();
$newEntriesJSON = $_POST['newEntries'];
$newEntries = json_decode($newEntriesJSON, true);
$apartman_id = $_SESSION["apartID"];
$userStatus="Y";
$userNO = generateUniqueUserID( $conn);
$userPass = randomPassword();
foreach ($newEntries as $entry) {
    $userName = $entry['userName'];
    $durum = $entry['durum'];
    $tc = $entry['tc'];
    $telefon = $entry['telefon'];
    $eposta = $entry['eposta'];
    
    // SQL sorgusu
    $sql = "INSERT INTO tbl_users (user_no, userName,userPass, tc, phoneNumber, durum, userEmail, userStatus, apartman_id, rol, popup) VALUES 
            (:user_no, :userName,:userPass, :tc, :phoneNumber, :durum, :userEmail, :userStatus, :apartman_id, :rol, :popup)";

    // Sorguyu hazırla
    $stmt = $conn->prepare($sql);

    // Parametreleri bağla
    $stmt->bindParam(':user_no', $userNO);
    $stmt->bindParam(':userName', $userName);
    $stmt->bindParam(':userPass', $userPass);
    $stmt->bindParam(':tc', $tc);
    $stmt->bindParam(':phoneNumber', $phoneNumber);
    $stmt->bindValue(':durum', null, PDO::PARAM_NULL);
    $stmt->bindValue(':userEmail', null, PDO::PARAM_NULL);
    $stmt->bindParam(':apartman_id', $apartman_id);
    $stmt->bindParam(':userStatus', $userStatus);
    $rol = 3;
    $popup = 0;
    $stmt->bindParam(':rol', $rol);
    $stmt->bindParam(':popup', $popup);

    // Sorguyu çalıştır
    $stmt->execute();
}

// Eğer her şey başarılıysa, 'success' mesajını döndür
echo 'success';
?>
