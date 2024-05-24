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

// açıklamalar

$sheet->setCellValue('E1', 'KULLANICI EKLEME DOSYASI');
$sheet->setCellValue('A2', 'Açıklamalar');
$sheet->setCellValue('A3', 'Kullanıcı Kaydı yapabilmeniz için gerekli olan bazı bilgiler.');
$sheet->setCellValue('A4', 'Uygulamaya excel dosyasını yüklerken eğer ki sütun isimleri ve sütun yerleri değiştirilir ise sistem kabul etmez ve hata verir. ');
$sheet->setCellValue('A5', 'öncelikle kullanıcı kayıt için mavi sütünlardan Ad SoyAd kısmı zorunluluğu vardır. Sarı sütunlarda ise hiçbir zorunluluk yoktur. Ama sarı sütunları doldurduğunuzda kolaylıkla daire atamasıda yapmış olacaksınızdır.');
$sheet->setCellValue('A6', 'Durum ve Cinsiyet için lütfen belirttiğimiz kelimeleri kullanınız. Sütuna geldiğiniz zaman açılır menüyü açıp oradan seçim yapabilir veya direkt olarak yazabilirsiniz.');
$sheet->setCellValue('A7', "Eğer ki bir kullanıcı için birden fazla daire ataması yapmak istersenizde o zaman Ad SoyAd ve Tc Kimlik sütunları dikkate alınacaktır. Eğer farklı olarak yazarsanız her birerini farklı kullanıcı olarak algılayacaktır. Eğer tc'sini bilmediğiniz ve vermek istemeyen kullanıcılar içinde herhangi bir sayı yazabilirsiniz ");
$sheet->setCellValue('A8', "Geri bildirimleriniz bizim için çok önemlidir. Geri bildirim ve şikayetler için lütfen demo@hotmail.com adresimizi kullanabilirsiniz.");

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
// $bgStyle->getFill()->getStartColor()->setARGB('FFFF00'); 


$sheet->freezePane('A12');
$sheet->setCellValue('A11', 'Blok Adi');
$sheet->setCellValue('B11', 'Daire No');
$sheet->setCellValue('C11', 'Durum');
$sheet->setCellValue('D11', 'Ad SoyAd');
$sheet->setCellValue('E11', 'Tc Kimlik');
$sheet->setCellValue('F11', 'Telefon Numarası');
$sheet->setCellValue('G11', 'Eposta');
$sheet->setCellValue('H11', 'Araç Plakası');
$sheet->setCellValue('I11', 'Cinsiyet');
$sheet->setCellValue('J11', 'Açılış Bakiyesi');
$sheet->setCellValue('K11', 'Bakiye tipi');
$sheet->setCellValue('L11', 'Ödeme Tarihi');

$header_style = $sheet->getStyle('A11:C11');
$header_style->getFont()->getColor()->setARGB('1c1c1c');
$header_style->getFont()->setBold(true);
$header_style->getFill()->setFillType(Fill::FILL_SOLID);
$header_style->getFill()->getStartColor()->setARGB('ffebcd');
$header_style->getAlignment()->setHorizontal(Alignment::VERTICAL_CENTER);

$header_style = $sheet->getStyle('D11:L11');
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


// TC Kimlik No uzunluğunu kontrol etmek için veri doğrulama ekleyin
for ($row = 12; $row <= 1000; $row++) {
    $tcValidation = $sheet->getCell('E'.$row)->getDataValidation();
    $tcValidation->setType(DataValidation::TYPE_CUSTOM)
        ->setErrorStyle(DataValidation::STYLE_STOP)
        ->setAllowBlank(true)
        ->setShowInputMessage(true)
        ->setShowErrorMessage(true)
        ->setShowDropDown(true)
        ->setErrorTitle('Hatalı Giriş')
        ->setError('TC Kimlik No 11 haneli olmalıdır.')
        ->setFormula1('=LEN(E'.$row.')=11'); // İlgili hücrenin uzunluğunu kontrol eder
}

for ($row = 12; $row <= 1000; $row++) { 
    $phoneValidation = $sheet->getCell('F'.$row)->getDataValidation();
    $phoneValidation->setType(DataValidation::TYPE_CUSTOM)
        ->setErrorStyle(DataValidation::STYLE_STOP)
        ->setAllowBlank(true)
        ->setShowInputMessage(true)
        ->setShowErrorMessage(true)
        ->setShowDropDown(true)
        ->setErrorTitle('Hatalı Giriş')
        ->setError('Telefon Numarası 10 haneli olmalıdır.')
        ->setFormula1('=LEN(F'.$row.')=10'); // İlgili hücrenin uzunluğunu kontrol eder
}

$validStatusValues = ['Katmaliki', 'Kiracı'];
for ($row = 12; $row <= 1000; $row++) { // Sütunun kaç satıra kadar devam edeceğini belirtmek için 1000 kullanıldı, gerektiği kadar değiştirilebilir.
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
for ($row = 12; $row <= 1000; $row++) { // Sütunun kaç satıra kadar devam edeceğini belirtmek için 1000 kullanıldı, gerektiği kadar değiştirilebilir.
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
