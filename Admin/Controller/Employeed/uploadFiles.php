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

            $fullName = $row['A'];
            $TC = $row['B'];
            $phoneNumber = $row['C'];
            $userEmail = $row['D'];
            $gender = $row['E'];
            $educationStatus = $row['F'];
            $Iban = $row['G'];
            $startingWorking = $row['H'];
            $task = $row['I'];
            $sigortaNo = $row['J'];
            $salary = $row['K'];
            $unit = $row['L'];
            $openingBalance = $row['M'];
            $balanceType = $row['N'];
            $promise = $row['O'];

            $Sql = "INSERT INTO tbl_employed (apartman_ID, userNo, employeedPassword, fullName, TC, phoneNumber, userEmail, gender, educationStatus, Iban, startingWorking, task, sigortaNo, salary, unit, openingBalance, balanceType, promise) VALUES 
                    (:apartman_ID, :userNo, :employeedPassword, :fullName, :TC, :phoneNumber, :userEmail, :gender, :educationStatus, :Iban, :startingWorking, :task, :sigortaNo, :salary, :unit, :openingBalance, :balanceType, :promise)";

            $Stmt = $conn->prepare($Sql);
            $Stmt->bindParam(':fullName', $fullName);
            $Stmt->bindParam(':TC', $TC);
            $Stmt->bindParam(':phoneNumber', $phoneNumber);
            $Stmt->bindParam(':userEmail', $userEmail);
            $Stmt->bindParam(':gender', $gender);
            $Stmt->bindParam(':educationStatus', $educationStatus);
            $Stmt->bindParam(':Iban', $Iban);
            $Stmt->bindParam(':startingWorking', $startingWorking);
            $Stmt->bindParam(':task', $task);
            $Stmt->bindParam(':sigortaNo', $sigortaNo);
            $Stmt->bindParam(':salary', $salary);
            $Stmt->bindParam(':unit', $unit);
            $Stmt->bindParam(':openingBalance', $openingBalance);
            $Stmt->bindParam(':balanceType', $balanceType);
            $Stmt->bindParam(':promise', $promise);
            $Stmt->bindParam(':apartman_ID', $_SESSION["apartID"], PDO::PARAM_INT);
            $Stmt->bindParam(':userNo', $userNO);
            $Stmt->bindParam(':employeedPassword', $hashedPassword);
            $Stmt->execute();
        }
        echo "Veriler başarıyla veritabanına kaydedildi.";
    } else {
        echo "Geçersiz dosya türü. Lütfen bir Excel dosyası yükleyin.";
    }
}

?>