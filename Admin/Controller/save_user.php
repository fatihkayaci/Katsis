<?php
/*
durum boş ise email kontrolü yapmıyor.

*/
session_start();
include ("../../DB/dbconfig.php");
require_once 'class.func.php';
try {
    // POST verilerini al
    $userName = $_POST['userName'];
    $tc = $_POST['tc'];
    $phoneNumber = $_POST['phoneNumber'];
    $durumArray = json_decode($_POST['durumArray']);
    $userEmail = !empty($_POST['userEmail']) ? $_POST['userEmail'] : null;
    $apartman_id = $_POST['apartman_id'];
    $plate = $_POST['plate'];
    $gender = $_POST['gender'];
    $openingBalance = !empty($_POST['openingBalance']) ? $_POST['openingBalance'] : null;
    $balanceType = !empty($_POST['balanceType']) ? $_POST['balanceType'] : null;
    $promise = !empty($_POST['promise']) ? $_POST['promise'] : null;

    $elemanSayisi = count($durumArray);
    // DurumArray boşsa kayıt yapmayı dene
    if (empty($durumArray)) {
        $emailCheckSQL = "SELECT COUNT(*) FROM tbl_users WHERE userEmail = :userEmail";
        $emailCheckStmt = $conn->prepare($emailCheckSQL);
        $emailCheckStmt->bindParam(':userEmail', $userEmail);
        $emailCheckStmt->execute();

        if ($emailCheckStmt->fetchColumn() > 0) {
            echo "Bu e-posta adresi zaten var. Lütfen farklı bir e-posta adresi seçiniz.";
        } else {
            $userPass = randomPassword();
            $hashedPassword = base64_encode($userPass);
            $userNO = generateUniqueUserID($conn);
            $t = "Y";

            $sql = "INSERT INTO tbl_users (userName, user_no, tc, phoneNumber, durum, userEmail, userPass, plate, gender, apartman_id, rol, popup, userStatus, openingBalance, balanceType, promise) VALUES 
                (:userName, :user_no, :tc, :phoneNumber, :durum, :userEmail, :userPass, :plate, :gender, :apartman_id, :rol, :popup, :userStatus, :openingBalance, :balanceType, :promise)";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userName', $userName);
            $stmt->bindParam(':user_no', $userNO);
            $stmt->bindParam(':userPass', $hashedPassword);
            $stmt->bindParam(':tc', $tc);
            $stmt->bindParam(':phoneNumber', $phoneNumber);
            $stmt->bindValue(':durum', null, PDO::PARAM_NULL); // DurumArray boş olduğunda null atar
            $stmt->bindParam(':userEmail', $userEmail);
            $stmt->bindParam(':plate', $plate);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam(':userStatus', $t);
            $stmt->bindParam(':openingBalance', $openingBalance);
            $stmt->bindParam(':balanceType', $balanceType);
            $stmt->bindParam(':promise', $promise);
            $stmt->bindParam(':apartman_id', $apartman_id);
            $rol = 3;
            $popup = 0;
            $stmt->bindParam(':rol', $rol);
            $stmt->bindParam(':popup', $popup);
            $stmt->execute();
        }
        echo 1;
    } else {
        // DurumArray doluysa normal kayıt işlemlerini yap
        foreach ($durumArray as $durum) {
            // E-posta adresi kontrolü

            // E-posta adresi doluysa, benzersizlik kontrolü yap
            $emailCheckSQL = "SELECT COUNT(*) FROM tbl_users WHERE userEmail = :userEmail";
            $emailCheckStmt = $conn->prepare($emailCheckSQL);
            $emailCheckStmt->bindParam(':userEmail', $userEmail);
            $emailCheckStmt->execute();

            if ($emailCheckStmt->fetchColumn() > 0) {
                echo "Bu e-posta adresi zaten var. Lütfen farklı bir e-posta adresi seçiniz.";
            } else {
                // E-posta adresi benzersiz, kaydetmeye devam et
                $userPass = randomPassword();
                $hashedPassword = base64_encode($userPass);
                $userNO = generateUniqueUserID($conn);
                $t = "Y";
                $sql = "INSERT INTO tbl_users (userName, user_no, tc, phoneNumber, durum, userEmail, userPass, plate, gender, apartman_id, rol, popup, userStatus, openingBalance, balanceType, promise) VALUES 
                    (:userName, :user_no, :tc, :phoneNumber, :durum, :userEmail, :userPass, :plate, :gender, :apartman_id, :rol, :popup, :userStatus, :openingBalance, :balanceType, :promise)";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':userName', $userName);
                $stmt->bindParam(':user_no', $userNO);
                $stmt->bindParam(':tc', $tc);
                $stmt->bindParam(':phoneNumber', $phoneNumber);
                $stmt->bindParam(':durum', $durum);
                $stmt->bindParam(':userEmail', $userEmail);
                $stmt->bindParam(':userPass', $hashedPassword);
                $stmt->bindParam(':plate', $plate);
                $stmt->bindParam(':gender', $gender);
                $stmt->bindParam(':userStatus', $t);
                $stmt->bindParam(':openingBalance', $openingBalance);
                $stmt->bindParam(':balanceType', $balanceType);
                $stmt->bindParam(':promise', $promise);
                $stmt->bindParam(':apartman_id', $apartman_id);
                $rol = 3;
                $popup = 0;
                $stmt->bindParam(':rol', $rol);
                $stmt->bindParam(':popup', $popup);
                $stmt->execute();
                break;
            }
        }
        echo 1;
    }
    $_SESSION['lastID'] = $conn->lastInsertId();
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>