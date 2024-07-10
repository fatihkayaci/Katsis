<?php 
include("../../DB/dbconfig.php");
require_once 'class.func.php';
$userID1 = isset($_POST['userID1']) ? $_POST['userID1'] : null;
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




if ($userID1==null && $userr !== "") {
 

try{
    $userNO = generateUniqueUserID( $conn);
    $userPass = randomPassword();
    $hashedPassword = base64_encode($userPass);
    $t = "Y";
    $sqll = "INSERT INTO tbl_users (userName, user_no, userPass,   apartman_id, rol, popup, userStatus) VALUES 
    (:userName,  :user_no,  :userPass,  :apartman_id, :rol, :popup, :userStatus)";

    $stmt = $conn->prepare($sqll);
    $stmt->bindParam(':userName', $userr);
    $stmt->bindParam(':user_no',$userNO);
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

  
      
    $response = array(
        'userName' => $userData['userName'],
        'refres' => true,
    );


}catch (PDOException $e) {
    $response = array(
        'userName' => $e,
        'refres' => false,
    );
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

  
      
    $response = array(
        'userName' => $userData['userName']
        
    );


}catch (PDOException $e) {

    $response = array(
        'userName' => $e
    );
}
}

header('Content-Type: application/json');
echo json_encode($response);



















