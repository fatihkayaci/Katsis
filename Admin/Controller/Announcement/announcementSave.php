<?php
session_start();
include ("../../../DB/dbconfig.php");
require_once '../class.func.php';

try {
    // POST verilerini al
    $apartmanID = $_SESSION["apartID"];
    $announcementTitle = $_POST['announcementTitle'];
    $announcementContent = $_POST['announcementContent'];
    $lastDate = $_POST['lastDate'];
    $usingAnnouncement = $_POST['usingAnnouncement'];

    // Ay isimlerini Türkçe'den İngilizce'ye çevirme
    $turkishMonths = [
        'Ocak' => 'January', 'Şubat' => 'February', 'Mart' => 'March', 'Nisan' => 'April',
        'Mayıs' => 'May', 'Haziran' => 'June', 'Temmuz' => 'July', 'Ağustos' => 'August',
        'Eylül' => 'September', 'Ekim' => 'October', 'Kasım' => 'November', 'Aralık' => 'December'
    ];
    foreach ($turkishMonths as $turkish => $english) {
        $lastDate = str_replace($turkish, $english, $lastDate);
    }

    // Tarih formatını gün/ay/yıl'dan yıl/ay/gün'e dönüştür
    $date = DateTime::createFromFormat('d F Y', $lastDate);
    if ($date) {
        $lastDate = $date->format('Y-m-d'); // Veritabanı için yıl/ay/gün formatına dönüştür
        echo "Dönüştürülen lastDate: " . $lastDate . "<br>";
    } else {
        throw new Exception("Geçersiz tarih formatı: $lastDate");
    }

    // Dosya yükleme işlemi
    $filePath = null;
    if (isset($_FILES['announcementFile']) && $_FILES['announcementFile']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['announcementFile']['tmp_name'];
        $fileName = $_FILES['announcementFile']['name'];
        $uploadDir = 'Uploads/'; // Yüklemelerin kaydedileceği dizin
        $filePath = $uploadDir . $fileName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // Yükleme dizini yoksa oluşturun
        }

        if (move_uploaded_file($fileTmpPath, $filePath)) {
            echo "Dosya başarıyla yüklendi: " . $fileName . "<br>";
        } else {
            throw new Exception("Dosya yükleme hatası!");
        }
    }

    // Veritabanı işlemleri
    $sql = "INSERT INTO tbl_announcement (apartmanID, announcementTitle, announcementContent, lastDate, usingAnnouncement, announcementFilePath) 
            VALUES (:apartmanID, :announcementTitle, :announcementContent, :lastDate, :usingAnnouncement, :announcementFilePath)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':apartmanID', $apartmanID);
    $stmt->bindParam(':announcementTitle', $announcementTitle);
    $stmt->bindParam(':announcementContent', $announcementContent);
    $stmt->bindParam(':lastDate', $lastDate);
    $stmt->bindParam(':usingAnnouncement', $usingAnnouncement);
    $stmt->bindParam(':announcementFilePath', $filePath);
    $stmt->execute();

    echo "Duyuru başarıyla kaydedildi!";
} catch (Exception $e) {
    echo "Hata: " . $e->getMessage();
}
?>
