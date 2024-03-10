<?php 
include("../../DB/dbconfig.php");
require_once 'class.func.php';
$userID1 = $_POST['userID1'];
$kTarih = $_POST['kTarih'];
$daireID = $_POST['daireID'];
$turr = $_POST['turr'];
$userr = $_POST['userr'];
$apartId = $_POST['apartId'];

$temp;
if($turr == 0){
$temp="kiraciID";
}else if($turr==1){
    $temp="katMalikiID";
}




if (!isset($userID1) && $userr !== "") {
 

try{
    $userPass = randomPassword();
    $hashedPassword = base64_encode($userPass);
    $t = "Y";
    $sqll = "INSERT INTO tbl_users (userName,  userPass,   apartman_id, rol, popup, userStatus) VALUES 
    (:userName,  :userPass,  :apartman_id, :rol, :popup, :userStatus)";

    $stmt = $conn->prepare($sqll);
    $stmt->bindParam(':userName', $userr);
     $stmt->bindParam(':userPass', $hashedPassword);
    $stmt->bindParam(':userStatus', $t);
    $stmt->bindParam(':apartman_id', $apartId);
    $rol = 3;
    $popup = 0;
    $stmt->bindParam(':rol', $rol);
    $stmt->bindParam(':popup', $popup);
    $stmt->execute();
    $newUserId = $conn->lastInsertId();


    $sql = "UPDATE tbl_daireler SET ".$temp."= :id WHERE daire_id=:daireID";

$stmt=$conn-> prepare($sql);
$stmt->bindParam(":id",$newUserId);
$stmt->bindParam(":daireID",$daireID);
$result = $stmt->execute();





$sql2 = "SELECT * FROM tbl_users WHERE userID = :userid";
$stmt2 = $conn->prepare($sql2);
$stmt2->bindParam(":userid", $newUserId);

$stmt2->execute();
    $userData = $stmt2->fetch(PDO::FETCH_ASSOC);

  
      
        echo $userData['userName'];


}catch (PDOException $e) {
    echo $e;
}


} else {
   

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
}




















