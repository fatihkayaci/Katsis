<?php
include ("../../DB/dbconfig.php");

try {
    session_start();
    $sadeceBlok;
    $sadeceDaire;
    $lastID = $_SESSION['lastID'];
    $durumArray = json_decode($_POST['durumArray']);
    $blokArray = json_decode($_POST['blokArray'], true);
    $updatedStatuses = array();
    $resultsArray = array(); 
    //echo json_encode(array("durumArray" => $durumArray, "blokArray" => $blokArray));
    foreach ($blokArray as $blokElement) {
        $sadeceBlok = $blokElement['letter'];
        $sadeceDaire = $blokElement['number'];
        $sqlKiraci = "SELECT d.kiraciID
        FROM tbl_daireler d
        INNER JOIN tbl_blok b ON d.blok_adi = b.blok_id
        WHERE b.blok_adi = :sadeceBlok AND d.daire_sayisi = :sadeceDaire AND d.apartman_id = " . $_SESSION["apartID"];
        $stmtKiraci = $conn->prepare($sqlKiraci);
        $stmtKiraci->bindParam(':sadeceBlok', $sadeceBlok, PDO::PARAM_STR);
        $stmtKiraci->bindParam(':sadeceDaire', $sadeceDaire, PDO::PARAM_STR);
        $stmtKiraci->execute();
        $kiraciID = $stmtKiraci->fetchColumn(); // Kiracı ID'sini al

        // Kat Maliki ID'sini al
        $sqlKatMaliki = "SELECT d.katmalikiID
           FROM tbl_daireler d
           INNER JOIN tbl_blok b ON d.blok_adi = b.blok_id
           WHERE b.blok_adi = :sadeceBlok AND d.daire_sayisi = :sadeceDaire AND d.apartman_id = " . $_SESSION["apartID"];
        $stmtKatMaliki = $conn->prepare($sqlKatMaliki);
        $stmtKatMaliki->bindParam(':sadeceBlok', $sadeceBlok, PDO::PARAM_STR);
        $stmtKatMaliki->bindParam(':sadeceDaire', $sadeceDaire, PDO::PARAM_STR);
        $stmtKatMaliki->execute();
        $katMalikiID = $stmtKatMaliki->fetchColumn(); // Kat Maliki ID'sini al

        // Elde edilen kiracı ve kat maliki ID'lerini kullanarak istediğiniz işlemi gerçekleştirebilirsiniz
        // Örneğin, bu ID'leri JSON formatında döndürebilirsiniz

        $resultsArray[] = array(
            'blokElement' => $blokElement,
            'kiraciID' => $kiraciID,
            'katMalikiID' => $katMalikiID
        );
        $updatedBlocks[] = $blokElement;
        // Her bir durum için işlem yapalım
        foreach ($durumArray as $durum) {
            if ($durum == "kiraci") {
                $sql = "UPDATE tbl_daireler d
                         INNER JOIN tbl_blok b ON d.blok_adi = b.blok_id
                         SET d.kiraciID = (SELECT userID FROM tbl_users WHERE userID = :lastID),
                             d.kiraciGiris = NOW() /* Güncelleme yapıldığı tarih */
                         WHERE b.blok_adi = :sadeceBlok AND d.daire_sayisi = :sadeceDaire AND d.apartman_id = " . $_SESSION["apartID"];
                // PDO sorgusunu hazırla ve çalıştır
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':lastID', $lastID, PDO::PARAM_INT);
                $stmt->bindParam(':sadeceBlok', $sadeceBlok, PDO::PARAM_STR);
                $stmt->bindParam(':sadeceDaire', $sadeceDaire, PDO::PARAM_STR);
                $stmt->execute();
                array_shift($durumArray);
                $updatedStatuses[] = "kiraci";
            } else if ($durum == "katmaliki") {
                $sql = "UPDATE tbl_daireler d
                         INNER JOIN tbl_blok b ON d.blok_adi = b.blok_id
                         SET d.katmalikiID = (SELECT userID FROM tbl_users WHERE userID = :lastID),
                             d.katMGiris = NOW() /* Güncelleme yapıldığı tarih */
                         WHERE b.blok_adi = :sadeceBlok AND d.daire_sayisi = :sadeceDaire AND d.apartman_id = " . $_SESSION["apartID"];
                // PDO sorgusunu hazırla ve çalıştır
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':lastID', $lastID, PDO::PARAM_INT);
                $stmt->bindParam(':sadeceBlok', $sadeceBlok, PDO::PARAM_STR);
                $stmt->bindParam(':sadeceDaire', $sadeceDaire, PDO::PARAM_STR);
                $stmt->execute();
                array_shift($durumArray);
                $updatedStatuses[] = "katmaliki";
            }
            break;
        }
        
    }
    $_SESSION['updatedStatuses'] = $updatedStatuses;
    $_SESSION['updatedBlocks'] = $updatedBlocks;
    $_SESSION['resultsArray'] = $resultsArray;
    echo 1;
} catch (PDOException $e) {
    echo $e->getMessage(); // Hata mesajını ekrana yazdır
}
?>