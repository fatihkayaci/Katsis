<?php 
error_reporting(E_ALL);
 ini_set('display_errors', 1);
include("../../DB/dbconfig.php");

$temp1 = $_POST['temp1'];
$id = $_POST['id'];

try {
    $sql = "UPDATE tbl_blok SET blok_adi= :blok_adi WHERE blok_id=:blok_id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":blok_adi", $temp1);
    $stmt->bindParam(":blok_id", $id);
    $result = $stmt->execute();
} catch (PDOException $e) {
    echo "Hata oluştu: " . $e->getMessage(); // Hata mesajını göster
    exit(); // Programın sonlanmasını sağla
}
?>
