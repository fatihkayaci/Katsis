<?php
include("../../DB/dbconfig.php");

try {
    session_start();
    $addedUserIds = array();
    $toSend = json_decode($_POST['toSend'], true);
    $apartman_id = $_POST['apartman_id'];

    $t = "Y";
    $rol = 3;
    $popup = 0;

    foreach ($toSend as $data) {
        $userName = $data['userName'];
        $durum = $data['durum'];

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
        $addedUserIds[] = $conn->lastInsertId();
    }
    $_SESSION['addedUserIds'] = $addedUserIds;
    //echo json_encode($addedUserIds);
    echo 1;
} catch (PDOException $e) {
    echo $e->getMessage(); // Hata mesajını ekrana yazdır
}
?>
