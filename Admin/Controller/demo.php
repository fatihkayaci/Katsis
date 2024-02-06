<?php
include("../../DB/dbconfig.php");

try {
    session_start();
    $sadeceBlok;
    $sadeceDaire;
    $lastID = $_SESSION['lastID'];
    $durumArray = json_decode($_POST['durumArray']);
    $blokArray = json_decode($_POST['blokArray'], true);

    //echo json_encode(array("durumArray" => $durumArray, "blokArray" => $blokArray));

    foreach ($blokArray as $blokElement) {
        $sadeceBlok = $blokElement['letter'];
        $sadeceDaire = $blokElement['number'];
        foreach($durumArray as $durum ){
            if ($durum == "kiracı") {
                $sql  = "UPDATE tbl_daireler
                         SET kiraciID = (SELECT userID FROM tbl_users WHERE userID = :lastID)
                         WHERE blok_adi = :sadeceBlok AND daire_sayisi = :sadeceDaire";
                         // PDO sorgusunu hazırla ve çalıştır
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':lastID', $lastID, PDO::PARAM_INT);
                        $stmt->bindParam(':sadeceBlok', $sadeceBlok, PDO::PARAM_STR);
                        $stmt->bindParam(':sadeceDaire', $sadeceDaire, PDO::PARAM_STR);
                        $stmt->execute();
                         break;
            } else if ($durum == "katmaliki") {
                $sql  = "UPDATE tbl_daireler
                         SET katmalikiID = (SELECT userID FROM tbl_users WHERE userID = :lastID)
                         WHERE blok_adi = :sadeceBlok AND daire_sayisi = :sadeceDaire";
                         // PDO sorgusunu hazırla ve çalıştır
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':lastID', $lastID, PDO::PARAM_INT);
                        $stmt->bindParam(':sadeceBlok', $sadeceBlok, PDO::PARAM_STR);
                        $stmt->bindParam(':sadeceDaire', $sadeceDaire, PDO::PARAM_STR);
                        $stmt->execute();
                         break;
            }
        }
        
    echo "blok: $sadeceBlok, daire: $sadeceDaire\n";
    }
    
    
    echo 1;
} catch (PDOException $e) {
    echo $e->getMessage(); // Hata mesajını ekrana yazdır
}
?>