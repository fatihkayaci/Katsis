<?php
include("../../DB/dbconfig.php");

try {
    session_start();
    $addedUserIds =  $_SESSION['addedUserIds'];
    $toSend = json_decode($_POST['toSend']);

    foreach ($toSend as $data) {
        $userName = $data->userName;
        $durum = $data->durum;

        // Duruma göre güncelleme yapılacak sütunu seçme
        $columnName = ($durum == "kiracı") ? "kiraciID" : "katMalikiID";
        
        // Güncellenecek kullanıcının ID'si
        $userID = array_shift($addedUserIds);
        
        // Güncelleme SQL sorgusu
        $sql = "UPDATE tbl_daireler AS d 
        INNER JOIN tbl_blok AS b ON d.blok_adi = b.blok_id
                SET $columnName = :userID
                WHERE b.blok_adi = :blok 
                AND d.daire_sayisi = :daire 
                AND d.apartman_id = :apartID";


        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':blok', $data->blok, PDO::PARAM_STR);
        $stmt->bindParam(':daire', $data->daire, PDO::PARAM_STR);
        $stmt->bindParam(':apartID', $_SESSION["apartID"], PDO::PARAM_INT);
        $stmt->execute();
    }

    echo 1;
} catch (PDOException $e) {
    echo $e->getMessage(); // Hata mesajını ekrana yazdır
}
?>
