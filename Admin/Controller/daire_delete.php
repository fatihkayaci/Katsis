
<?php

// Veritabanı yapılandırma dosyasını içe aktar
include("../../DB/dbconfig.php");
$checkedDaireIDs = isset($_POST['checkedDaireIDs']) ? $_POST['checkedDaireIDs'] : null;
$checkedBlokIDs = isset($_POST['checkedBlokIDs']) ? $_POST['checkedBlokIDs'] : null;
$id = isset($_POST['id']) ? $_POST['id'] : null;



try {
    $daireler = implode(',', $checkedDaireIDs);

    // SQL sorgusu hazırlama
    $sql = "DELETE FROM tbl_daireler WHERE daire_id IN ($daireler)";
    $sql = $sql. "AND apartman_id=".$id;
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();
    if ($result) {
        $response = array(
            "sts"=>"true",
            "msg" => "Silme İşlemi Başarıyla Gerçekleşti"
        );
        deleteDSayisi($checkedBlokIDs);
    } else {
        $response = array(
            "sts"=>"false",
            "msg" => "Silme İşlemi Başarısız!"
        );
    }

      

} catch (\Throwable $th) {
    $response = array(
        "sts"=>"false",
        "msg" => $th
    );
}

echo json_encode($response);

function deleteDSayisi($ids) {
    global $conn; // Bağlantıyı global olarak alıyoruz.

    try {
        // Her bir blok ID'si için tekrar eden değerleri gruplayarak ve sayılarını hesaplayarak bir dizi oluşturuyoruz.
        $id_counts = array_count_values($ids);

        // Her bir blok ID'si için güncelleme sorgusu oluşturup çalıştırıyoruz.
        foreach ($id_counts as $id => $count) {
            $sql = "UPDATE tbl_blok SET daire_sayisi = daire_sayisi - :count WHERE blok_id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':count', $count, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        }

    } catch (PDOException $e) {
        echo "Hata: " . $e->getMessage(); 
    }
}

?>