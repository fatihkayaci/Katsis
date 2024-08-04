<?php
session_start(); // Session başlatma

include ("../../../DB/dbconfig.php"); // Veritabanı bağlantı bilgilerini dahil et
require_once '../class.func.php'; // Fonksiyon dosyasını dahil et

try {
    $surveysID = $_POST['surveysID'];
    $optionID = $_POST['optionID'];
    $userID = $_SESSION["userID"];
    // Mevcut kayıtları kontrol eden SQL sorgusu
    $checkSql = "SELECT COUNT(*) FROM tbl_surveys_vote WHERE surveysID = :surveysID AND userID = :userID";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bindParam(':surveysID', $surveysID);
    $checkStmt->bindParam(':userID', $userID);
    $checkStmt->execute();
    $count = $checkStmt->fetchColumn();

    if ($count == 0) {
        // Eğer aynı surveysID ve userID kombinasyonu yoksa, INSERT işlemi gerçekleştir
        $sql = "INSERT INTO tbl_surveys_vote (optionID, surveysID, userID) VALUES (:optionID, :surveysID, :userID)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':optionID', $optionID);
        $stmt->bindParam(':surveysID', $surveysID);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();

        // Oy ekleme işlemi tamamlandığında, tbl_surveys tablosundaki vote sütununu 1 arttır
        $updateVoteSql = "UPDATE tbl_surveys SET vote = vote + 1 WHERE surveysID = :surveysID";
        $updateVoteStmt = $conn->prepare($updateVoteSql);
        $updateVoteStmt->bindParam(':surveysID', $surveysID);
        $updateVoteStmt->execute();
    } else {
        // Eğer aynı surveysID ve userID kombinasyonu varsa, optionID'yi kontrol et
        $checkOptionSql = "SELECT COUNT(*) FROM tbl_surveys_vote WHERE surveysID = :surveysID AND userID = :userID AND optionID = :optionID";
        $checkOptionStmt = $conn->prepare($checkOptionSql);
        $checkOptionStmt->bindParam(':surveysID', $surveysID);
        $checkOptionStmt->bindParam(':userID', $userID);
        $checkOptionStmt->bindParam(':optionID', $optionID);
        $checkOptionStmt->execute();
        $optionCount = $checkOptionStmt->fetchColumn();

        if ($optionCount == 0) {
            $sql_delete = "DELETE FROM tbl_surveys_vote WHERE surveysID = :surveysID AND userID = :userID";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bindParam(':surveysID', $surveysID);
            $stmt_delete->bindParam(':userID', $userID);
            $stmt_delete->execute(); // Silme işlemini gerçekleştir
            // Eğer aynı surveysID ve userID kombinasyonu varsa fakat optionID farklıysa, INSERT işlemi gerçekleştir
            $sql = "INSERT INTO tbl_surveys_vote (optionID, surveysID, userID) VALUES (:optionID, :surveysID, :userID)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':optionID', $optionID);
            $stmt->bindParam(':surveysID', $surveysID);
            $stmt->bindParam(':userID', $userID);
            $stmt->execute(); // Sorguyu çalıştır
            echo "güncellendi";
        } else {
            echo json_encode(array('error' => 'Bu kullanıcı ve seçenek için zaten oy kullanıldı.'));
        }
    }
 
   
} catch (PDOException $e) {
    // Hata durumunda JSON formatında hata mesajı gönder
    echo json_encode(array('error' => 'Veritabanı hatası: ' . $e->getMessage()));
}
?>