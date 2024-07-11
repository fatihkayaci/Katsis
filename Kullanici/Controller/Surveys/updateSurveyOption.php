<?php
session_start(); // Session başlatma

include("../../../DB/dbconfig.php"); // Veritabanı bağlantı bilgilerini dahil et
require_once '../class.func.php'; // Fonksiyon dosyasını dahil et

try {
    $surveysID = $_POST['surveysID']; // POST ile gelen surveysID değerini al
    $optionID = $_POST['optionID'];   // POST ile gelen optionID değerini al

    // Önce voteCount'u artırmak için güncelleme SQL sorgusu
    $sql = "UPDATE tbl_surveys_options SET voteCount = voteCount + 1 WHERE surveysID = :surveysID AND optionID = :optionID";
    
    // SQL sorgusunu hazırla ve parametreleri bağla
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':surveysID', $surveysID);
    $stmt->bindParam(':optionID', $optionID);
    $stmt->execute(); // Sorguyu çalıştır

    // Başarılı güncelleme mesajı gönder
    echo json_encode(array('success' => 'Vote count güncellendi'));

} catch (PDOException $e) {
    // Hata durumunda JSON formatında hata mesajı gönder
    echo json_encode(array('error' => 'Veritabanı hatası: ' . $e->getMessage()));
}
?>
