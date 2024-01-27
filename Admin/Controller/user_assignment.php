<?php 
include("../../DB/dbconfig.php");

$userID1 = $_POST['userID1'];
$kTarih = $_POST['kTarih'];
$daireID = $_POST['daireID'];
$turr = $_POST['turr'];

$temp;
if($turr == 0){
$temp="kiraciID";
}else if($turr==1){
    $temp="katMalikiID";
}
$sql = "UPDATE tbl_daireler SET ".$temp."= :id WHERE daire_id=:daireID";

try{
    $sql = "UPDATE tbl_daireler SET ".$temp."= :id WHERE daire_id=:daireID";

$stmt=$conn-> prepare($sql);
$stmt->bindParam(":id",$userID1);
$stmt->bindParam(":daireID",$daireID);
$result = $stmt->execute();





$sql2 = "SELECT * FROM tbl_users WHERE userID = :userid";
$stmt2 = $conn->prepare($sql2);
$stmt2->bindParam(":userid", $userID1);

$stmt2->execute();
    $userData = $stmt2->fetch(PDO::FETCH_ASSOC);

  
      
        echo $userData['userName'];


}catch (PDOException $e) {
    echo $e;
}



