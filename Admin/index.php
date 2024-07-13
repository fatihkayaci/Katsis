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

$identifier = $_SESSION["mail"];
$field = is_numeric($identifier) ? "user_no" : "userEmail";

$sql = "SELECT * FROM tbl_users WHERE $field = :identifier";

$stmt = $conn->prepare($sql);

$stmt->bindParam(":identifier", $identifier);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $idApartman = $row['apartman_id'];
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
    echo "<script>pagename('Kullanıcılar');</script>";
    echo "<script>
            localStorage.setItem('selectedLink', 'Accounts');
         </script>";
}
else if($indexx == 'Arsiv'){
    include ("Accounts/arsiv.php");
    echo "<script>pagename('Kullanıcılar / Aşiv');</script>";
}
else if($indexx == 'TopluHesap'){
    include ("Accounts/topluHesap.php");
    echo "<script>pagename('Toplu Hesap Ekleme');</script>";
}else if($indexx == 'TopluPersonel'){
    include ("employee/topluPersonel.php");
    echo "<script>pagename('Toplu Personel Ekleme');</script>";
}
else if($indexx == 'custom'){
    include ("Accounts/ozellestir.php");
    echo "<script>pagename('Kullanıcı Ayrıntıları');</script>";
}
else if($indexx == 'Sections'){
    include ("Sections/index.php");
    echo "<script>pagename('Bölümler');</script>";
    echo "<script>
            localStorage.setItem('selectedLink', 'Sections');
         </script>";
} else if($indexx == 'detail'){
    include ("Sections/detail.php");
    echo "<script>pagename('Daire Ayrıntıları');</script>";
    echo "<script>
            localStorage.setItem('selectedLink', 'Sections');
         </script>";
}  else if($indexx == 'income'){ 
    include ("Income/index.php");
    echo "<script>pagename('Gelirler');</script>";
    echo "<script>
            localStorage.setItem('selectedLink', 'income');
         </script>";
} else if($indexx == 'topluborc'){ 
    include ("Income/topluBorc.php");
    echo "<script>pagename('Toplu Borçlandırma');</script>";
    echo "<script>
            localStorage.setItem('selectedLink', 'topluborc');
         </script>";
} else if($indexx == 'meters'){
    include ("Meters/index.php");
    echo "<script>pagename('Sayaçlar');</script>";
    echo "<script>
            localStorage.setItem('selectedLink', 'meters');
         </script>";
} 
else if($indexx == 'dashboard'){
    include ("Dashboard/index.php");
    echo "<script>pagename('Ana Sayfa');</script>";
    echo "<script>
            localStorage.setItem('selectedLink', 'dashboard');
         </script>";
}
else if($indexx == 'profile'){
    include ("profile/profile.php");
    echo "<script>pagename('Profil');</script>";
    echo "<script>
            localStorage.setItem('selectedLink', 'profile');
         </script>";
}else if($indexx == 'employee'){
    include ("employee/index.php");
    echo "<script>pagename('Personeller');</script>";
    echo "<script>
            localStorage.setItem('selectedLink', 'employee');
         </script>";
}else if($indexx == 'employee-arsiv'){
    include ("employee/arsiv.php");
    echo "<script>pagename('Personeller / Aşiv');</script>";
    echo "<script>
            localStorage.setItem('selectedLink', 'employee-arsiv');
         </script>";
}else if($indexx == 'Surveys'){
    include ("Surveys/index.php");
    echo "<script>pagename('Anketler');</script>";
    echo "<script>
            localStorage.setItem('selectedLink', 'Surveys');
         </script>";
}else if($indexx == 'Phone'){
    include ("Phone/index.php");
    echo "<script>pagename('Telefon Rehberi');</script>";
    echo "<script>
            localStorage.setItem('selectedLink', 'Phone');
         </script>";
}else{
    include ("Dashboard/index.php");
    echo "<script>pagename('ANA SAYFA');</script>";
    echo "<script>
            localStorage.setItem('selectedLink', 'dashboard');
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

