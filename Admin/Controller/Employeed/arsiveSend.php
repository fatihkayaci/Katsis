<?php
session_start();
include ("../../../DB/dbconfig.php");
try {
    $userID = $_POST['userID'];
    $arsive = 1;
   $sql = "UPDATE tbl_users SET arsive = $arsive WHERE userID = :userID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();

    echo"Seçtiğiniz Personeller Başarıyla Arşiv Sayfasına Gönderilmiştir.";
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>