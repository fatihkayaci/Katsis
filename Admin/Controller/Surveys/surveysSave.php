<?php
session_start();
include ("../../../DB/dbconfig.php");
require_once '../class.func.php';

try {
    // POST verilerini al
    if (isset($_POST['surveysName'], $_POST['secenek'], $_POST['lastDate'], $_POST['voters'])) {
        $surveysQuestion = $_POST['surveysName'];
        $secenek = $_POST['secenek'];
        $lastDate = $_POST['lastDate']; // Kullanıcıdan gelen tarih: "15 Temmuz 2024"
        $voters = $_POST['voters'];

        // Ay isimlerini Türkçe'den İngilizce'ye çevirme
        $turkishMonths = [
            'Ocak' => 'January', 'Şubat' => 'February', 'Mart' => 'March', 'Nisan' => 'April',
            'Mayıs' => 'May', 'Haziran' => 'June', 'Temmuz' => 'July', 'Ağustos' => 'August',
            'Eylül' => 'September', 'Ekim' => 'October', 'Kasım' => 'November', 'Aralık' => 'December'
        ];

        foreach ($turkishMonths as $turkish => $english) {
            $lastDate = str_replace($turkish, $english, $lastDate);
        }

        // Tarih formatını gün/ay/yıl'dan yıl/ay/gün'e dönüştür
        $date = DateTime::createFromFormat('d F Y', $lastDate);
        if ($date) {
            $lastDate = $date->format('Y-m-d'); // Veritabanı için yıl/ay/gün formatına dönüştür
            echo "Dönüştürülen lastDate: " . $lastDate . "<br>";
        } else {
            throw new Exception("Geçersiz tarih formatı: $lastDate");
        }

        // Veritabanı işlemleri
        $sql = "INSERT INTO tbl_surveys (apartmanID, surveysQuestion, lastDate, voters) VALUES (:apartmanID, :surveysQuestion, :lastDate, :voters)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':apartmanID', $_SESSION["apartID"]);
        $stmt->bindParam(':surveysQuestion', $surveysQuestion);
        $stmt->bindParam(':lastDate', $lastDate);
        $stmt->bindParam(':voters', $voters);
        $stmt->execute();

        
        $surveysID = $conn->lastInsertId();

        // Veritabanı işlemleri
        $sql2 = "INSERT INTO tbl_surveys_options (surveysID, optionName) VALUES (:surveysID, :optionName)";
        $stmt2 = $conn->prepare($sql2);
         foreach ($secenek as $option) {
            $stmt2->bindParam(':surveysID', $surveysID);
            $stmt2->bindParam(':optionName', $option);
            $stmt2->execute();
        }

    } else {
        echo "Gerekli POST verileri eksik.";
    }
} catch (PDOException $e) {
    echo "Veritabanı hatası: " . $e->getMessage();
} catch (Exception $e) {
    echo "Hata: " . $e->getMessage();
}
?>
 