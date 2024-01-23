<?php
include("../../DB/dbconfig.php");

try {
    // POST verilerini al
    $userID = $_POST['userID'];
    $userName = $_POST['userName'];
    $tc = $_POST['tc'];
    $phoneNumber = $_POST['phoneNumber'];
    $durum = $_POST['durum'];
    $userEmail = $_POST['userEmail'];
    $userPass = $_POST['userPass'];
    $plate = $_POST['plate'];
    $gender = $_POST['gender'];
    // Eğer e-posta adresi değişmişse ve yeni e-posta adresiyle aynı olan bir kullanıcı varsa güncelleme yapma
    $checkExistingEmailSQL = "SELECT COUNT(*) FROM tbl_users WHERE userEmail = :userEmail AND userID != :userID";
    $checkExistingEmailStmt = $conn->prepare($checkExistingEmailSQL);
    $checkExistingEmailStmt->bindParam(':userEmail', $userEmail);
    $checkExistingEmailStmt->bindParam(':userID', $userID);
    $checkExistingEmailStmt->execute();

    if ($checkExistingEmailStmt->fetchColumn() > 0) {
        // Aynı e-posta adresine sahip başka bir kullanıcı var, güncelleme yapma
        echo "Aynı e-posta adresine sahip başka bir kullanıcı olduğu için güncelleme yapılamadı.";
    } else {
        // Eğer e-posta adresi değişmişse veya değişmemişse ve başka bir değişiklik yapılmışsa güncelleme yap
        // SQL sorgusunu hazırla
        $updateSQL = "UPDATE tbl_users SET 
                userName = :userName,
                tc = :tc,
                phoneNumber = :phoneNumber,
                durum = :durum,
                userEmail = :userEmail,
                userPass = :userPass,
                plate = :plate,
                gender = :gender
                WHERE userID = :userID";

        // PDO sorgusunu hazırla ve çalıştır
        $updateStmt = $conn->prepare($updateSQL);
        $updateStmt->bindParam(':userID', $userID);
        $updateStmt->bindParam(':userName', $userName);
        $updateStmt->bindParam(':tc', $tc);
        $updateStmt->bindParam(':phoneNumber', $phoneNumber);
        $updateStmt->bindParam(':durum', $durum);
        $updateStmt->bindParam(':userEmail', $userEmail);
        $updateStmt->bindParam(':userPass', $userPass);
        $updateStmt->bindParam(':plate', $plate);
        $updateStmt->bindParam(':gender', $gender);
        $updateStmt->execute();
        echo 1;
    }
} catch (PDOException $e) {
    echo $e;
}
?>
