<?php
session_start();
include ("../../../DB/dbconfig.php");
require_once '../class.func.php';

try {
    // POST verilerini al
    $userName = $_POST['userName'];
    $tc = $_POST['tc'];
    $phoneNumber = $_POST['phoneNumber'];
    $durumArray = json_decode($_POST['durumArray']);
    $userEmail = !empty($_POST['userEmail']) ? $_POST['userEmail'] : null;
    $apartman_id = $_SESSION["apartID"];
    $plate = $_POST['plate'];
    $gender = $_POST['gender'] ?? '';
    $password = $_POST['password'];
    $openingBalance = !empty($_POST['openingBalance']) ? $_POST['openingBalance'] : null;
    $balanceType = !empty($_POST['balanceStatus']) ? $_POST['balanceStatus'] : null;
    $promise = !empty($_POST['promise']) ? $_POST['promise'] : null;
    $blokArray = json_decode($_POST['blokArray'], true);
    $resultsArrayKiraci = array(); // Kiracılar için olanlar
    $resultsArrayKatMaliki = array(); // Kat malikleri için olanlar
    // Kullanıcıyı kontrol et
    $sqlCheck = "SELECT userID FROM tbl_users WHERE userName = :userName AND tc = :tc";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bindParam(':userName', $userName);
    $stmtCheck->bindParam(':tc', $tc);
    $stmtCheck->execute();
    $userExists = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if ($userExists) {
        // Kullanıcı mevcut, tbl_daireler tablosunu güncelle
        $userID = $userExists['userID'];
    } else {
        // Yeni kullanıcı ekleme
        $userNO = generateUniqueUserID($conn);
        $t = "Y";

        if (empty($durumArray)) {
            $sql = "INSERT INTO tbl_users (userName, user_no, tc, phoneNumber, durum, userEmail, userPass, plate, gender, apartman_id, rol, popup, userStatus, openingBalance, balanceType, promise) VALUES 
                (:userName, :user_no, :tc, :phoneNumber, :durum, :userEmail, :userPass, :plate, :gender, :apartman_id, :rol, :popup, :userStatus, :openingBalance, :balanceType, :promise)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userName', $userName);
            $stmt->bindParam(':user_no', $userNO);
            $stmt->bindParam(':userPass', $password);
            $stmt->bindParam(':tc', $tc);
            $stmt->bindParam(':phoneNumber', $phoneNumber);
            $stmt->bindValue(':durum', null, PDO::PARAM_NULL);
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
            $userID = $conn->lastInsertId();
        } else {
            foreach ($durumArray as $durum) {
                $sql = "INSERT INTO tbl_users (userName, user_no, tc, phoneNumber, durum, userEmail, userPass, plate, gender, apartman_id, rol, popup, userStatus, openingBalance, balanceType, promise) VALUES 
                    (:userName, :user_no, :tc, :phoneNumber, :durum, :userEmail, :userPass, :plate, :gender, :apartman_id, :rol, :popup, :userStatus, :openingBalance, :balanceType, :promise)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':userName', $userName);
                $stmt->bindParam(':user_no', $userNO);
                $stmt->bindParam(':tc', $tc);
                $stmt->bindParam(':phoneNumber', $phoneNumber);
                $stmt->bindParam(':durum', $durum);
                $stmt->bindParam(':userEmail', $userEmail);
                $stmt->bindParam(':userPass', $password);
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
                $userID = $conn->lastInsertId();
                break;
            }
        }
    }

    // Blok ve daire bilgilerini güncelle
    foreach ($blokArray as $blokElement) {
        $sadeceBlok = $blokElement['letter'];
        $sadeceDaire = $blokElement['number'];

        $sqlKiraci = "SELECT d.kiraciID
        FROM tbl_daireler d
        INNER JOIN tbl_blok b ON d.blok_adi = b.blok_id
        WHERE b.blok_adi = :sadeceBlok AND d.daire_sayisi = :sadeceDaire AND d.apartman_id = " . $_SESSION["apartID"];
        $stmtKiraci = $conn->prepare($sqlKiraci);
        $stmtKiraci->bindParam(':sadeceBlok', $sadeceBlok, PDO::PARAM_STR);
        $stmtKiraci->bindParam(':sadeceDaire', $sadeceDaire, PDO::PARAM_STR);
        $stmtKiraci->execute();
        $kiraciID = $stmtKiraci->fetchColumn(); // Kiracı ID'sini al

        // Kat Maliki ID'sini al
        $sqlKatMaliki = "SELECT d.katmalikiID
           FROM tbl_daireler d
           INNER JOIN tbl_blok b ON d.blok_adi = b.blok_id
           WHERE b.blok_adi = :sadeceBlok AND d.daire_sayisi = :sadeceDaire AND d.apartman_id = " . $_SESSION["apartID"];
        $stmtKatMaliki = $conn->prepare($sqlKatMaliki);
        $stmtKatMaliki->bindParam(':sadeceBlok', $sadeceBlok, PDO::PARAM_STR);
        $stmtKatMaliki->bindParam(':sadeceDaire', $sadeceDaire, PDO::PARAM_STR);
        $stmtKatMaliki->execute();
        $katMalikiID = $stmtKatMaliki->fetchColumn(); // Kat Maliki ID'sini al

        // Elde edilen kiracı ve kat maliki ID'lerini kullanarak ilgili kullanıcı bilgilerini çekin
        // Kiracı için
        $sqlKiraciBilgileri = "SELECT * FROM tbl_users WHERE userID = :kiraciID";
        $stmtKiraciBilgileri = $conn->prepare($sqlKiraciBilgileri);
        $stmtKiraciBilgileri->bindParam(':kiraciID', $kiraciID, PDO::PARAM_INT);
        $stmtKiraciBilgileri->execute();
        $kiraciBilgileri = $stmtKiraciBilgileri->fetch(PDO::FETCH_ASSOC);

        // Kat Maliki için
        $sqlKatMalikiBilgileri = "SELECT * FROM tbl_users WHERE userID = :katMalikiID";
        $stmtKatMalikiBilgileri = $conn->prepare($sqlKatMalikiBilgileri);
        $stmtKatMalikiBilgileri->bindParam(':katMalikiID', $katMalikiID, PDO::PARAM_INT);
        $stmtKatMalikiBilgileri->execute();
        $katMalikiBilgileri = $stmtKatMalikiBilgileri->fetch(PDO::FETCH_ASSOC);

        if (in_array("Kiracı", $durumArray)) {
            $sql = "UPDATE tbl_daireler d
                     INNER JOIN tbl_blok b ON d.blok_adi = b.blok_id
                     SET d.kiraciID = :userID,
                         d.kiraciGiris = NOW()
                     WHERE b.blok_adi = :sadeceBlok AND d.daire_sayisi = :sadeceDaire AND d.apartman_id = :apartman_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->bindParam(':sadeceBlok', $sadeceBlok, PDO::PARAM_STR);
            $stmt->bindParam(':sadeceDaire', $sadeceDaire, PDO::PARAM_STR);
            $stmt->bindParam(':apartman_id', $apartman_id);
            $stmt->execute();
            
            array_shift($durumArray);
            $updatedStatuses[] = "kiraci";
            // Kiracı için olanları ayrı bir diziye ekleyin
                $resultsArrayKiraci[] = array(
                    'blokElement' => $blokElement,
                    'kiraciID' => $kiraciID,
                    'userName' => isset($kiraciBilgileri['userName']) ? $kiraciBilgileri['userName'] : null,
                    'userEmail' => isset($kiraciBilgileri['userEmail']) ? $kiraciBilgileri['userEmail'] : null,
                    'gender' => isset($kiraciBilgileri['gender']) ? $kiraciBilgileri['gender'] : null,
                    'phoneNumber' => isset($kiraciBilgileri['phoneNumber']) ? $kiraciBilgileri['phoneNumber'] : null,
                    'plate' => isset($kiraciBilgileri['plate']) ? $kiraciBilgileri['plate'] : null,
                    'tc' => isset($kiraciBilgileri['tc']) ? $kiraciBilgileri['tc'] : null
                );
        } else if (in_array("Kat Maliki", $durumArray)) {
            $sql = "UPDATE tbl_daireler d
                     INNER JOIN tbl_blok b ON d.blok_adi = b.blok_id
                     SET d.katmalikiID = :userID,
                         d.katMGiris = NOW()
                     WHERE b.blok_adi = :sadeceBlok AND d.daire_sayisi = :sadeceDaire AND d.apartman_id = :apartman_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->bindParam(':sadeceBlok', $sadeceBlok, PDO::PARAM_STR);
            $stmt->bindParam(':sadeceDaire', $sadeceDaire, PDO::PARAM_STR);
            $stmt->bindParam(':apartman_id', $apartman_id);
            $stmt->execute();
            array_shift($durumArray);
            $updatedStatuses[] = "katmaliki";
            
              // Kat maliki için olanları ayrı bir diziye ekleyin
              $resultsArrayKatMaliki[] = array(
                'blokElement' => $blokElement,
                'katMalikiID' => $katMalikiID,
                'userName' => isset($katMalikiBilgileri['userName']) ? $katMalikiBilgileri['userName'] : null,
                'userEmail' => isset($katMalikiBilgileri['userEmail']) ? $katMalikiBilgileri['userEmail'] : null,
                'gender' => isset($katMalikiBilgileri['gender']) ? $katMalikiBilgileri['gender'] : null,
                'phoneNumber' => isset($katMalikiBilgileri['phoneNumber']) ? $katMalikiBilgileri['phoneNumber'] : null,
                'plate' => isset($katMalikiBilgileri['plate']) ? $katMalikiBilgileri['plate'] : null,
                'tc' => isset($katMalikiBilgileri['tc']) ? $katMalikiBilgileri['tc'] : null
            );
        }
    }
    $_SESSION['updatedStatuses'] = $updatedStatuses;
    $_SESSION['updatedBlocks'] = $updatedBlocks;
    $_SESSION['resultsArrayKiraci'] = $resultsArrayKiraci; // Kiracılar için olanlar
    $_SESSION['resultsArrayKatMaliki'] = $resultsArrayKatMaliki; // Kat malikleri için olanlar
    $_SESSION['lastID'] = $userID;
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>
