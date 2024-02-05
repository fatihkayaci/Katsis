<?php
// save_data.php

// Veritabanı bağlantısı ve diğer gerekli işlemler
// ...
include("../../DB/dbconfig.php");
try{
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dataToSave"])) {
        $dataToSave = json_decode($_POST["dataToSave"], true);
    
        // Verileri güncelleme işlemlerini gerçekleştirin
        foreach ($dataToSave as $data) {
            $kiraciID = $data["kiraciID"];
            $ownerID = $data["ownerID"];
    
            // Örneğin, tbl_daireler tablosunu güncelleme işlemi
            $sqlUpdate = "UPDATE tbl_daireler SET kiraciID = :kiraciID, katMalikiID = :ownerID";
            $stmtUpdate = $conn->prepare($sqlUpdate);
            $stmtUpdate->bindParam(':kiraciID', $kiraciID);
            $stmtUpdate->bindParam(':ownerID', $ownerID);
            // Diğer gerekli parametreleri de ekleyebilirsiniz.
            $stmtUpdate->execute();
        }
    
        // Başarılı güncelleme mesajı
        echo "Veriler başarıyla güncellendi!";
    } else {
        // Hatalı istek mesajı
        echo "Hatalı istek!";
    }
}catch (PDOException $e) {
    echo $e->getMessage(); // Hata mesajını ekrana yazdır
}

?>
