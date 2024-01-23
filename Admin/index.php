<?php
session_start();
include("../DB/dbconfig.php");

$sql = "SELECT * FROM tbl_users WHERE userEmail = :userEmail";

$stmt = $conn->prepare($sql);

$stmt->bindParam(":userEmail", $_SESSION["mail"]);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $idApartman= $row['userID'];
}




$_SESSION["apartID"] =$idApartman;

$indexx= "";

if(isset($_GET['parametre'])){
    $indexx = $_GET['parametre'];
}


include('header.php');

include('leftbar.php');

if($indexx == 'Accounts'){
    include ("Accounts/index.php");
}
else if($indexx == 'custom'){
    include ("Accounts/ozellestir.php");
}
else if($indexx == 'Sections'){
    include ("Sections/index.php");
}   else if($indexx == 'Sections'){
        include ("Sections/index.php");
}   else if($indexx == 'dashboard'){
        include ("Dashboard/index.php");
}


$sql = "SELECT * FROM tbl_users WHERE userEmail = :userEmail";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":userEmail", $_SESSION["mail"]);
$stmt->execute();

// Sonuçları al
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // "popup" sütunundaki değeri al
    $popupValue = $row['popup'];

    if($popupValue ==1){
        include('popup.php');
    } 
}
?>