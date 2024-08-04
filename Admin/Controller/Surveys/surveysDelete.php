<?php
session_start();
include ("../../../DB/dbconfig.php");
require_once '../class.func.php';

try {
    $surveysID = $_POST['surveysID'];
    //echo $userID;
    // SQL sorgusunu hazırla
    $sql = "DELETE FROM tbl_surveys WHERE surveysID = :surveysID";

    // PDO sorgusunu hazırla ve çalıştır
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':surveysID', $surveysID);
    $stmt->execute();
    
    $sql2 = "DELETE FROM tbl_surveys_options WHERE surveysID = :surveysID";
    
    $stmt = $conn->prepare($sql2);
    $stmt->bindParam(':surveysID', $surveysID);
    $stmt->execute();

    $sql3 = "DELETE FROM tbl_surveys_vote WHERE surveysID = :surveysID";
    
    $stmt = $conn->prepare($sql3);
    $stmt->bindParam(':surveysID', $surveysID);
    $stmt->execute();
    
    echo 1;
} catch (PDOException $e) {
    echo $e;
}
?>