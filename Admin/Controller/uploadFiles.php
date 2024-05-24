<?php
session_start();
include ("../../DB/dbconfig.php");
require '../../vendor/autoload.php'; // PhpSpreadsheet kütüphanesi
require_once 'class.func.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// tbl_user tablosundan ad ve tc verilerini çekin
$sql = "SELECT userID, userName, tc FROM tbl_users WHERE apartman_id = " . $_SESSION["apartID"];
$stmt = $conn->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verileri diziye ekleyin
$userArray = array();
foreach ($users as $user) {
    $userArray[] = array('userName' => $user['userName'], 'tc' => $user['tc']);
}

if (isset($_FILES['excel_file']['name'])) {
    $file_name = $_FILES['excel_file']['name'];
    $file_tmp = $_FILES['excel_file']['tmp_name'];
    $file_type = $_FILES['excel_file']['type'];

    if ($file_type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
        $reader = IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load($file_tmp);
        $sheet = $spreadsheet->getActiveSheet();
        $sheetData = $sheet->toArray(null, true, true, true);

        // Dosya yapısını kontrol et
        $expectedHeaders = [
            'A' => 'Blok Adi',
            'B' => 'Daire No',
            'C' => 'Durum',
            'D' => 'Ad SoyAd',
            'E' => 'Tc Kimlik',
            'F' => 'Telefon Numarası',
            'G' => 'Eposta',
            'H' => 'Araç Plakası',
            'I' => 'Cinsiyet',
            'J' => 'Açılış Bakiyesi',
            'K' => 'Bakiye tipi',
            'L' => 'Ödeme Tarihi'
        ];

        $isValid = true;
        foreach ($expectedHeaders as $column => $header) {
            if ($sheetData[1][$column] !== $header) {
                $isValid = false;
                break;
            }
        }

        if (!$isValid) {
            echo "Geçersiz dosya yapısı. Lütfen doğru dosyayı yükleyin.";
            exit();
        }

        // Dosya yapısı doğruysa veritabanına kaydetme işlemi
        array_shift($sheetData);
        $userIds = [];
        $lastUserId = 0;
        $blok_id = 0;
        $updatedId = 0;

        $existingBlocks = array();
        $existingNumber = array();
        $newBlocks = array();

        $selectBlocksSql = "SELECT blok_adi FROM tbl_blok WHERE apartman_idd = " . $_SESSION["apartID"];
        $selectBlocksStmt = $conn->prepare($selectBlocksSql);
        $selectBlocksStmt->execute();
        $blocks = $selectBlocksStmt->fetchAll(PDO::FETCH_COLUMN);

        foreach ($blocks as $block) {
            $existingBlocks[] = $block;
        }

        $selectNoSql = "SELECT b.blok_adi, d.daire_sayisi 
                        FROM tbl_daireler AS d
                        INNER JOIN tbl_blok AS b ON d.blok_adi = b.blok_id
                        WHERE d.apartman_id = :apartman_id";

        $selectNoStmt = $conn->prepare($selectNoSql);
        $selectNoStmt->bindParam(':apartman_id', $_SESSION["apartID"]);
        $selectNoStmt->execute();
        $number = $selectNoStmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($number as $no) {
            $existingNumber[] = array(
                'blok_adi' => $no['blok_adi'],
                'daire_sayisi' => $no['daire_sayisi']
            );
        }

        foreach ($sheetData as $row) {
            if (empty($row['D'])) {
                continue;
            }
            $t = "Y";
            $rol = 3;
            $popup = 0;
            $userPass = randomPassword();
            $hashedPassword = base64_encode($userPass);
            $userNO = generateUniqueUserID($conn);

            $blok_adi = $row['A'];
            $daireNo = $row['B'];
            $durum = strtolower(trim($row['C']));
            $userName = $row['D'];
            $tc = $row['E'];
            $phoneNumber = $row['F'];
            $userEmail = $row['G'];
            $plate = $row['H'];
            $gender = $row['I'];

            if (!in_array($blok_adi, $existingBlocks)) {
                $insertBlokSql = "INSERT INTO tbl_blok (blok_adi, daire_sayisi, apartman_idd) VALUES (:blok_adi, :daire_sayisi, :apartman_idd)";
                $insertBlokStmt = $conn->prepare($insertBlokSql);
                $insertBlokStmt->bindParam(':blok_adi', $blok_adi);
                $insertBlokStmt->bindParam(':daire_sayisi', $daireNo);
                $insertBlokStmt->bindParam(':apartman_idd', $_SESSION["apartID"], PDO::PARAM_INT);
                $insertBlokStmt->execute();

                $blok_id = $conn->lastInsertId();
                $existingBlocks[] = $blok_adi;
            } else {
                $updateBlokSql = "UPDATE tbl_blok SET daire_sayisi = GREATEST(daire_sayisi, :daire_sayisi) WHERE blok_adi = :blok_adi AND apartman_idd = " . $_SESSION["apartID"];
                $updateBlokStmt = $conn->prepare($updateBlokSql);
                $updateBlokStmt->bindParam(':blok_adi', $blok_adi);
                $updateBlokStmt->bindParam(':daire_sayisi', $daireNo);
                $updateBlokStmt->execute();

                $selectSql = "SELECT blok_id FROM tbl_blok WHERE blok_adi = :blok_adi AND apartman_idd = :apartman_id";
                $selectStmt = $conn->prepare($selectSql);
                $selectStmt->bindParam(':blok_adi', $blok_adi);
                $selectStmt->bindParam(':apartman_id', $_SESSION["apartID"]);
                $selectStmt->execute();
                $updatedId = $selectStmt->fetchColumn();
            }

            if (!in_array(array('blok_adi' => $blok_adi, 'daire_sayisi' => $daireNo), $existingNumber)) {
                if ($blok_id > 0) {
                    $insertDaireSql = "INSERT INTO tbl_daireler (apartman_id, blok_adi, daire_sayisi) VALUES (:apartman_id, :blok_adi, :daire_sayisi)";
                    $insertDaireStmt = $conn->prepare($insertDaireSql);
                    $insertDaireStmt->bindParam(':blok_adi', $blok_id);
                    $insertDaireStmt->bindParam(':daire_sayisi', $daireNo);
                    $insertDaireStmt->bindParam(':apartman_id', $_SESSION["apartID"], PDO::PARAM_INT);
                    $insertDaireStmt->execute();
                } else if ($updatedId > 0) {
                    $insertDaireSql = "INSERT INTO tbl_daireler (apartman_id, blok_adi, daire_sayisi) VALUES (:apartman_id, :blok_adi, :daire_sayisi)";
                    $insertDaireStmt = $conn->prepare($insertDaireSql);
                    $insertDaireStmt->bindParam(':blok_adi', $updatedId);
                    $insertDaireStmt->bindParam(':daire_sayisi', $daireNo);
                    $insertDaireStmt->bindParam(':apartman_id', $_SESSION["apartID"], PDO::PARAM_INT);
                    $insertDaireStmt->execute();
                } else {
                    echo "Hatalı giriş yapılmıştır.";
                }
            }
            $userIdentity = array('userName' => $userName, 'tc' => $tc);
            if (!in_array($userIdentity, $userIds) && !array_search($userIdentity, array_column($userArray, null, 'tc')) || empty($tc) ) {
                $userIds[] = $userIdentity;
                if ($durum === "kiracı") {
                    $durum = "kiraci";
                } else {
                    $durum = "katMaliki";
                }

                $insertSql = "INSERT INTO tbl_users (durum, userStatus, rol, popup, user_no, userPass, userName, tc, phoneNumber, userEmail, plate, gender, apartman_id) VALUES 
                          (:durum, :userStatus, :rol, :popup, :user_no, :userPass, :userName, :tc, :phoneNumber, :userEmail, :plate, :gender, :apartman_id)";
                $insertStmt = $conn->prepare($insertSql);
                $insertStmt->bindParam(':durum', $durum);
                $insertStmt->bindParam(':userName', $userName);
                $insertStmt->bindParam(':tc', $tc);
                $insertStmt->bindParam(':phoneNumber', $phoneNumber);
                $insertStmt->bindParam(':userEmail', $userEmail);
                $insertStmt->bindParam(':plate', $plate);
                $insertStmt->bindParam(':gender', $gender);
                $insertStmt->bindParam(':userStatus', $t);
                $insertStmt->bindParam(':rol', $rol);
                $insertStmt->bindParam(':popup', $popup);
                $insertStmt->bindParam(':userPass', $hashedPassword);
                $insertStmt->bindParam(':user_no', $userNO);
                $insertStmt->bindParam(':apartman_id', $_SESSION["apartID"], PDO::PARAM_INT);
                $insertStmt->execute();

                // Son eklenen kullanıcının ID'sini alın
                $lastUserId = $conn->lastInsertId();
            } else {
                // Kullanıcı mevcut, ID'sini al
                $selectSql = "SELECT userID FROM tbl_users WHERE tc = :tc AND userName = :userName";
                $selectStmt = $conn->prepare($selectSql);
                $selectStmt->bindParam(':tc', $tc);
                $selectStmt->bindParam(':userName', $userName);
                $selectStmt->execute();

                if ($selectStmt->rowCount() > 0) {
                    $userRow = $selectStmt->fetch(PDO::FETCH_ASSOC);
                    $lastUserId = $userRow['userID'];
                }
            }
            // Önce diğer tabloyu güncelleyin
            $columnName = (strtolower(trim($durum)) == "kiraci") ? "kiraciID" : "katMalikiID";

            $updateSql = "UPDATE tbl_daireler AS d
            INNER JOIN tbl_blok AS b ON d.blok_adi = b.blok_id
            SET d.$columnName = :userID
            WHERE d.daire_sayisi = :daire 
              AND b.blok_adi = :blok
              AND d.apartman_id = :apartID
              AND d.$columnName IS NULL";

            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bindParam(':daire', $daireNo);
            $updateStmt->bindParam(':blok', $blok_adi);
            $updateStmt->bindParam(':apartID', $_SESSION["apartID"], PDO::PARAM_INT);
            $updateStmt->bindParam(':userID', $lastUserId); // Son eklenen kullanıcı ID'sini kullanın
            $updateStmt->execute();
        }

        echo "Kullanıcılar başarıyla yüklendi!";
    } else {
        echo "Geçersiz dosya türü. Lütfen bir Excel dosyası yükleyin.";
    }
} else {
    echo "Lütfen bir dosya seçin.";
}
?>