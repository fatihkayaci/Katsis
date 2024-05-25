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

$sheet->setCellValue('E1', 'PERSONEL EKLEME DOSYASI');
$sheet->setCellValue('A2', 'Açıklamalar');
$sheet->setCellValue('A3', 'Personel Kaydı yapabilmeniz için gerekli olan bazı bilgiler.');
$sheet->setCellValue('A4', 'Herhangi bir kayıt işlemi için lütfen AD Soyad sütununu doldurunuz. Ad Soyad sütunu dolu olmayan satırlar için bir kayıt oluşturulmayacaktır.');
$sheet->setCellValue('A5', 'Sütun isimleri ve sütun yerlerini lütfen değiştirmeyiniz. Sistem kabul etmez ve hata verir.');
$sheet->setCellValue('A6', "Geri bildirimleriniz bizim için çok önemlidir. Geri bildirim ve şikayetler için lütfen demo@hotmail.com adresimizi kullanabilirsiniz.");

// Başlık css
$titleStyle = $sheet->getStyle('E1');
$titleFont = $titleStyle->getFont();
$titleFont->setSize(18); // Yazı tipi boyutunu ayarla
$titleFont->getColor()->setARGB('FF2c3b8f'); // Yazı rengini belirle (örneğin kırmızı)

//altBaşlık
$subHeaderStyle = $sheet->getStyle('A2');
$subHeaderFont = $subHeaderStyle->getFont();
$titleFont->setBold(true); // Kalınlaştırma
$subHeaderFont->setSize(15); // Yazı tipi boyutunu ayarla
$subHeaderFont->getColor()->setARGB('FF2c3b8f'); // Yazı rengini belirle (başlık ile aynı)
$subHeaderFont->setUnderline(true); // Altı çizili yap

//açıklamalar background style
$bgStyle = $sheet->getStyle('C1:I1');
$bgStyle->getFill()->setFillType(Fill::FILL_SOLID);

$sheet->freezePane('A10');
$sheet->setCellValue('A9', 'Ad Soyad');
$sheet->setCellValue('B9', 'Tc Kimlik');
$sheet->setCellValue('C9', 'Telefon Numarası');
$sheet->setCellValue('D9', 'Eposta');
$sheet->setCellValue('E9', 'Cinsiyet');
$sheet->setCellValue('F9', 'Öğrenim Durumu');
$sheet->setCellValue('G9', 'Iban');
$sheet->setCellValue('H9', 'İşe Başlama Tarihi');
$sheet->setCellValue('I9', 'Görevi');
$sheet->setCellValue('J9', 'Sigorta Numarası');
$sheet->setCellValue('K9', 'Maaş');
$sheet->setCellValue('L9', 'Birim');
$sheet->setCellValue('M9', 'Açılış Bakiyesi');
$sheet->setCellValue('N9', 'Bakiye tipi');
$sheet->setCellValue('O9', 'Ödeme Tarihi');

$header_style = $sheet->getStyle('A9:O9');
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
for ($row = 10; $row <= 1000; $row++) { // Sütunun kaç satıra kadar devam edeceğini belirtmek için 1000 kullanıldı, gerektiği kadar değiştirilebilir.
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
