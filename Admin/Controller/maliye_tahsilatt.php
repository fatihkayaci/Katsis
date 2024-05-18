<?php
include("../../DB/dbconfig.php");

$daireId = $_POST['daireId'];
$userId = $_POST['userId'];
$apartmanId = $_POST['apartmanId'];
$gelir_turu = $_POST['gelir_turu'];
$aciklamaValue = $_POST['aciklamaValue'];
$tahsilatTutarValue = floatval(str_replace(',', '.', $_POST['TahsilatTutarValue']));
$dateInputValue = $_POST['dateInputValue'];

try {
    // Start transaction
    $conn->beginTransaction();

    // Select debts
    $sql = "SELECT * FROM tbl_maliye WHERE daire_id = :daireId AND user_id = :userId AND apartman_id = :apartmanId AND maliye_turu = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':daireId', $daireId);
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':apartmanId', $apartmanId);
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $kalanTutar = $tahsilatTutarValue;

    $updateIds = [];
    foreach ($rows as $row) {
        if ($kalanTutar <= 0) {
            break;
        }

        $borcId = $row['maliye_id'];
        $borcMiktar = $row['borc_miktar'];
        $aciklama = $row['aciklama'];
        $odeme_tar = $row['odeme_tar'];

        $tutar = min($kalanTutar, $borcMiktar);
        $sql2 = "INSERT INTO tbl_tahsilat (tutar, maliye_id, aciklama, odeme_tarih) VALUES (:tutar, :maliye_id, :aciklama, :odeme_tarih)";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bindParam(':tutar', $tutar);
        $stmt2->bindParam(':maliye_id', $borcId);
        $stmt2->bindParam(':aciklama', $aciklama);
        $stmt2->bindParam(':odeme_tarih', $odeme_tar);
        $stmt2->execute();

        if ($kalanTutar >= $borcMiktar) {
            $updateIds[] = $borcId;
            $kalanTutar -= $borcMiktar;
        } else {
            $newBorcMiktar = $borcMiktar - $kalanTutar;
            $sql3 = "UPDATE tbl_maliye SET borc_miktar = :newBorcMiktar WHERE maliye_id = :maliye_id";
            $stmt3 = $conn->prepare($sql3);
            $stmt3->bindParam(':newBorcMiktar', $newBorcMiktar);
            $stmt3->bindParam(':maliye_id', $borcId);
            $stmt3->execute();
            $kalanTutar = 0;
        }
    }

    if (!empty($updateIds)) {
        $sql1 = "UPDATE tbl_maliye SET maliye_turu = 2 WHERE maliye_id IN (" . implode(',', $updateIds) . ")";
        $conn->query($sql1);
    }

    // Commit transaction
    $conn->commit();
echo true;
} catch (PDOException $e) {
    // Rollback transaction in case of error
    $conn->rollBack();
    error_log("Error: " . $e->getMessage()); // Hata loglama
    echo "Hata: " . $e->getMessage();
}
?>
