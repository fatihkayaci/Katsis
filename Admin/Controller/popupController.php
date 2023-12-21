
<?php
    include("../../DB/dbconfig.php");

    // Değişkenlere değerleri ata
    $apartman_adi = $_POST['apartman_adi']; // Veya isteğe bağlı olarak $_GET kullanılabilir
    $blokSay = $_POST['blokSay']; // Veya isteğe bağlı olarak $_GET kullanılabilir





    $sql = "INSERT INTO tbl_apartman (apartman_name, blok_sayisi) VALUES (:apartman_adi, :blokSay)";
    $stmt = $conn->prepare($sql);

    // Parametreleri bağla
    $stmt->bindParam(':apartman_adi', $apartman_adi);
    $stmt->bindParam(':blokSay', $blokSay);
 


    // Sorguyu çalıştır
    $stmt->execute();




?>
