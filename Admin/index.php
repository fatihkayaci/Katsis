<script>
    function pagename(temp){
    document.getElementById('pageName').innerHTML=temp;

    }
</script>

<?php
session_start();
include("../DB/dbconfig.php");
require_once '../class.user.php';
$user_login = new USER();
if (!isset($_SESSION["mail"]) || empty($_SESSION["mail"])) {
    $user_login->redirect('../index');
} 
$sql = "SELECT * FROM tbl_users WHERE userEmail = :userEmail";

$stmt = $conn->prepare($sql);

$stmt->bindParam(":userEmail", $_SESSION["mail"]);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $idApartman= $row['apartman_id'];
    $userName = $row['userName'];
}

$_SESSION["pageName"]="Dashboarddd";
$_SESSION["userName"] =$userName;
$_SESSION["apartID"] =$idApartman;

$indexx= "";

if(isset($_GET['parametre'])){
    $indexx = $_GET['parametre'];
}


include('header.php');

include('leftbar.php');

if($indexx == 'Accounts'){
    include ("Accounts/index.php");
    echo "<script>pagename('KULLANICILAR');</script>";
}
else if($indexx == 'custom'){
    include ("Accounts/ozellestir.php");
    echo "<script>pagename('KULLANICI DÜZENLE');</script>";
}
else if($indexx == 'Sections'){
    include ("Sections/index.php");
    echo "<script>pagename('BÖLÜMLER');</script>";
}   else if($indexx == 'dashboard'){
        include ("Dashboard/index.php");
        echo "<script>pagename('DASHBOARD');</script>";
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



