<?php
include("../../DB/dbconfig.php");

try {
    // POST verilerini al
    $kullaniciID = $_POST['kullaniciID'];
    $fullName = $_POST['fullName'];
    $tc = $_POST['tc'];
    $phoneNumber = $_POST['phoneNumber'];
    $durum = $_POST['durum'];
    $email = $_POST['email'];
    $sifre = $_POST['sifre'];
    $vehiclePlate = $_POST['vehiclePlate'];
    $gender = $_POST['gender'];

    // Eğer e-posta adresi değişmişse ve yeni e-posta adresiyle aynı olan bir kullanıcı varsa güncelleme yapma
    $checkExistingEmailSQL = "SELECT COUNT(*) FROM tbl_kullanici WHERE email = :email AND kullaniciID != :kullaniciID";
    $checkExistingEmailStmt = $conn->prepare($checkExistingEmailSQL);
    $checkExistingEmailStmt->bindParam(':email', $email);
    $checkExistingEmailStmt->bindParam(':kullaniciID', $kullaniciID);
    $checkExistingEmailStmt->execute();

    if ($checkExistingEmailStmt->fetchColumn() > 0) {
        // Aynı e-posta adresine sahip başka bir kullanıcı var, güncelleme yapma
        echo "Aynı e-posta adresine sahip başka bir kullanıcı olduğu için güncelleme yapılamadı.";
    } else {
        // Eğer e-posta adresi değişmişse veya değişmemişse ve başka bir değişiklik yapılmışsa güncelleme yap
        // SQL sorgusunu hazırla
        $updateSQL = "UPDATE tbl_kullanici SET 
                fullName = :fullName,
                tc = :tc,
                phoneNumber = :phoneNumber,
                durum = :durum,
                email = :email,
                sifre = :sifre,
                vehiclePlate = :vehiclePlate,
                gender = :gender
                WHERE kullaniciID = :kullaniciID";

        // PDO sorgusunu hazırla ve çalıştır
        $updateStmt = $conn->prepare($updateSQL);
        $updateStmt->bindParam(':kullaniciID', $kullaniciID);
        $updateStmt->bindParam(':fullName', $fullName);
        $updateStmt->bindParam(':tc', $tc);
        $updateStmt->bindParam(':phoneNumber', $phoneNumber);
        $updateStmt->bindParam(':durum', $durum);
        $updateStmt->bindParam(':email', $email);
        $updateStmt->bindParam(':sifre', $sifre);
        $updateStmt->bindParam(':vehiclePlate', $vehiclePlate);
        $updateStmt->bindParam(':gender', $gender);
        $updateStmt->execute();
        
        echo 1; // Başarı durumu
    }
} catch (PDOException $e) {
    echo $e;
}
?>
