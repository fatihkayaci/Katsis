<?php
include("../../DB/dbconfig.php");
try {
    $userID = $_POST['userID'];
    echo $userID;
    // SQL sorgusunu hazırla
    $sql = "DELETE FROM tbl_users WHERE userID = :userID";

    // PDO sorgusunu hazırla ve çalıştır
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userID', $userID);
    $stmt->execute();
    
    $sql2 = "UPDATE tbl_daireler
    SET kiraciID = null, katMalikiID = null
    WHERE kiraciID = :kiraciID OR katMalikiID = :katMalikiID";
    
    $stmt = $conn->prepare($sql2);
    $stmt->bindParam(':kiraciID',$userID);
    $stmt->bindParam(':katMalikiID', $userID);
    $stmt->execute();
    echo 1;
} catch (PDOException $e) {
    echo $e;
}
?>