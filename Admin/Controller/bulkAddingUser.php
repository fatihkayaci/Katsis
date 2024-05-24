<?php
include ("../../DB/dbconfig.php");
require_once 'class.func.php';
session_start();

try {
    $newEntriesJSON = $_POST['newEntries'];
    $newEntries = json_decode($newEntriesJSON, true);
    $apartman_id = $_SESSION["apartID"];
    $userStatus = "Y";

    $blok_listesi = array();
    $durum_listesi = array();
    $userIds = array();
    $existingUserIds = array();

    $emailCheckSQL = "SELECT COUNT(*) FROM tbl_users WHERE userEmail = :userEmail";
    $emailCheckStmt = $conn->prepare($emailCheckSQL);

    $userCheckSQL = "SELECT userID FROM tbl_users WHERE userName = :userName AND tc = :tc";
    $userCheckStmt = $conn->prepare($userCheckSQL);

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
        echo $blok;
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

        $userCheckStmt->bindParam(':userName', $userName);
        $userCheckStmt->bindParam(':tc', $tc);
        $userCheckStmt->execute();
        $existingUserId = $userCheckStmt->fetchColumn();

        if ($existingUserId) {
            $columnName = ($durum == "kiraci") ? "kiraciID" : "katMalikiID";
            $parcalanmis = explode("/", $blok);
            $parcalanmisIlk = $parcalanmis[0];
            $parcalanmisSon= $parcalanmis[1];
            updateUserDaire($conn, $columnName, $existingUserId, $parcalanmisSon, $parcalanmisIlk, $apartman_id);
        } else {
            // Kullanıcı ekleme işlemini fonksiyon içine al
            $lastInsertedId = addUser($conn, $userName, $userPass, $tc, $telefon, $durum, $eposta, $plate, $gender, $openingBalance, $balanceType, $promise, $apartman_id, $userStatus);
            $columnName = ($durum == "kiraci") ? "kiraciID" : "katMalikiID";
            $parcalanmis = explode("/", $blok);
            $parcalanmisIlk = $parcalanmis[0];
            $parcalanmisSon= $parcalanmis[1];
            updateUserDaire($conn, $columnName, $existingUserId, $parcalanmisSon, $parcalanmisIlk, $apartman_id);
        }
    }

    echo "success";
} catch (PDOException $e) {
    echo "Hata oluştu: " . $e->getMessage();
}

function addUser($conn, $userName, $userPass, $tc, $telefon, $durum, $eposta, $plate, $gender, $openingBalance, $balanceType, $promise, $apartman_id, $userStatus)
{
    if (empty($eposta) || trim($eposta) === "") {
        $sql = "INSERT INTO tbl_users (user_no, userName, userPass, tc, phoneNumber, durum, userEmail, plate, gender, openingBalance, balanceType, promise, userStatus, apartman_id, rol, popup) VALUES 
            (:user_no, :userName, :userPass, :tc, :phoneNumber, :durum, NULL, :plate, :gender, :openingBalance, :balanceType, :promise, :userStatus, :apartman_id, :rol, :popup)";

        $stmt = $conn->prepare($sql);
    } else {
        $sql = "INSERT INTO tbl_users (user_no, userName, userPass, tc, phoneNumber, durum, userEmail, plate, gender, openingBalance, balanceType, promise, userStatus, apartman_id, rol, popup) VALUES 
        (:user_no, :userName, :userPass, :tc, :phoneNumber, :durum, :userEmail, :plate, :gender, :openingBalance, :balanceType, :promise, :userStatus, :apartman_id, :rol, :popup)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userEmail', $eposta);
    }

    $stmt = $conn->prepare($sql);
    $userPass = randomPassword();
    $hashedPassword = base64_encode($userPass);
    $userNO = generateUniqueUserID($conn);

    $stmt->bindParam(':user_no', $userNO);
    $stmt->bindParam(':userName', $userName);
    $stmt->bindParam(':userPass', $hashedPassword);
    $stmt->bindParam(':plate', $plate);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':tc', $tc);
    $stmt->bindParam(':phoneNumber', $telefon);
    $stmt->bindValue(':durum', $durum);
    $stmt->bindParam(':openingBalance', $openingBalance);
    $stmt->bindParam(':balanceType', $balanceType);
    $stmt->bindParam(':promise', $promise);
    $stmt->bindParam(':apartman_id', $apartman_id);
    $stmt->bindParam(':userStatus', $userStatus);
    $rol = 3;
    $popup = 0;
    $stmt->bindParam(':rol', $rol);
    $stmt->bindParam(':popup', $popup);

    $stmt->execute();

    return $conn->lastInsertId();
}

function updateUserDaire($conn, $columnName, $userId, $daire, $blok, $apartman_id)
{
    $sql = "UPDATE tbl_daireler AS d
            INNER JOIN tbl_blok AS b ON d.blok_adi = b.blok_id
            SET d.$columnName = :userID";

    if ($columnName === "kiraciID") {
        $sql .= ", d.kiraciGiris = NOW()";
    } elseif ($columnName === "katMalikiID") {
        $sql .= ", d.katMGiris = NOW()";
    }

    $sql .= " WHERE d.daire_sayisi = :daire 
              AND b.blok_adi = :blok
              AND d.apartman_id = :apartID
              AND d.$columnName IS NULL";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userID', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':daire', $daire, PDO::PARAM_STR);
    $stmt->bindParam(':blok', $blok, PDO::PARAM_STR);
    $stmt->bindParam(':apartID', $apartman_id, PDO::PARAM_INT);
    $stmt->execute();
}
?>