<?php
include("../../DB/dbconfig.php");

try {
    session_start();
    if (isset($_SESSION['blok_listesi']) && is_array($_SESSION['blok_listesi'])) {
        $blok_listesi = $_SESSION['blok_listesi'];
        foreach ($blok_listesi as $blok) {
            echo $blok . "<br>";
        }
    } else {
        echo "Blok listesi bulunamadı veya dizi değil.";
    }
} catch (PDOException $e) {
    echo $e->getMessage(); // Hata mesajını ekrana yazdır
}
?>
