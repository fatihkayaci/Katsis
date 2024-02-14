<?php
include("../../DB/dbconfig.php");
$blokValue = $_POST['blokValue'];
$id = $_POST['id'];


$t = 0;
try {
    // SQL sorgusu hazırlama
    $sql = "INSERT INTO tbl_blok (blok_adi, daire_sayisi, apartman_idd) VALUES (:blok_adi, :dSayisi, :apartmanidd)";
    $stmt = $conn->prepare($sql);

    // Değişkenleri bağlama
    $stmt->bindParam(':blok_adi', $blokValue);
    $stmt->bindParam(':dSayisi', $t);
    $stmt->bindParam(':apartmanidd', $id);

    // Sorguyu çalıştırma
    $stmt->execute();

    echo 1;
} catch (PDOException $e) {
    // Hata durumunda işlem
    echo "Hata: " . $e->getMessage();
}


?>
