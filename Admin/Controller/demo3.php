<?php
include("../../DB/dbconfig.php");

try {
    session_start();
    $lastID = $_SESSION['lastID'];
    $toSend = json_decode($_POST['toSend']);

    foreach ($toSend as $data) {
        $userName = $data->userName;
        $durum = $data->durum;

        // Duruma göre güncelleme yapılacak sütunu seçme
        $columnName = ($durum == "kiracı") ? "kiraciID" : "katMalikiID";

        // Güncelleme SQL sorgusu
        $sql = "UPDATE tbl_daireler 
                SET $columnName = :lastID 
                WHERE blok_adi = :blok 
                AND daire_sayisi = :daire 
                AND apartman_id = " . $_SESSION["apartID"];

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':lastID', $lastID, PDO::PARAM_INT);
        $stmt->bindParam(':blok', $data->blok, PDO::PARAM_STR);
        $stmt->bindParam(':daire', $data->daire, PDO::PARAM_STR);
        $stmt->execute();
    }

    echo 1;
} catch (PDOException $e) {
    echo $e->getMessage(); // Hata mesajını ekrana yazdır
}
?>