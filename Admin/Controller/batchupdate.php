
<?php
include("../../DB/dbconfig.php");

try {
    session_start();
    $userID = $_POST['userID'];
    $blok_adi = $_POST['blok_adi']; // Blok adını almak yerine blok_id'yi alıyoruz.
    $daire_sayisi = $_POST['daire_sayisi'];
    $durum = $_POST['durum'];
    $columnName = ($durum == "kiracı") ? "kiraciID" : "katMalikiID";
    //echo $blok_adi . "-" . $daire_sayisi . "-" . $durum."-".$userID;
    
    // Güncelleme SQL sorgusu
    $sql = "UPDATE tbl_daireler AS d
            INNER JOIN tbl_blok AS b ON d.blok_adi = b.blok_id
            SET d.$columnName = null
            WHERE b.blok_adi = :blok 
            AND d.daire_sayisi = :daire 
            AND d.apartman_id = :apartID
            AND d.$columnName = :userID"; // userID'yi null yap
    
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
