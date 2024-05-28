<?php
include ("../../../DB/dbconfig.php");

session_start();

try {
    // "resultsArrayKiraci" ve "resultsArrayKatMaliki" session'larını al
    $resultsArrayKiraci = $_SESSION['resultsArrayKiraci'];
    $resultsArrayKatMaliki = $_SESSION['resultsArrayKatMaliki'];


    
    // Her bir kat maliki için aynı işlemi tekrarlayın
    foreach ($resultsArrayKatMaliki as $katMaliki) {
        $blokElement = $katMaliki['blokElement'];

        // Blok elementinden letter ve number değerlerini ayır
        $oldBlock = $blokElement['letter'];
        $oldNumber = $blokElement['number'];

        $status = 'katMaliki';
        // tbl_arsive tablosuna ekleme işlemi
        $sqlKatMalikiEkle = "INSERT INTO tbl_arsive (grupID, fullName, email, phoneNumber, TC, gender, plate, oldBlock, oldNumber, status)
                      VALUES (:grupID, :fullName, :email, :phoneNumber, :TC, :gender, :plate, :oldBlock, :oldNumber, :status)";
        $stmtKatMalikiEkle = $conn->prepare($sqlKatMalikiEkle);
        $stmtKatMalikiEkle->bindParam(':grupID', $katMaliki['katMalikiID'], PDO::PARAM_INT);
        $stmtKatMalikiEkle->bindParam(':fullName', $katMaliki['userName'], PDO::PARAM_STR);
        $stmtKatMalikiEkle->bindParam(':email', $katMaliki['userEmail'], PDO::PARAM_STR);
        $stmtKatMalikiEkle->bindParam(':gender', $katMaliki['gender'], PDO::PARAM_STR);
        $stmtKatMalikiEkle->bindParam(':phoneNumber', $katMaliki['phoneNumber'], PDO::PARAM_STR);
        $stmtKatMalikiEkle->bindParam(':plate', $katMaliki['plate'], PDO::PARAM_STR);
        $stmtKatMalikiEkle->bindParam(':TC', $katMaliki['tc'], PDO::PARAM_STR);
        $stmtKatMalikiEkle->bindParam(':oldBlock', $oldBlock, PDO::PARAM_STR);
        $stmtKatMalikiEkle->bindParam(':oldNumber', $oldNumber, PDO::PARAM_STR);
        $stmtKatMalikiEkle->bindParam(':status', $status, PDO::PARAM_STR); // Örnek bir statü değeri
        $stmtKatMalikiEkle->execute();

         // tbl_daireler tablosunda kullanıcı var mı kontrol et
         $stmtCheckKatMaliki = $conn->prepare("SELECT COUNT(*) FROM tbl_daireler WHERE katMalikiID = :katMalikiID");
         $stmtCheckKatMaliki->bindParam(':katMalikiID', $katMaliki['katMalikiID'], PDO::PARAM_INT);
         $stmtCheckKatMaliki->execute();
         $katMalikiExists = $stmtCheckKatMaliki->fetchColumn();
 
         // Eğer kullanıcı tbl_daireler tablosunda yoksa, tbl_users tablosundan sil
         if ($katMalikiExists == 0) {
             $stmtDeleteKatMaliki = $conn->prepare("DELETE FROM tbl_users WHERE userID = :userID");
             $stmtDeleteKatMaliki->bindParam(':userID', $katMaliki['katMalikiID'], PDO::PARAM_INT);
             $stmtDeleteKatMaliki->execute();
         }
    }
    
    // Her bir kiracı için
    foreach ($resultsArrayKiraci as $kiraci) {
        $blokElement = $kiraci['blokElement'];

        // Blok elementinden letter ve number değerlerini ayır
        $oldBlock = $blokElement['letter'];
        $oldNumber = $blokElement['number'];

        $status = 'kiraci';
        // tbl_arsive tablosuna ekleme işlemi
        $sqlKiraciEkle = "INSERT INTO tbl_arsive (grupID,fullName, email, phoneNumber, TC, gender, plate, oldBlock, oldNumber, status)
                          VALUES (:grupID, :fullName, :email, :phoneNumber, :TC, :gender, :plate, :oldBlock, :oldNumber, :status)";
        $stmtKiraciEkle = $conn->prepare($sqlKiraciEkle);
        $stmtKiraciEkle->bindParam(':grupID', $kiraci['kiraciID'], PDO::PARAM_INT);
        $stmtKiraciEkle->bindParam(':fullName', $kiraci['userName'], PDO::PARAM_STR);
        $stmtKiraciEkle->bindParam(':email', $kiraci['userEmail'], PDO::PARAM_STR);
        $stmtKiraciEkle->bindParam(':gender', $kiraci['gender'], PDO::PARAM_STR);
        $stmtKiraciEkle->bindParam(':phoneNumber', $kiraci['phoneNumber'], PDO::PARAM_STR);
        $stmtKiraciEkle->bindParam(':plate', $kiraci['plate'], PDO::PARAM_STR);
        $stmtKiraciEkle->bindParam(':TC', $kiraci['tc'], PDO::PARAM_STR);
        $stmtKiraciEkle->bindParam(':oldBlock', $oldBlock, PDO::PARAM_STR);
        $stmtKiraciEkle->bindParam(':oldNumber', $oldNumber, PDO::PARAM_STR);
        $stmtKiraciEkle->bindParam(':status', $status, PDO::PARAM_STR);
        $stmtKiraciEkle->execute();

        // tbl_daireler tablosunda kullanıcı var mı kontrol et
        $stmtCheckKiraci = $conn->prepare("SELECT COUNT(*) FROM tbl_daireler WHERE kiraciID = :kiraciID");
        $stmtCheckKiraci->bindParam(':kiraciID', $kiraci['kiraciID'], PDO::PARAM_INT);
        $stmtCheckKiraci->execute();
        $kiraciExists = $stmtCheckKiraci->fetchColumn();

        // Eğer kullanıcı tbl_daireler tablosunda yoksa, tbl_users tablosundan sil
        if ($kiraciExists == 0) {
            $stmtDeleteKiraci = $conn->prepare("DELETE FROM tbl_users WHERE userID = :userID");
            $stmtDeleteKiraci->bindParam(':userID', $kiraci['kiraciID'], PDO::PARAM_INT);
            $stmtDeleteKiraci->execute();
        }
    }

   
    // Başarılı bir şekilde eklendiğini kontrol etmek için bir mesaj döndür
    echo "Kullanıcılar başarıyla arşive eklendi.";
} catch (PDOException $e) {
    // Hata durumunda hatayı ekrana yazdır
    echo "Hata: " . $e->getMessage();
}
?>