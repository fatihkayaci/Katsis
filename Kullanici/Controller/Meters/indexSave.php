<?php 
include ("../../../DB/dbconfig.php");

$apartman_id = $_POST['apartman_id'];
$temp = $_POST['temp'];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['daireler'])) {
    $daireler = $_POST['daireler'];

    // Veritabanı bağlantısının olup olmadığını kontrol et
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Mevcut apartman_id'ye sahip satırları sil
        $deleteQuery = "DELETE FROM tbl_sayac_$temp  WHERE apartman_id = :apartman_id";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bindParam(':apartman_id', $apartman_id, PDO::PARAM_INT);
        $deleteStmt->execute();

        // Yeni verileri ekle
$insertQuery = "INSERT INTO tbl_sayac_$temp (apartman_id, daire_id, ilk_index, son_index, tuketim,  okuma_tarih) VALUES ";
$insertValues = [];
$bindParams = [];

// Geçerli tarih ve saati al
$okuma_tarihi = date('Y-m-d H:i'); // Geçerli tarih ve saat

foreach ($daireler as $index => $item) {
    $daireId = $item['daireId'];
    $ilkIndex = $item['ilkIndex'];
    $sonIndex = $item['sonIndex'];
    $tuketim = $item['tuketim'];

    // VALUES kısmını doldur
    $insertValues[] = "(:apartman_id, :daire_id_$index, :ilk_index_$index, :son_index_$index, :tuketim_$index,  :okuma_tarihi)";

    // Bind parametrelerini hazırla
    $bindParams[":daire_id_$index"] = $daireId;
    $bindParams[":ilk_index_$index"] = $ilkIndex;
    $bindParams[":son_index_$index"] = $sonIndex;
    $bindParams[":tuketim_$index"] = $tuketim;
}

// VALUES kısımlarını birleştir
$insertQuery .= implode(", ", $insertValues);

// PDO hazırlama ve bind işlemleri
$insertStmt = $conn->prepare($insertQuery);
$insertStmt->bindParam(':apartman_id', $apartman_id, PDO::PARAM_INT);
$insertStmt->bindParam(':okuma_tarihi', $okuma_tarihi, PDO::PARAM_STR);

// Dinamik bind parametrelerini ekle
foreach ($bindParams as $key => $value) {
    $insertStmt->bindValue($key, $value, PDO::PARAM_INT);
}

// Tek seferde execute
$insertStmt->execute();

        echo "Veriler Başarıyla Eklendi..";
    } catch (PDOException $e) {
        echo "Veritabanı bağlantısı başarısız: " . $e->getMessage();
    }
}
?> 
