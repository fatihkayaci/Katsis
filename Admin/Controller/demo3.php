<?php
include("../../DB/dbconfig.php");

try {
    session_start();
    $blok_listesi = $_SESSION['blok_listesi'];
    $durum_listesi = $_SESSION['durum_listesi'];

    echo "Güncelleme işlemi başarılı.";
} catch (PDOException $e) {
    echo "Hata oluştu: " . $e->getMessage(); // Hata mesajını ekrana yazdır
}
?>
