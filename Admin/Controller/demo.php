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
            if ($durum == "kiraci") {
                $sql  = "UPDATE tbl_daireler d
                         INNER JOIN tbl_blok b ON d.blok_adi = b.blok_id
                         SET d.kiraciID = (SELECT userID FROM tbl_users WHERE userID = :lastID)
                         WHERE b.blok_adi = :sadeceBlok AND d.daire_sayisi = :sadeceDaire AND d.apartman_id = " . $_SESSION["apartID"];
                         // PDO sorgusunu hazırla ve çalıştır
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':lastID', $lastID, PDO::PARAM_INT);
                        $stmt->bindParam(':sadeceBlok', $sadeceBlok, PDO::PARAM_STR);
                        $stmt->bindParam(':sadeceDaire', $sadeceDaire, PDO::PARAM_STR);
                        $stmt->execute();
                         break;
            } else if ($durum == "katMaliki") {
                $sql  = "UPDATE tbl_daireler d
                         INNER JOIN tbl_blok b ON d.blok_adi = b.blok_id
                         SET d.katmalikiID = (SELECT userID FROM tbl_users WHERE userID = :lastID)
                         WHERE b.blok_adi = :sadeceBlok AND d.daire_sayisi = :sadeceDaire AND d.apartman_id = " . $_SESSION["apartID"];
                         // PDO sorgusunu hazırla ve çalıştır
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':lastID', $lastID, PDO::PARAM_INT);
                        $stmt->bindParam(':sadeceBlok', $sadeceBlok, PDO::PARAM_STR);
                        $stmt->bindParam(':sadeceDaire', $sadeceDaire, PDO::PARAM_STR);
                        $stmt->execute();
                        break;
            }
        }
    }
    echo 1;
} catch (PDOException $e) {
    echo $e->getMessage(); // Hata mesajını ekrana yazdır
}
?>