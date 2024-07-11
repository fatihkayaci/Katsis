
<?php
session_start(); // Session başlatma

include("../../../DB/dbconfig.php"); // Veritabanı bağlantı bilgilerini dahil et
require_once '../class.func.php'; // Fonksiyon dosyasını dahil et

try {
    $surveysID = $_POST['surveysID']; // POST ile gelen surveysID değerini al

    // SQL sorgusu
    $sql = "SELECT * FROM tbl_surveys_options WHERE surveysID = :surveysID";
    
    // SQL sorgusunu hazırla ve parametreleri bağla
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':surveysID', $surveysID);
    $stmt->execute(); // Sorguyu çalıştır

    // Verileri JSON olarak döndür
    $options = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($options);
} catch (PDOException $e) {
    echo json_encode(array('error' => 'Veritabanı hatası: ' . $e->getMessage()));
}
?>
