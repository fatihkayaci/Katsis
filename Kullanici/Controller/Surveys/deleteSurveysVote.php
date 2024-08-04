
<?php
session_start(); // Session başlatma

include("../../../DB/dbconfig.php"); // Veritabanı bağlantı bilgilerini dahil et
require_once '../class.func.php'; // Fonksiyon dosyasını dahil et

try {
    $surveysID = $_POST['surveysID']; // POST ile gelen surveysID değerini al
    $userID = $_SESSION['userID']; // POST ile gelen userID değerini al

    // Silme sorgusunu hazırla
    $sql = "DELETE FROM tbl_surveys_vote WHERE surveysID = :surveysID AND userID = :userID";
    
    // SQL sorgusunu hazırla ve parametreleri bağla
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':surveysID', $surveysID);
    $stmt->bindParam(':userID', $userID);
    $stmt->execute(); // Sorguyu çalıştı

    $updateVoteSql = "UPDATE tbl_surveys SET vote = vote - 1 WHERE surveysID = :surveysID";
    $updateVoteStmt = $conn->prepare($updateVoteSql);
    $updateVoteStmt->bindParam(':surveysID', $surveysID);
    $updateVoteStmt->execute();
} catch (PDOException $e) {
    echo json_encode(array('error' => 'Veritabanı hatası: ' . $e->getMessage()));
}
?>
