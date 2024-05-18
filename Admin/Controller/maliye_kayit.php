<?php
include("../../DB/dbconfig.php");
$daireId = $_POST['daireId'];
$userId = $_POST['userId'];
$apartmanId = $_POST['apartmanId'];
$gelir_turu = $_POST['gelir_turu'];
$aciklamaValue = $_POST['aciklamaValue'];
$borcTutarValue = floatval(str_replace(',', '.', $_POST['borcTutarValue']));
$dateInputValue = $_POST['dateInputValue'];
$dateInput2Value = $_POST['dateInput2Value'];
$kategoriValue = $_POST['kategoriValue'];

try {
    $sql = "INSERT INTO tbl_maliye (daire_id, user_id, apartman_id, maliye_turu, aciklama, borc_miktar,top_borc, tanımlama_tar, odeme_tar, kategori_id) 
    VALUES (:daireId, :userId, :apartmanId, :gelir_turu, :aciklamaValue, :borcTutarValue, :borcTutarValue2, :dateInputValue, :dateInput2Value, :kategoriValue)";

// SQL sorgusunu hazırlama
$stmt = $conn->prepare($sql);

// Değişkenlerin bağlanması
$stmt->bindParam(':daireId', $daireId);
$stmt->bindParam(':userId', $userId);
$stmt->bindParam(':apartmanId', $apartmanId);
$stmt->bindParam(':gelir_turu', $gelir_turu);
$stmt->bindParam(':aciklamaValue', $aciklamaValue);
$stmt->bindParam(':borcTutarValue', $borcTutarValue, PDO::PARAM_STR);
$stmt->bindParam(':borcTutarValue2', $borcTutarValue, PDO::PARAM_STR);
$stmt->bindParam(':dateInputValue', $dateInputValue);
$stmt->bindParam(':dateInput2Value', $dateInput2Value);
$stmt->bindParam(':kategoriValue', $kategoriValue);


// Sorguyu çalıştırma
$stmt->execute();

echo true;
} catch(PDOException $e) {
echo "Hata: " . $e->getMessage();
}



?>