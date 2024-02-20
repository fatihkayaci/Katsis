<?php
include("../../DB/dbconfig.php");

try {
    session_start();
    $userID = $_POST['userID'];
    $blok_adi = $_POST['blok_adi'];
    $daire_sayisi = $_POST['daire_sayisi'];
    $durum = $_POST['durum'];
    
    $columnName = ($durum == "kiracı") ? "kiraciID" : "katMalikiID";
    
    // Güncelleme SQL sorgusu
    $sql = "UPDATE tbl_daireler 
            SET $columnName = null
            WHERE blok_adi = :blok 
            AND daire_sayisi = :daire 
            AND apartman_id = :apartID
            AND $columnName = :userID"; // userID'yi null yap
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->bindParam(':blok', $blok_adi, PDO::PARAM_STR);
    $stmt->bindParam(':daire', $daire_sayisi, PDO::PARAM_STR);
    $stmt->bindParam(':apartID', $_SESSION["apartID"], PDO::PARAM_INT);
    $stmt->execute();

    echo 1;
} catch (PDOException $e) {
    echo $e->getMessage(); // Hata mesajını ekrana yazdır
}
?>
