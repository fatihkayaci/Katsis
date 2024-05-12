<?php
require '../../vendor/autoload.php';
include ("../../DB/dbconfig.php");
session_start();
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'Blok Adi');
$sheet->setCellValue('B1', 'Daire No');
$sheet->setCellValue('C1', 'Durum');
$sheet->setCellValue('D1', 'Ad SoyAd');
$sheet->setCellValue('E1', 'Tc Kimlik');
$sheet->setCellValue('F1', 'Telefon Numarası');
$sheet->setCellValue('G1', 'Eposta');
$sheet->setCellValue('H1', 'Araç Plakası');
$sheet->setCellValue('I1', 'Cinsiyet');
$sheet->setCellValue('J1', 'Açılış Bakiyesi');
$sheet->setCellValue('K1', 'Bakiye tipi');
$sheet->setCellValue('L1', 'Ödeme Tarihi');

$header_style = $sheet->getStyle('A1:C1');
$header_style->getFont()->getColor()->setARGB('1c1c1c');
$header_style->getFont()->setBold(true);
$header_style->getFill()->setFillType(Fill::FILL_SOLID);
$header_style->getFill()->getStartColor()->setARGB('ffebcd');
$header_style->getAlignment()->setHorizontal(Alignment::VERTICAL_CENTER);

$header_style = $sheet->getStyle('D1:L1');
$header_style->getFont()->getColor()->setARGB('ffffff');
$header_style->getFont()->setBold(true);
$header_style->getFill()->setFillType(Fill::FILL_SOLID);
$header_style->getFill()->getStartColor()->setARGB('366092');
$header_style->getAlignment()->setHorizontal(Alignment::VERTICAL_CENTER);

$sheet->getColumnDimension('A')->setWidth(20);
$sheet->getColumnDimension('B')->setWidth(20);
$sheet->getColumnDimension('C')->setWidth(20);
$sheet->getColumnDimension('D')->setWidth(20);
$sheet->getColumnDimension('E')->setWidth(20);
$sheet->getColumnDimension('F')->setWidth(20);
$sheet->getColumnDimension('G')->setWidth(20);
$sheet->getColumnDimension('H')->setWidth(20);
$sheet->getColumnDimension('I')->setWidth(20);
$sheet->getColumnDimension('J')->setWidth(20);
$sheet->getColumnDimension('K')->setWidth(20);
$sheet->getColumnDimension('L')->setWidth(20);

/*kısıtlamalar başlangıç*/

// // 'Blok Adi' sütununa verileri veritabanından çek
// $blokAdiValues = []; // Veritabanından alınacak Blok Adi verilerinin saklanacağı dizi
// $sql = "SELECT DISTINCT b.*
// FROM tbl_daireler AS d
// INNER JOIN tbl_blok AS b ON d.blok_adi = b.blok_id
// WHERE d.apartman_id = " . $_SESSION["apartID"];

// $stmt = $conn->query($sql); // PDOStatement nesnesi oluştur

// if ($stmt) {
//     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//         $blokAdiValues[] = $row['blok_adi'];
//     }
// } else {
//     // Veritabanı sorgusunda bir hata oluştuğunda burada işlem yapabilirsiniz
//     echo "Veritabanı hatası: " . $conn->errorInfo()[2];
// }
// // 'Blok Adi' sütununa veri doğrulamasını uygula
// for ($row = 2; $row <= 1000; $row++) {
//     $validation = $sheet->getCell('A' . $row)->getDataValidation();
//     $validation->setType(DataValidation::TYPE_LIST)
//         ->setErrorStyle(DataValidation::STYLE_INFORMATION)
//         ->setAllowBlank(true)
//         ->setShowInputMessage(true)
//         ->setShowErrorMessage(true)
//         ->setShowDropDown(true)
//         ->setErrorTitle('Hatalı Giriş')
//         ->setError('Lütfen geçerli bir blok adı seçin.')
//         ->setPromptTitle('Blok Adi')
//         ->setPrompt('Blok Adi seçiniz.')
//         ->setFormula1('"'.implode(',', $blokAdiValues).'"');
// }

// $daireAdiValues = []; // Veritabanından alınacak Blok Adi verilerinin saklanacağı dizi
// $sqlDaire = "SELECT DISTINCT daire_sayisi
// FROM tbl_daireler 
// WHERE apartman_id = " . $_SESSION["apartID"];
// $stmt2 = $conn->query($sqlDaire); // PDOStatement nesnesi oluştur

// if ($stmt2) {
//     $daireAdiValues = array();
//     while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
//         $daireAdiValues[] = $row['daire_sayisi'];
//     }
//     // Her bir değeri yalnızca bir kere gösteren bir dizi elde etmek için array_unique kullan
//     $uniqueDaireAdiValues = array_unique($daireAdiValues);
// } else {
//     // Veritabanı sorgusunda bir hata oluştuğunda burada işlem yapabilirsiniz
//     echo "Veritabanı hatası: " . $conn->errorInfo()[2];
// }

// // 'Blok Adi' sütununa veri doğrulamasını uygula
// for ($row = 2; $row <= 1000; $row++) {
//     $validation = $sheet->getCell('B' . $row)->getDataValidation();
//     $validation->setType(DataValidation::TYPE_LIST)
//         ->setErrorStyle(DataValidation::STYLE_INFORMATION)
//         ->setAllowBlank(true)
//         ->setShowInputMessage(true)
//         ->setShowErrorMessage(true)
//         ->setShowDropDown(true)
//         ->setErrorTitle('Hatalı Giriş')
//         ->setError('Lütfen geçerli bir blok adı seçin.')
//         ->setPromptTitle('Blok Adi')
//         ->setPrompt('Blok Adi seçiniz.')
//         ->setFormula1('"'.implode(',', $uniqueDaireAdiValues).'"');
// }

// 'Durum' sütununda geçerli değerleri tanımlayın
$validStatusValues = ['Katmaliki', 'Kiracı'];
// 'Durum' sütununun veri doğrulamasını tüm 'Durum' sütununa uygulayın
for ($row = 2; $row <= 1000; $row++) { // Sütunun kaç satıra kadar devam edeceğini belirtmek için 1000 kullanıldı, gerektiği kadar değiştirilebilir.
    $validation = $sheet->getCell('C' . $row)->getDataValidation();
    $validation->setType(DataValidation::TYPE_LIST)
        ->setErrorStyle(DataValidation::STYLE_INFORMATION)
        ->setAllowBlank(true)
        ->setShowInputMessage(true)
        ->setShowErrorMessage(true)
        ->setShowDropDown(true)
        ->setErrorTitle('Hatalı Giriş')
        ->setError('Lütfen geçerli bir durum seçin.')
        ->setPromptTitle('Durum')
        ->setPrompt('Katmaliki veya Kiracı değerlerinden birini seçiniz.')
        ->setFormula1('"'.implode(',', $validStatusValues).'"');
}
// 'Durum' sütununda geçerli değerleri tanımlayın
$validGenderValues = ['Erkek', 'Kadın'];
// 'Durum' sütununun veri doğrulamasını tüm 'Durum' sütununa uygulayın
for ($row = 2; $row <= 1000; $row++) { // Sütunun kaç satıra kadar devam edeceğini belirtmek için 1000 kullanıldı, gerektiği kadar değiştirilebilir.
    $validation = $sheet->getCell('I' . $row)->getDataValidation();
    $validation->setType(DataValidation::TYPE_LIST)
        ->setErrorStyle(DataValidation::STYLE_INFORMATION)
        ->setAllowBlank(true)
        ->setShowInputMessage(true)
        ->setShowErrorMessage(true)
        ->setShowDropDown(true)
        ->setErrorTitle('Hatalı Giriş')
        ->setError('Lütfen geçerli bir cinsiyet seçin.')
        ->setPromptTitle('Cinsiyet')
        ->setPrompt('Kadın veya Erkek değerlerinden birini seçiniz.')
        ->setFormula1('"'.implode(',', $validGenderValues).'"');
}
/*kısıtlamalar bitiş*/

$writer = new Xlsx($spreadsheet);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="KullaniciEkle.xlsx"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
?>
