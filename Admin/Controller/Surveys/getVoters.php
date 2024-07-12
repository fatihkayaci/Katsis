<?php
session_start(); // Session başlatma

include("../../../DB/dbconfig.php"); // Veritabanı bağlantı bilgilerini dahil et
require_once '../class.func.php'; // Fonksiyon dosyasını dahil et

try {
    $surveysID = $_POST['surveysID']; // POST ile gelen surveysID değerini al

    // SQL sorgusu
    $sql = "SELECT * FROM tbl_surveys_vote WHERE surveysID = :surveysID";
    
    // SQL sorgusunu hazırla ve parametreleri bağla
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':surveysID', $surveysID);
    $stmt->execute(); // Sorguyu çalıştır

    $userIDs = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $userIDs[] = $row['userID'];
    }

    if (!empty($userIDs)) {

        $userIDsStr = implode(',', array_map('intval', $userIDs));

        // userName, blok_adi ve daire_sayisi değerlerini sorgula
        $sql = "SELECT u.userName, d.blok_adi, d.daire_sayisi
                FROM tbl_users u
                JOIN tbl_daireler d ON u.userID = d.userID
                WHERE u.userID IN ($userIDsStr)";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        $results = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = array(
                'userName' => $row['userName'],
                'blok_adi' => $row['blok_adi'],
                'daire_sayisi' => $row['daire_sayisi']
            );
        }

        echo json_encode($results);
    } else {
        echo json_encode(array('error' => 'Kullanıcı bulunamadı'));
    }

} catch (PDOException $e) {
    echo json_encode(array('error' => 'Veritabanı hatası: ' . $e->getMessage()));
}
?>
