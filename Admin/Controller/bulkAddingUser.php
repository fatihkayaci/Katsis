<?php
include ("../../DB/dbconfig.php");
require_once 'class.func.php';
session_start();
// şifre ve mail kısmına bakılacak
$newEntriesJSON = $_POST['newEntries'];
$newEntries = json_decode($newEntriesJSON, true);
$apartman_id = $_SESSION["apartID"];
$userStatus = "Y";
$userNO = generateUniqueUserID($conn);
$blok_listesi = array();
$durum_listesi = array();
$userIds = array(); // Kullanıcı ID'lerini saklamak için bir dizi oluştur
$i = 0;
foreach ($newEntries as $entry) {
    $userPass = randomPassword();
    $blok = $entry['blok'];
    $userName = $entry['userName'];
    $durum = $entry['durum'];
    $tc = $entry['tc'];
    $telefon = $entry['telefon'];
    $eposta = $entry['eposta'];
    if (empty($eposta) || trim($eposta) === "") {
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
        $stmt->bindParam(':phoneNumber', $telefon);
        $stmt->bindValue(':durum', $durum);
        $stmt->bindValue(':userEmail', null, PDO::PARAM_NULL);
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
    } else {
        $emailCheckSQL = "SELECT COUNT(*) FROM tbl_users WHERE userEmail = :userEmail";
        $emailCheckStmt = $conn->prepare($emailCheckSQL);
        $emailCheckStmt->bindParam(':userEmail', $eposta);
        $emailCheckStmt->execute();
        if ($emailCheckStmt->fetchColumn() > 0) {
            echo "Bu e-posta adresi zaten var. Lütfen farklı bir e-posta adresi seçiniz.";
        } else {
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
            $stmt->bindParam(':phoneNumber', $telefon);
            $stmt->bindValue(':durum', $durum);
            $stmt->bindValue(':userEmail', $eposta);
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
    }
}
$_SESSION['blok_listesi'] = $blok_listesi;
$_SESSION['durum_listesi'] = $durum_listesi;
$_SESSION['userIds'] = $userIds;
// Eğer her şey başarılıysa, 'success' mesajını döndür
echo 'success';  
?>