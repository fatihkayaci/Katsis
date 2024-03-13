<?php
include("../../DB/dbconfig.php");

try {
    session_start();
    $durum = $_POST['durum'];
    // Duruma bağlı olarak sorgulama yapılacak tablo ve sütun adını belirle
    if ($durum == "kiraci") {
        $sql = "SELECT d.blok_adi, d.daire_sayisi, b.blok_adi
        FROM tbl_daireler d
        INNER JOIN tbl_blok b ON d.blok_adi = b.blok_id
        WHERE d.apartman_id = :apartID AND d.kiraciID IS NULL";

    } elseif ($durum == "katMaliki") {
        $sql = "SELECT d.blok_adi, d.daire_sayisi, b.blok_adi
        FROM tbl_daireler d
        INNER JOIN tbl_blok b ON d.blok_adi = b.blok_id
        WHERE d.apartman_id = :apartID AND d.katMalikiID IS NULL";
    } else {
        // Geçersiz durum
        echo json_encode(array('error' => 'Geçersiz durum.'.$durum));
        exit;
    }

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':apartID', $_SESSION["apartID"]);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result); // SQL sorgusunun sonucunu JSON formatında geri döndür

} catch (PDOException $e) {
    echo json_encode(array('error' => $e->getMessage())); // Hata mesajını JSON formatında geri döndür
}
?>
