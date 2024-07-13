
<?php
session_start(); // Session başlatma

include("../../../DB/dbconfig.php"); // Veritabanı bağlantı bilgilerini dahil et
require_once '../class.func.php'; // Fonksiyon dosyasını dahil et

try {
    $surveysID = $_POST['surveysID']; // POST ile gelen surveysID değerini al

    $sql2 = "SELECT * FROM tbl_surveys_options WHERE surveysID = :surveysID";
    
    // SQL sorgusunu hazırla ve parametreleri bağla
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bindParam(':surveysID', $surveysID);
    $stmt2->execute(); // Sorguyu çalıştır

    // Verileri JSON olarak döndür
    $options = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($options);
} catch (PDOException $e) {
    echo json_encode(array('error' => 'Veritabanı hatası: ' . $e->getMessage()));
}
?>
