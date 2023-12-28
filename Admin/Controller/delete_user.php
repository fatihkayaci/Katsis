<?php
include("../../DB/dbconfig.php");
try {
    $kullanıcıID = $_POST['kullanıcıID'];
    
    // SQL sorgusunu hazırla
    $sql = "DELETE FROM tbl_kullanici WHERE kullanıcıID = :kullaniciID";

    // PDO sorgusunu hazırla ve çalıştır
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':kullaniciID', $kullanıcıID);
    $stmt->execute();
    
    echo 1;
} catch (PDOException $e) {
    echo 0;
}
?>
