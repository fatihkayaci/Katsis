<?php
echo "celal beni sikti";
/*
try {
    // POST verilerini al
    $fullName = $_POST['fullName'];
    $TC = $_POST['TC'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];
    $vehiclePlate = $_POST['vehiclePlate'];
    $gender = $_POST['gender'];

    // SQL sorgusunu hazırla
    $sql = "INSERT INTO tbl_kullanici (fullName, TC, phoneNumber, email, vehiclePlate, gender) VALUES 
    (:fullName, :TC, :phoneNumber, :email, :vehiclePlate, :gender)";
    
    // PDO sorgusunu hazırla ve çalıştır
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':fullName', $fullName);
    $stmt->bindParam(':TC', $TC);
    $stmt->bindParam(':phoneNumber', $phoneNumber);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':vehiclePlate', $vehiclePlate);
    $stmt->bindParam(':gender', $gender);
    $stmt->execute();

    echo "Veri başarıyla kaydedildi";
} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
*/
?>
