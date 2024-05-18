<?php
include ("../../DB/dbconfig.php");
require_once 'class.func.php';
session_start();
// şifre ve mail kısmına bakılacak
$newEntriesJSON = $_POST['newEntries'];
$newEntries = json_decode($newEntriesJSON, true);
$apartman_id = $_SESSION["apartID"];
$userStatus = "Y";
$blok_listesi = array();
$durum_listesi = array();
$userIds = array(); // Kullanıcı ID'lerini saklamak için bir dizi oluştur
$emailCheckSQL = "SELECT COUNT(*) FROM tbl_users WHERE userEmail = :userEmail";
$emailCheckStmt = $conn->prepare($emailCheckSQL);

foreach ($newEntries as $entry) {
    $eposta = $entry['eposta'];
    $emailCheckStmt->bindParam(':userEmail', $eposta);
    $emailCheckStmt->execute();

    if ($emailCheckStmt->fetchColumn() > 0) {
        echo "Bu e-posta adresi zaten var. Lütfen farklı bir e-posta adresi seçiniz.";
        exit;
    }
}

foreach ($newEntries as $entry) {
    $blok = $entry['blok'];
    $userName = $entry['userName'];
    $durum = $entry['durum'];
    $tc = $entry['tc'];
    $telefon = $entry['telefon'];
    $eposta = $entry['eposta'];
    $plate = $entry['plate'];
    $gender = $entry['gender'];
    $openingBalance = $entry['openingBalance'];
    $balanceType = $entry['balanceType'];
    $promise = $entry['promise'];
    $userPass = randomPassword();
    $hashedPassword = base64_encode($userPass);
    $userNO = generateUniqueUserID($conn);
    if (empty($eposta) || trim($eposta) === "") {
        $sql = "INSERT INTO tbl_users (user_no, userName,userPass, tc, phoneNumber, durum, userEmail, plate, gender, openingBalance, balanceType, promise, userStatus, apartman_id, rol, popup) VALUES 
            (:user_no, :userName,:userPass, :tc, :phoneNumber, :durum, :userEmail, :plate, :gender, :openingBalance, :balanceType, :promise, :userStatus, :apartman_id, :rol, :popup)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userEmail', $eposta, PDO::PARAM_NULL);
    } else {
        $sql = "INSERT INTO tbl_users (user_no, userName, userPass, tc, phoneNumber, durum, userEmail, plate, gender, openingBalance, balanceType, promise, userStatus, apartman_id, rol, popup) VALUES 
        (:user_no, :userName,:userPass, :tc, :phoneNumber, :durum, :userEmail, :plate, :gender, :openingBalance, :balanceType, :promise, :userStatus, :apartman_id, :rol, :popup)";


        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userEmail', $eposta);
    }

    $stmt->bindParam(':user_no', $userNO);
    $stmt->bindParam(':userName', $userName);
    $stmt->bindParam(':userPass', $userPass);
    $stmt->bindParam(':plate', $plate);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':tc', $tc);
    $stmt->bindParam(':phoneNumber', $telefon);
    $stmt->bindValue(':durum', $durum);
    $stmt->bindParam('openingBalance', $openingBalance);
    $stmt->bindParam('balanceType', $balanceType);
    $stmt->bindParam('promise', $promise);
    $stmt->bindParam(':apartman_id', $apartman_id);
    $stmt->bindParam(':userStatus', $userStatus);
    $rol = 3;
    $popup = 0;
    $stmt->bindParam(':rol', $rol);
    $stmt->bindParam(':popup', $popup);

    $stmt->execute();

    $blok_listesi[] = $blok;
    $durum_listesi[] = $durum;

    $lastInsertedId = $conn->lastInsertId();
    $userIds[] = $lastInsertedId;
}

$_SESSION['blok_listesi'] = $blok_listesi;
$_SESSION['durum_listesi'] = $durum_listesi;
$_SESSION['userIds'] = $userIds;

echo 'success';
?>