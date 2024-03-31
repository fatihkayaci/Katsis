<?php
include ("../../DB/dbconfig.php");

try {
    // 20 günden eski kayıtları sil
    $sql = "DELETE FROM tbl_arsive WHERE tarih < DATE_SUB(NOW(), INTERVAL 20 DAY)";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    echo "20 günden eski kayıtlar başarıyla silindi.";
} catch (PDOException $e) {
    // Hata durumunda hatayı ekrana yazdır
    echo "Hata: " . $e->getMessage();
}
?>