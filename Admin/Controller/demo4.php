<?php
// Veritabanı yapılandırma dosyasını dahil ediyoruz
include("../../DB/dbconfig.php");

try {
    // Oturumu başlatıyoruz
    session_start();

    // POST verilerini alıyoruz ve JSON'dan diziye dönüştürüyoruz
    $selectedValuesArray = json_decode($_POST['selectedValuesArray'], true);
    $sql="";
    // Her bir seçili değer için döngü oluşturuyoruz
    foreach ($selectedValuesArray as $selectedValue) {
        $sql .= "SELECT d.blok_adi, d.daire_sayisi, b.blok_adi
        FROM tbl_daireler d
        INNER JOIN tbl_blok b ON d.blok_adi = b.blok_id
        WHERE d.apartman_id = :apartID 
        AND (d.kiraciID IS NULL OR d.katMalikiID IS NULL)
        AND (b.blok_adi != :selectedBlokAdi OR d.daire_sayisi != :selectedBlokNumarasi);";
    }

    $stmt = $conn->prepare($sql);

    // Her döngü geçişinde parametrelerinizi yeniden bağlamanız gerekecek
    foreach ($selectedValuesArray as $selectedValue) {
        $stmt->bindParam(':apartID', $_SESSION["apartID"]);
        // $selectedBlokAdi ve $selectedBlokNumarasi değerlerini belirlemelisiniz
        $stmt->bindParam(':selectedBlokAdi', $selectedBlokAdi);
        $stmt->bindParam(':selectedBlokNumarasi', $selectedBlokNumarasi);
    }

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo 1;
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
