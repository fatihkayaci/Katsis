<?php
include("../../DB/dbconfig.php");

try {
    session_start();
 
    $userNameArray = json_decode($_POST['userNameArray'], true);
    $durumArray = json_decode($_POST['durumArray'], true);
    $apartman_id = $_POST['apartman_id'];

    print_r($userNameArray);

    $t = "Y";
    $rol = 3;
    $popup = 0;

    foreach ($userNameArray as $userName) {
       
        $sql = "INSERT INTO tbl_users (userName, durum, apartman_id, rol, popup, userStatus) 
                VALUES (:userName, :durum, :apartman_id, :rol, :popup, :userStatus)";
    
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userName', $userName);
        $stmt->bindParam(':durum', $durum);
        $stmt->bindParam(':userStatus', $t);
        $stmt->bindParam(':apartman_id', $apartman_id);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':popup', $popup);
        $stmt->execute();
    }

    echo 1;
} catch (PDOException $e) {
    echo $e->getMessage(); // Hata mesajını ekrana yazdır
}
?>
