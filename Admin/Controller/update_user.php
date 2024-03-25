<?php
include("../../DB/dbconfig.php");

try {
    // POST verilerini al
    $userID = $_POST['userID'];
    $userName = $_POST['userName'];
    $phoneNumber = $_POST['phoneNumber'];
    $userEmail = $_POST['userEmail'];
    $plate = $_POST['plate'];
    $gender = $_POST['gender'];
    //$userPass  = base64_encode($userPass);

    // Eğer e-posta adresi değişmişse ve yeni e-posta adresiyle aynı olan bir kullanıcı varsa güncelleme yapma
    if (!empty($userEmail) || trim($userEmail) !== "") {
        $checkExistingEmailSQL = "SELECT COUNT(*) FROM tbl_users WHERE userEmail = :userEmail AND userID != :userID";
        $checkExistingEmailStmt = $conn->prepare($checkExistingEmailSQL);
        $checkExistingEmailStmt->bindParam(':userEmail', $userEmail);
        $checkExistingEmailStmt->bindParam(':userID', $userID);
        $checkExistingEmailStmt->execute();
        echo "at";
        if ($checkExistingEmailStmt->fetchColumn() > 0) {
            // Aynı e-posta adresine sahip başka bir kullanıcı var, güncelleme yapma
            echo "Aynı e-posta adresine sahip başka bir kullanıcı olduğu için güncelleme yapılamadı.";
            return;
        }
    }

    // SQL sorgusunu hazırla
    $updateSQL = "UPDATE tbl_users SET 
            userName = :userName,
            phoneNumber = :phoneNumber,
            userEmail = :userEmail,
            plate = :plate,
            gender = :gender
            WHERE userID = :userID";

    // PDO sorgusunu hazırla ve çalıştır
    $updateStmt = $conn->prepare($updateSQL);
    $updateStmt->bindParam(':userID', $userID);
    $updateStmt->bindParam(':userName', $userName);
    $updateStmt->bindParam(':phoneNumber', $phoneNumber);
    $updateStmt->bindParam(':userEmail', $userEmail);
    $updateStmt->bindParam(':plate', $plate);
    $updateStmt->bindParam(':gender', $gender);
    $updateStmt->execute();
    
    echo 1;
} catch (PDOException $e) {
    echo $e;
}
?>
