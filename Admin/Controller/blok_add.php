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

    // Yeni eklenen kaydın blok_id değerini al
    $lastInsertedId = $conn->lastInsertId();

    // Başarılı olduğunda JSON yanıtı hazırla
    $response = array(
        "status" => 1,
        "blok_id" => $lastInsertedId  // Eklenen kaydın blok_id değerini ekleyin
    );

    // JSON formatında yanıtı gönder
    header('Content-Type: application/json');
    echo json_encode($response);
} catch (PDOException $e) {
    // Hata durumunda işlem
    $response = array(
        "status" => 0,
        "error" => "Hata: " . $e->getMessage()
    );

    // JSON formatında yanıtı gönder
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>


