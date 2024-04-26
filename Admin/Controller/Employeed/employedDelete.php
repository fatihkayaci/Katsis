<?php
include("../../../DB/dbconfig.php");
try {
    $userID = $_POST['userID'];
    $sql = "DELETE FROM tbl_employed WHERE userID = :userID";

    // PDO sorgusunu hazırla ve çalıştır
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userID', $userID);
    $stmt->execute();
    echo 1;
} catch (PDOException $e) {
    echo $e;
}
?>