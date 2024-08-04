<?php
include("../../DB/dbconfig.php");
try {
    $userID = $_POST['userID'];
    //echo $userID;
    // SQL sorgusunu hazırla
    $sql = "DELETE FROM tbl_arsive WHERE userID = :userID";

    // PDO sorgusunu hazırla ve çalıştır
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userID', $userID);
    $stmt->execute();
    echo 1;
} catch (PDOException $e) {
    echo $e;
}
?>