<?php
include("../../DB/dbconfig.php");

try {
    session_start();
    $lastID = $_SESSION['lastID'];
    $blok_listesi = $_SESSION['blok_listesi'];
    $durum_listesi = $_SESSION['durum_listesi'];
    $blokArray = array();
    $daireArray = array();
   foreach($blok_listesi as $blok){
        $parcalanmis = explode("/", $blok);
        $blok = $parcalanmis[0]; // Blok kısmı
        $daire = $parcalanmis[1]; // Daire kısmı

        // Blok ve daireyi ilgili dizilere ekleyin
        $blokArray[] = $blok;
        $daireArray[] = $daire;
    }

    foreach($durum_listesi as $key => $durum ){
            if ($durum == "kiracı") {
                $sql  = "UPDATE tbl_daireler
                             SET kiraciID = (SELECT userID FROM tbl_users WHERE userID = :lastID)
                             WHERE blok_adi = :blok AND daire_sayisi = :daire AND apartman_id = " . $_SESSION["apartID"];
    
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':lastID', $lastID, PDO::PARAM_INT);
                $stmt->bindParam(':blok', $blokArray[$key], PDO::PARAM_STR);
                   $sql  = "UPDATE tbl_daireler
                             SET katMalikiID = (SELECT userID FROM tbl_users WHERE userID = :lastID)
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
$stmt->bindParam(':daire', $daireArray[$key], PDO::PARAM_STR);
                $stmt->execute();
            } else if ($durum == "katMaliki") {
            