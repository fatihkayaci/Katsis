<?php
// PhpSpreadsheet kütüphanesini dahil et
session_start();
include ("../../../DB/dbconfig.php");
require '../../../vendor/autoload.php'; // PhpSpreadsheet kütüphanesi
require_once 'class.func.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Excel'den verileri yükleme işlemi
if (isset($_FILES['excel_file']['name'])) {
    $file_name = $_FILES['excel_file']['name'];
    $file_tmp = $_FILES['excel_file']['tmp_name'];
    $file_type = $_FILES['excel_file']['type'];

    $rol = 6;
    $popup = 0;
    $durum = "Personel";
    if ($file_type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
        $reader = IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load($file_tmp);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        // İlk 9 satırı atlayın
        for ($i = 0; $i < 9; $i++) {
            array_shift($sheetData);
        }
        // Excel'den okunan verileri veritabanına ekleyin
        foreach ($sheetData as $row) {
            if (empty($row['A'])) {
                continue; // Tam ad doluysa, kayıt işlemi yapmadan sonraki adıma geç
            }
            $userPass = randomPassword();
            $hashedPassword = base64_encode($userPass);
            $userNO = generateUniqueUserID($conn);

            $userName = $row['A'];
            $tc = $row['B'];
            $phoneNumber = $row['C'];
            $userEmail = $row['D'];
            $gender = $row['E'];
            $educationStatus = $row['F'];
            $iban = $row['G'];
            $startingWorking = $row['H'];
            $task = $row['I'];
            $sigortaNo = $row['J'];
            $salary = $row['K'];
            $unit = $row['L'];
            $openingBalance = $row['M'];
            $balanceStatus = $row['N'];
            $promise = $row['O'];

            
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
        echo "Veriler başarıyla veritabanına kaydedildi.";
    } else {
        echo "Geçersiz dosya türü. Lütfen bir Excel dosyası yükleyin.";
    }
}

?>