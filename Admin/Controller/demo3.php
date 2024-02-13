<?php
include("../../DB/dbconfig.php");

try {
    session_start();
    $lastID = $_SESSION['lastID'];
    $blokArray = json_decode($_POST['blokArray']);
    $daireArray = json_decode($_POST['daireArray']);
    $durumArray = json_decode($_POST['durumArray']);
    echo $lastID;
    foreach($durumArray as $key => $durum ){
        if ($durum == "kiracı") {
            $sql  = "UPDATE tbl_daireler
                         SET kiraciID = (SELECT userID FROM tbl_users WHERE userID = :lastID)
                         WHERE blok_adi = :blok AND daire_sayisi = :daire AND apartman_id = " . $_SESSION["apartID"];

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':lastID', $lastID, PDO::PARAM_INT);
            $stmt->bindParam(':blok', $blokArray[$key], PDO::PARAM_STR);
            $stmt->bindParam(':daire', $daireArray[$key], PDO::PARAM_STR);
            $stmt->execute();
        } else if ($durum == "kat Maliki") {
           $sql  = "UPDATE tbl_daireler
                         SET kiraciID = (SELECT userID FROM tbl_users WHERE userID = :lastID)
                         WHERE blok_adi = :blok AND daire_sayisi = :daire AND apartman_id = " . $_SESSION["apartID"];

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':lastID', $lastID, PDO::PARAM_INT);
            $stmt->bindParam(':blok', $blokArray[$key], PDO::PARAM_STR);
            $stmt->bindParam(':daire', $daireArray[$key], PDO::PARAM_STR);
            $stmt->execute();
        }
    }
    
    echo 1;
} catch (PDOException $e) {
    echo $e->getMessage(); // Hata mesajını ekrana yazdır
}
?>
