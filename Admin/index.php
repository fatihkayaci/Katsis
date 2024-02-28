<script>
function pagename(temp) {
    document.getElementById('pageName').innerHTML = temp;
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
    $userID = $row['userID'];
}

$_SESSION["pageName"]="Dashboard";
$_SESSION["userName"] =$userName;
$_SESSION["apartID"] =$idApartman;
$_SESSION["userID"] =$userID;

$indexx= "";

if(isset($_GET['parametre'])){
    $indexx = $_GET['parametre'];
}


include('header.php');

include('leftbar.php');

if($indexx == 'Accounts'){
    include ("Accounts/index.php");
    echo "<script>pagename('KULLANICILAR');</script>";
    echo "<script>
            localStorage.setItem('selectedLink', 'Accounts');
         </script>";
}
else if($indexx == 'TopluHesap'){
    include ("Accounts/topluHesap.php");
    echo "<script>pagename('TOPLU HESAP EKLEME');</script>";
}
else if($indexx == 'custom'){
    include ("Accounts/ozellestir.php");
    echo "<script>pagename('KULLANICI DÜZENLE');</script>";
}
else if($indexx == 'Sections'){
    include ("Sections/index.php");
    echo "<script>pagename('BÖLÜMLER');</script>";
    echo "<script>
            localStorage.setItem('selectedLink', 'Sections');
         </script>";
}   
else if($indexx == 'dashboard'){
    include ("Dashboard/index.php");
    echo "<script>pagename('ANA SAYFA');</script>";
    echo "<script>
            localStorage.setItem('selectedLink', 'dashboard');
         </script>";
}
else if($indexx == 'profile'){
    include ("profile/profile.php");
    echo "<script>pagename('PROFİL');</script>";
    echo "<script>
            localStorage.setItem('selectedLink', 'profile');
         </script>";
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