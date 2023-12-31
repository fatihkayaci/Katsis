<?php
include("../../DB/dbconfig.php");
try {
    $kullaniciID = $_POST['kullaniciID'];
    
    // SQL sorgusunu hazırla
    $sql = "DELETE FROM tbl_kullanici WHERE kullaniciID = :kullaniciID";

    // PDO sorgusunu hazırla ve çalıştır
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':kullaniciID', $kullaniciID);
    $stmt->execute();
    
    echo 1;
} catch (PDOException $e) {
    echo 0;
}
?>
