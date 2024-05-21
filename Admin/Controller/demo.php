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
    $resultsArrayKiraci = array(); // Kiracılar için olanlar
    $resultsArrayKatMaliki = array(); // Kat malikleri için olanlar
    $updatedBlocks = array(); 
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

        // Elde edilen kiracı ve kat maliki ID'lerini kullanarak ilgili kullanıcı bilgilerini çekin
        // Kiracı için
        $sqlKiraciBilgileri = "SELECT * FROM tbl_users WHERE userID = :kiraciID";
        $stmtKiraciBilgileri = $conn->prepare($sqlKiraciBilgileri);
        $stmtKiraciBilgileri->bindParam(':kiraciID', $kiraciID, PDO::PARAM_INT);
        $stmtKiraciBilgileri->execute();
        $kiraciBilgileri = $stmtKiraciBilgileri->fetch(PDO::FETCH_ASSOC);

        // Kat Maliki için
        $sqlKatMalikiBilgileri = "SELECT * FROM tbl_users WHERE userID = :katMalikiID";
        $stmtKatMalikiBilgileri = $conn->prepare($sqlKatMalikiBilgileri);
        $stmtKatMalikiBilgileri->bindParam(':katMalikiID', $katMalikiID, PDO::PARAM_INT);
        $stmtKatMalikiBilgileri->execute();
        $katMalikiBilgileri = $stmtKatMalikiBilgileri->fetch(PDO::FETCH_ASSOC);

        foreach ($durumArray as $durum) {
            if ($durum == "Kiracı") {
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
                
                // Kiracı için olanları ayrı bir diziye ekleyin
                $resultsArrayKiraci[] = array(
                    'blokElement' => $blokElement,
                    'kiraciID' => $kiraciID,
                    'userName' => isset($kiraciBilgileri['userName']) ? $kiraciBilgileri['userName'] : null,
                    'userEmail' => isset($kiraciBilgileri['userEmail']) ? $kiraciBilgileri['userEmail'] : null,
                    'gender' => isset($kiraciBilgileri['gender']) ? $kiraciBilgileri['gender'] : null,
                    'phoneNumber' => isset($kiraciBilgileri['phoneNumber']) ? $kiraciBilgileri['phoneNumber'] : null,
                    'plate' => isset($kiraciBilgileri['plate']) ? $kiraciBilgileri['plate'] : null,
                    'tc' => isset($kiraciBilgileri['tc']) ? $kiraciBilgileri['tc'] : null
                );
                
            } else if ($durum == "Kat Maliki") {
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
                
                // Kat maliki için olanları ayrı bir diziye ekleyin
                $resultsArrayKatMaliki[] = array(
                    'blokElement' => $blokElement,
                    'katMalikiID' => $katMalikiID,
                    'userName' => isset($katMalikiBilgileri['userName']) ? $katMalikiBilgileri['userName'] : null,
                    'userEmail' => isset($katMalikiBilgileri['userEmail']) ? $katMalikiBilgileri['userEmail'] : null,
                    'gender' => isset($katMalikiBilgileri['gender']) ? $katMalikiBilgileri['gender'] : null,
                    'phoneNumber' => isset($katMalikiBilgileri['phoneNumber']) ? $katMalikiBilgileri['phoneNumber'] : null,
                    'plate' => isset($katMalikiBilgileri['plate']) ? $katMalikiBilgileri['plate'] : null,
                    'tc' => isset($katMalikiBilgileri['tc']) ? $katMalikiBilgileri['tc'] : null
                );
            }
            break;
        }
    }
    $_SESSION['updatedStatuses'] = $updatedStatuses;
    $_SESSION['updatedBlocks'] = $updatedBlocks;
    $_SESSION['resultsArrayKiraci'] = $resultsArrayKiraci; // Kiracılar için olanlar
    $_SESSION['resultsArrayKatMaliki'] = $resultsArrayKatMaliki; // Kat malikleri için olanlar
    echo 1;
} catch (PDOException $e) {
    echo $e->getMessage(); // Hata mesajını ekrana yazdır
}
?>
