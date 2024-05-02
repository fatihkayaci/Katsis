<?php
require '../../../vendor/autoload.php';
include ("../../../DB/dbconfig.php");
session_start();
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'Ad Soyad');
$sheet->setCellValue('B1', 'Tc Kimlik');
$sheet->setCellValue('C1', 'Telefon Numarası');
$sheet->setCellValue('D1', 'Eposta');
$sheet->setCellValue('E1', 'Cinsiyet');
$sheet->setCellValue('F1', 'Öğrenim Durumu');
$sheet->setCellValue('G1', 'Iban');
$sheet->setCellValue('H1', 'İşe Başlama Tarihi');
$sheet->setCellValue('I1', 'Görevi');
$sheet->setCellValue('J1', 'Sigorta Numarası');
$sheet->setCellValue('K1', 'Maaş');
$sheet->setCellValue('L1', 'Birim');
$sheet->setCellValue('M1', 'Açılış Bakiyesi');
$sheet->setCellValue('N1', 'Bakiye tipi');
$sheet->setCellValue('O1', 'Ödeme Tarihi');

$header_style = $sheet->getStyle('A1:O1');
$header_style->getFont()->getColor()->setARGB('ffffff');
$header_style->getFont()->setBold(true);
$header_style->getFill()->setFillType(Fill::FILL_SOLID);
$header_style->getFill()->getStartColor()->setARGB('366092');
$header_style->getAlignment()->setHorizontal(Alignment::VERTICAL_CENTER);

$sheet->getColumnDimension('A')->setWidth(17);
$sheet->getColumnDimension('B')->setWidth(17);
$sheet->getColumnDimension('C')->setWidth(17);
$sheet->getColumnDimension('D')->setWidth(17);
$sheet->getColumnDimension('E')->setWidth(17);
$sheet->getColumnDimension('F')->setWidth(17);
$sheet->getColumnDimension('G')->setWidth(17);
$sheet->getColumnDimension('H')->setWidth(17);
$sheet->getColumnDimension('I')->setWidth(17);
$sheet->getColumnDimension('J')->setWidth(17);
$sheet->getColumnDimension('K')->setWidth(17);
$sheet->getColumnDimension('L')->setWidth(17);
$sheet->getColumnDimension('M')->setWidth(17);
$sheet->getColumnDimension('N')->setWidth(17);
$sheet->getColumnDimension('O')->setWidth(17);

/*kısıtlamalar başlangıç*/

$validGenderValues = ['Erkek', 'Kadın'];
// 'Durum' sütununun veri doğrulamasını tüm 'Durum' sütununa uygulayın
for ($row = 2; $row <= 1000; $row++) { // Sütunun kaç satıra kadar devam edeceğini belirtmek için 1000 kullanıldı, gerektiği kadar değiştirilebilir.
    $validation = $sheet->getCell('E' . $row)->getDataValidation();
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
header('Content-Disposition: attachment;filename="PersonelEkle.xlsx"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
?>
