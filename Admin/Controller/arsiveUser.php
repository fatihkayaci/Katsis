<?php
include("../../DB/dbconfig.php");

try {
    session_start();
    $updatedStatuses = $_SESSION['updatedStatuses'];
    $updatedBlocks = $_SESSION['updatedBlocks'];
    $arsive = $_POST['arsive'];
    $result = $_SESSION['result'];
    if (isset($result['kiraciID'])) {
        $userID = $result['kiraciID'];
    } else if (isset($result['katMalikiID'])) {
        $userID = $result['katMalikiID'];
    }

    if (in_array('kiraci', $updatedStatuses)) {
        $oldState = 'kiraci';
    } else {
        $oldState = 'katMaliki';
    }
    
    // tbl_users tablosundaki oldNumber ve oldBlock sütunlarını güncelle
    foreach ($updatedBlocks as $block) {
        $blockLetter = $block['letter'];
        $blockNumber = $block['number'];

        // tbl_users tablosundaki oldNumber ve oldBlock sütunlarını güncelle
        $updateUserSQL = "UPDATE tbl_users 
                          SET oldNumber = :blockNumber, oldBlock = :blockLetter 
                          WHERE userID = :userID";

        $updateUserStmt = $conn->prepare($updateUserSQL);
        $updateUserStmt->bindParam(':blockNumber', $blockNumber, PDO::PARAM_STR);
        $updateUserStmt->bindParam(':blockLetter', $blockLetter, PDO::PARAM_STR);
        $updateUserStmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $updateUserStmt->execute();
    }

    // Kullanıcıyı güncelleyen SQL sorgusunu hazırlayın
    $currentTime = date("Y-m-d H:i:s"); // Şu anki zamanı al
    $updateUserStateSQL = "UPDATE tbl_users 
                           SET arsive = :arsive, arsiveTime = NOW(), oldState = :oldState 
                           WHERE userID = :userID";

    $updateUserStateStmt = $conn->prepare($updateUserStateSQL);
    $updateUserStateStmt->bindParam(':arsive', $arsive, PDO::PARAM_INT);
    $updateUserStateStmt->bindParam(':oldState', $oldState);
    $updateUserStateStmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $updateUserStateStmt->execute();
    
    echo 1;
} catch (PDOException $e) {
    echo $e->getMessage(); // Hata mesajını ekrana yazdır
}
?>
