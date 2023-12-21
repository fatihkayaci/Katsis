<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("../DB/dbconfig.php");

echo "celalll".$_SESSION["mail"];

include('header.php');

include('leftbar.php');


$sql = "SELECT * FROM tbl_users";
$stmt = $conn->query($sql);

// Sonuçları al
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // "popup" sütunundaki değeri al
    $popupValue = $row['popup'];

    // JavaScript kodunu oluştur ve konsola yaz
    echo "<script>console.log('Popup Değeri: $popupValue');</script>";
}


include('popup.php');





?>
