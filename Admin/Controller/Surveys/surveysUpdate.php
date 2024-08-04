<?php
session_start();
include ("../../../DB/dbconfig.php");
require_once '../class.func.php';

try {
    $surveysID = $_POST['surveysID'];
    $surveysQuestion = $_POST['surveysQuestion'];
    $lastDate = $_POST['lastDate'];
    $voters = $_POST['voters'];
    $options = $_POST['options'];
    
    $sql = "UPDATE tbl_surveys SET surveysQuestion = :surveysQuestion, lastDate = :lastDate, voters = :voters
            WHERE surveysID = :surveysID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':surveysID', $surveysID);
    $stmt->bindParam(':surveysQuestion', $surveysQuestion);
    $stmt->bindParam(':lastDate', $lastDate);
    $stmt->bindParam(':voters', $voters);
    $stmt->execute();

   // surveys_options tablosunu güncelle
   $sql = "DELETE FROM tbl_surveys_options WHERE surveysID = :surveysID";
   $stmt = $conn->prepare($sql);
   $stmt->bindParam(':surveysID', $surveysID);
   $stmt->execute();

   $sql = "INSERT INTO tbl_surveys_options (surveysID, optionName) VALUES (:surveysID, :optionName)";
   $stmt = $conn->prepare($sql);
   foreach ($options as $option) {
       $stmt->bindParam(':surveysID', $surveysID);
       $stmt->bindParam(':optionName', $option);
       $stmt->execute();
   }

} catch (PDOException $e) {
    echo $e;
}
?>