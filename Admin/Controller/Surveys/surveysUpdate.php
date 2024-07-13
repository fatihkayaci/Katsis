<?php
session_start();
include ("../../../DB/dbconfig.php");
require_once '../class.func.php';

try {
    $surveysID = $_POST['surveysID'];
    $surveysQuestion = $_POST['surveysQuestion'];
    $lastDate = $_POST['lastDate'];
    $vote = $_POST['vote'];
    
    $sql = "DELETE FROM tbl_surveys WHERE surveysID = :surveysID";

    // PDO sorgusunu hazırla ve çalıştır
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':surveysID', $surveysID);
    $stmt->execute();
    
} catch (PDOException $e) {
    echo $e;
}
?>