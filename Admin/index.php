<?php
session_start();

include("../DB/dbconfig.php");



include('header.php');

include('leftbar.php');


$sql = "SELECT * FROM tbl_users WHERE userEmail = :userEmail";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":userEmail", $_SESSION["mail"]);
$stmt->execute();

// Sonuçları al
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // "popup" sütunundaki değeri al
    $popupValue = $row['popup'];
echo    $popupValue;
    if($popupValue ==1){
        include('popup.php');
    } 
}








?>