<?php
include ("../../DB/dbconfig.php");

session_start();

try {
    // "resultsArrayKiraci" ve "resultsArrayKatMaliki" session'larını al
    $resultsArrayKiraci = $_SESSION['resultsArrayKiraci'];
    $resultsArrayKatMaliki = $_SESSION['resultsArrayKatMaliki'];

    // Her bir kiracı için
    foreach ($resultsArrayKiraci as $kiraci) {
        $blokElement = $kiraci['blokElement'];

        // Blok elementinden letter ve number değerlerini ayır
        $oldBlock = $blokElement['letter'];
        $oldNumber = $blokElement['number'];

        $statuse = 'kiraci';
        // tbl_arsive tablosuna ekleme işlemi
        $sqlKiraciEkle = "INSERT INTO tbl_arsive (userID, fullName, email, phoneNumber, TC, gender, plate, oldBlock, oldNumber, statuse)
                          VALUES (:userID, :fullName, :email, :phoneNumber, :TC, :gender, :plate, :oldBlock, :oldNumber, :statuse)";
        $stmtKiraciEkle = $conn->prepare($sqlKiraciEkle);
        $stmtKiraciEkle->bindParam(':userID', $kiraci['kiraciID'], PDO::PARAM_INT);
        $stmtKiraciEkle->bindParam(':fullName', $kiraci['userName'], PDO::PARAM_STR);
        $stmtKiraciEkle->bindParam(':email', $kiraci['userEmail'], PDO::PARAM_STR);
        $stmtKiraciEkle->bindParam(':gender', $kiraci['gender'], PDO::PARAM_STR);
        $stmtKiraciEkle->bindParam(':phoneNumber', $kiraci['phoneNumber'], PDO::PARAM_STR);
        $stmtKiraciEkle->bindParam(':plate', $kiraci['plate'], PDO::PARAM_STR);
        $stmtKiraciEkle->bindParam(':TC', $kiraci['tc'], PDO::PARAM_STR);
        $stmtKiraciEkle->bindParam(':oldBlock', $oldBlock, PDO::PARAM_STR);
        $stmtKiraciEkle->bindParam(':oldNumber', $oldNumber, PDO::PARAM_STR);
        $stmtKiraciEkle->bindParam(':statuse', $statuse, PDO::PARAM_STR);
        $stmtKiraciEkle->execute();
    }

    // Her bir kat maliki için aynı işlemi tekrarlayın
    foreach ($resultsArrayKatMaliki as $katMaliki) {
        $blokElement = $katMaliki['blokElement'];

        // Blok elementinden letter ve number değerlerini ayır
        $oldBlock = $blokElement['letter'];
        $oldNumber = $blokElement['number'];

        $statuse = 'katMaliki';
        // tbl_arsive tablosuna ekleme işlemi
        $sqlKatMalikiEkle = "INSERT INTO tbl_arsive (userID, fullName, email, phoneNumber, TC, gender, plate, oldBlock, oldNumber, statuse)
                      VALUES (:userID, :fullName, :email, :phoneNumber, :TC, :gender, :plate, :oldBlock, :oldNumber, :statuse)";
        $stmtKatMalikiEkle = $conn->prepare($sqlKatMalikiEkle);
        $stmtKatMalikiEkle->bindParam(':userID', $katMaliki['katMalikiID'], PDO::PARAM_INT);
        $stmtKatMalikiEkle->bindParam(':fullName', $katMaliki['userName'], PDO::PARAM_STR);
        $stmtKatMalikiEkle->bindParam(':email', $katMaliki['userEmail'], PDO::PARAM_STR);
        $stmtKatMalikiEkle->bindParam(':gender', $katMaliki['gender'], PDO::PARAM_STR);
        $stmtKatMalikiEkle->bindParam(':phoneNumber', $katMaliki['phoneNumber'], PDO::PARAM_STR);
        $stmtKatMalikiEkle->bindParam(':plate', $katMaliki['plate'], PDO::PARAM_STR);
        $stmtKatMalikiEkle->bindParam(':TC', $katMaliki['tc'], PDO::PARAM_STR);
        $stmtKatMalikiEkle->bindParam(':oldBlock', $oldBlock, PDO::PARAM_STR);
        $stmtKatMalikiEkle->bindParam(':oldNumber', $oldNumber, PDO::PARAM_STR);
        $stmtKatMalikiEkle->bindParam(':statuse', $statuse, PDO::PARAM_STR); // Örnek bir statü değeri
        $stmtKatMalikiEkle->execute();
    }

    // Başarılı bir şekilde eklendiğini kontrol etmek için bir mesaj döndür
    echo "Kullanıcılar başarıyla arşive eklendi.";
} catch (PDOException $e) {
    // Hata durumunda hatayı ekrana yazdır
    echo "Hata: " . $e->getMessage();
}
?>