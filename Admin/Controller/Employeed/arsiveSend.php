<?php
session_start();
include ("../../../DB/dbconfig.php");
try {
    $userID = $_POST['userID'];
    $arsive = 1;
   $sql = "UPDATE tbl_employed SET arsive = $arsive WHERE userID = :userID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();

    echo 1;
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>