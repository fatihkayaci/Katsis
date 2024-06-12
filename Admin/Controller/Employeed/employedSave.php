<?php

/*

    echo "Form Verileri Alındı:<br>";
    echo "Ad Soyad: " . htmlspecialchars($userName) . "<br>";
    echo "T.C. Kimlik No: " . htmlspecialchars($tc) . "<br>";
    echo "Telefon Numarası: " . htmlspecialchars($phoneNumber) . "<br>";
    echo "E-Posta: " . htmlspecialchars($userEmail) . "<br>";
    echo "Cinsiyet: " . htmlspecialchars($gender) . "<br>";
    echo "Öğrenim Durumu: " . htmlspecialchars($educationStatus) . "<br>";
    echo "IBAN: " . htmlspecialchars($iban) . "<br>";
    echo "İşe Giriş Tarihi: " . htmlspecialchars($startingWorking) . "<br>";
    echo "Görevi: " . htmlspecialchars($task) . "<br>";
    echo "Sigorta No: " . htmlspecialchars($sigortaNo) . "<br>";
    echo "Maaş: " . htmlspecialchars($salary) . "<br>";
    echo "Açılış Bakiyesi: " . htmlspecialchars($openingBalance) . "<br>";
    echo "Durum: " . htmlspecialchars($balanceStatus) . "<br>";
    echo "Eklenme Tarihi: " . htmlspecialchars($promise) . "<br>";
    echo "Onay Durumu: " . htmlspecialchars($onay) . "<br>";

 */
 

session_start();
include ("../../../DB/dbconfig.php");
require_once 'class.func.php';
try {
    //apartman_id, userName, tc, phoneNumber, userEmail, gender, educationStatus,iban, startingWorking, task, sigortaNo, salary, openingBalance, balanceType, promise
    $userName = $_POST['userName'] ?? '';
    $tc = $_POST['tc'] ?? '';
    $phoneNumber = $_POST['phoneNumber'] ?? '';
    $userEmail = $_POST['userEmail'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $educationStatus = $_POST['educationStatus'] ?? '';
    $iban = $_POST['iban'] ?? '';
    $startingWorking = $_POST['startingWorking'] ?? '';
    $task = $_POST['task'] ?? '';
    $sigortaNo = $_POST['sigortaNo'] ?? '';
    $salary = $_POST['salary'] ?? '';
    $onay = $_POST['onay'] ?? '';
    $openingBalance = $_POST['openingBalance'] ?? '';
    $balanceStatus = $_POST['balanceStatus'] ?? '';
    $promise = $_POST['promise'] ?? '';

    $rol = 6;
    $popup = 0;
    $durum = "Personel";
    if (empty($userEmail)) {
        // Burada boş e-posta durumuna göre işlemleri yapabilirsiniz
        // Örneğin, e-posta boşsa doğrudan kaydetme işlemini gerçekleştirin
        $employeedPassword = randomPassword();
        $hashedPassword = base64_encode($employeedPassword);
        $userNO = generateUniqueUserID($conn);
        
        $sql = "INSERT INTO tbl_users (apartman_id, user_no, userPass, userName, tc, phoneNumber, userEmail, popup, rol, durum, gender, educationStatus, Iban, startingWorking, task, sigortaNo, salary, openingBalance, balanceType, promise) VALUES 
        (:apartman_id, :user_no, :userPass, :userName, :tc, :phoneNumber, :userEmail, :popup, :rol, :durum, :gender, :educationStatus, :Iban, :startingWorking, :task, :sigortaNo, :salary, :openingBalance, :balanceType, :promise)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':apartman_id', $_SESSION["apartID"], PDO::PARAM_INT);
        $stmt->bindParam(':user_no', $userNO);
        $stmt->bindParam(':userPass', $hashedPassword);
        $stmt->bindParam(':userName', $userName);
        $stmt->bindParam(':tc', $tc);
        $stmt->bindParam(':phoneNumber', $phoneNumber);
        $stmt->bindParam(':userEmail', $userEmail);
        $stmt->bindParam(':popup', $popup);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':durum', $durum);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':educationStatus', $educationStatus);
        $stmt->bindParam(':Iban', $iban);
        $stmt->bindParam(':startingWorking', $startingWorking);
        $stmt->bindParam(':task', $task);
        $stmt->bindParam(':sigortaNo', $sigortaNo);
        $stmt->bindParam(':salary', $salary);
        $stmt->bindParam(':openingBalance', $openingBalance);
        $stmt->bindParam(':balanceType', $balanceStatus);
        $stmt->bindParam(':promise', $promise);
        $stmt->execute();
    } else {
        // E-posta adresi boş değilse, e-posta kontrolü yapın
        $emailCheckSQL = "SELECT COUNT(*) FROM tbl_users WHERE userEmail = :userEmail";
        $emailCheckStmt = $conn->prepare($emailCheckSQL);
        $emailCheckStmt->bindParam(':userEmail', $userEmail);
        $emailCheckStmt->execute();
        
        if ($emailCheckStmt->fetchColumn() > 0) {
            echo "Bu e-posta adresi zaten var. Lütfen farklı bir e-posta adresi seçiniz.";
        } else {
            $employeedPassword = randomPassword();
            $hashedPassword = base64_encode($employeedPassword);
            $userNO = generateUniqueUserID($conn);
    
            $sql = "INSERT INTO tbl_users (apartman_id, user_no, userPass, userName, tc, phoneNumber, userEmail, popup, rol, durum, gender, educationStatus, Iban, startingWorking, task, sigortaNo, salary, openingBalance, balanceType, promise) VALUES 
        (:apartman_id, :user_no, :userPass, :userName, :tc, :phoneNumber, :userEmail, :popup, :rol, :durum, :gender, :educationStatus, :Iban, :startingWorking, :task, :sigortaNo, :salary, :openingBalance, :balanceType, :promise)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':apartman_id', $_SESSION["apartID"], PDO::PARAM_INT);
            $stmt->bindParam(':user_no', $userNO);
            $stmt->bindParam(':userPass', $hashedPassword);
            $stmt->bindParam(':userName', $userName);
            $stmt->bindParam(':tc', $tc);
            $stmt->bindParam(':phoneNumber', $phoneNumber);
            $stmt->bindParam(':userEmail', $userEmail);
            $stmt->bindParam(':popup', $popup);
            $stmt->bindParam(':rol', $rol);
            $stmt->bindParam(':durum', $durum);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam(':educationStatus', $educationStatus);
            $stmt->bindParam(':Iban', $iban);
            $stmt->bindParam(':startingWorking', $startingWorking);
            $stmt->bindParam(':task', $task);
            $stmt->bindParam(':sigortaNo', $sigortaNo);
            $stmt->bindParam(':salary', $salary);
            $stmt->bindParam(':openingBalance', $openingBalance);
            $stmt->bindParam(':balanceType', $balanceStatus);
            $stmt->bindParam(':promise', $promise);
            $stmt->execute();
        }
    }
    echo 1;
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>