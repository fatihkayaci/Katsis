<?php

include ("../../../DB/dbconfig.php");
require 'vendor/autoload.php';
session_start();

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
$sql = "SELECT * FROM tbl_users ";
$Stmt = $conn->prepare($emailCheckSQL);
$Stmt->execute();
// Yeni bir Excel belgesi oluştur
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Tablo başlıklarını ekle
$sheet->setCellValue('A1', 'Ad Soyad');
$sheet->setCellValue('B1', 'TC');
$sheet->setCellValue('C1', 'Telefon Numarası');
$sheet->setCellValue('D1', 'Blok / Daire');
$sheet->setCellValue('E1', 'Durum');

// Veritabanından gelen verileri doldur
$row = 2; // Başlangıç satırı
foreach ($result as $data) {
    $sheet->setCellValue('A' . $row, $data['userName']);
    $sheet->setCellValue('B' . $row, $data['tc']);
    $sheet->setCellValue('C' . $row, $data['phoneNumber']);
    $sheet->setCellValue('D' . $row, $data['blok_adi'] . " / " . $data['daire_sayisi']);
    $sheet->setCellValue('E' . $row, $data['durum']);
    $row++;
}

// Excel dosyasını oluştur ve çıktı olarak gönder
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="tablo_verileri.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
?>
