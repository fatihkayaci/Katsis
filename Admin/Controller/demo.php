<?php
include("../../DB/dbconfig.php");

try {
    session_start();

    $lastID = $_SESSION['lastID'];
    
    // BlokArray'i almak için
    $blokArrayJSON = $_POST['blokArray'];
    $blokArray = json_decode($blokArrayJSON, true);
    $durumArrayJSON = $_POST['durumArray'];
    $durumArray = json_decode($durumArrayJSON, true);
    print_r($blokArray);
    print_r($durumArray);
    if ($durum == "kiracı") {
        $sql  = "UPDATE tbl_daireler
                 SET kiraciID = (SELECT userID FROM tbl_users WHERE userID = :lastID)
                 WHERE blok_adi = :sadeceBlok AND daire_sayisi = :sadeceDaire";
    } else if ($durum == "katmaliki") {
        $sql  = "UPDATE tbl_daireler
                 SET katmalikiID = (SELECT userID FROM tbl_users WHERE userID = :lastID)
                 WHERE blok_adi = :sadeceBlok AND daire_sayisi = :sadeceDaire";
    }
    
    // PDO sorgusunu hazırla ve çalıştır
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':lastID', $lastID, PDO::PARAM_INT);
    $stmt->bindParam(':sadeceBlok', $sadeceBlok, PDO::PARAM_STR);
    $stmt->bindParam(':sadeceDaire', $sadeceDaire, PDO::PARAM_STR);
    $stmt->execute();
    echo 1;
} catch (PDOException $e) {
    echo $e->getMessage(); // Hata mesajını ekrana yazdır
}
?>