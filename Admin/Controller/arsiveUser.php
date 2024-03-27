<?php
include ("../../DB/dbconfig.php");

try {
    session_start();
    $result = $_SESSION['result'];
    $arsive = $_POST['arsive'];
    
    if (isset($result['kiraciID'])) {
        $userID = $result['kiraciID'];
    } else if (isset($result['katMalikiID'])) {
        $userID = $result['katMalikiID'];
    }
    // Kullanıcıyı güncelleyen SQL sorgusunu hazırlayalım
    $updateSQL = "UPDATE tbl_users SET
            arsive = :arsive
            WHERE userID = :userID";

    $updateStmt = $conn->prepare($updateSQL);
    $updateStmt->bindParam(':arsive', $arsive);
    $updateStmt->bindParam(':userID', $userID);
    $updateStmt->execute();
    echo 1;
} catch (PDOException $e) {
    echo $e->getMessage(); // Hata mesajını ekrana yazdır
}

?>
