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
    $sql = "SELECT * FROM tbl_maliye WHERE daire_id = :daireId AND user_id = :userId AND apartman_id = :apartmanId AND maliye_turu = 1";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':daireId', $daireId);
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':apartmanId', $apartmanId);
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $kalanTutar = $tahsilatTutarValue;

    $sql1 = "UPDATE tbl_maliye SET maliye_turu = 2 WHERE ";

foreach ($rows as $row) {
    if ($kalanTutar > 0) {
        $borcId = $row['maliye_id'];
        $borcMiktar = $row['borc_miktar'];
        $daire_id = $row['daire_id'];
        $user_id = $row['user_id'];
        $apartman_id = $row['apartman_id'];
        $m_turu =1;
        $kategori_id = $row['kategori_id'];
        $aciklama = $row['aciklama'];
        $tanımlama_tar = $row['tanımlama_tar'];
        $odeme_tar = $row['odeme_tar'];

        if ($kalanTutar >= $borcMiktar) {
            $kalanTutar -= $borcMiktar;
            $sql1 .= "maliye_id = $borcId OR ";
        } else {
            $borcMiktar -= $kalanTutar;
            $kalanTutar = 0;
            $sql1 .= "maliye_id = $borcId OR ";
            $sql2 = "INSERT INTO tbl_maliye (borc_miktar, daire_id, user_id, apartman_id, maliye_turu, kategori_id, aciklama, tanımlama_tar, odeme_tar) SELECT $borcMiktar, $daire_id, $user_id, $apartman_id, $m_turu, '$kategori_id', '$aciklama', '$tanımlama_tar', '$odeme_tar' FROM tbl_maliye WHERE maliye_id = $borcId";


            // $sql2 sorgusunu çalıştır
            $conn->query($sql2);
        }
    }
}

// Son OR operatörünü kaldır
$sql1 = rtrim($sql1, "OR ");

// $sql1 sorgusunu çalıştır
$conn->query($sql1);

    
} catch(PDOException $e) {
    echo "Hata: " . $e->getMessage();
}









?>

