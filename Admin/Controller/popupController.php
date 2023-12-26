<?php
    session_start();
    include("../../DB/dbconfig.php");

    // Değişkenlere değerleri ata
    $apartman_adi = $_POST['apartman_adi']; // Veya isteğe bağlı olarak $_GET kullanılabilir
    $blokSay = $_POST['blokSay']; // Veya isteğe bağlı olarak $_GET kullanılabilir
    $BlokArray = $_POST['BlokArray'];
    $BloknameArray = $_POST['BloknameArray'];

  

   

    $sql2 = "UPDATE tbl_users SET popup = 0 WHERE userEmail = :userEmail";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bindParam(":userEmail", $_SESSION["mail"]);
    $stmt2->execute();
  
    $sql = "INSERT INTO tbl_apartman (apartman_name, blok_sayisi) VALUES (:apartman_adi, :blokSay)";
    $stmt = $conn->prepare($sql);

    // Parametreleri bağla
    $stmt->bindParam(':apartman_adi', $apartman_adi);
    $stmt->bindParam(':blokSay', $blokSay);
 


    // Sorguyu çalıştır
    $stmt->execute();
    
    $lastInsertedId = $conn->lastInsertId();

  
    $sql3 = "SELECT * FROM tbl_apartman WHERE apartman_id = :lastInsertedId";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->bindParam(":lastInsertedId", $lastInsertedId);
    $stmt3->execute();

 
    $lastInsertedRow = $stmt3->fetch(PDO::FETCH_ASSOC);  //DEĞER CEPTE
     

    
try{
  // Veritabanına veri eklemek için SQL sorgusu
  $sql = "INSERT INTO tbl_daireler (apartman_id, daire_sayisi, blok_adi) VALUES (:apartman_id, :daire_sayisi, :blok_adi)";
  $stmt = $conn->prepare($sql);

  // Her bir öğe için veri ekleyin
  for ($i = 0; $i < count($BlokArray); $i++) {
      $daire_sayisi = $BlokArray[$i];
      $blok_adi = $BloknameArray[$i];

    for($j =1; $j <=  $daire_sayisi;$j++ ){
    // Parametreleri bağla
    $stmt->bindParam(':apartman_id', $lastInsertedRow["apartman_id"]);
    $stmt->bindParam(':daire_sayisi', $j);
    $stmt->bindParam(':blok_adi', $blok_adi);

 // Sorguyu çalıştır
 $stmt->execute();

    }


       
  }

  echo "Veri başarıyla eklendi";
} catch (PDOException $e) {
  echo "Hata: " . $e->getMessage();
}





$sql3 = "UPDATE tbl_users SET apartman_id = :apartman_id WHERE userEmail = :userEmail";
$stmt4 = $conn->prepare($sql3);
$stmt4->bindParam(":apartman_id", $lastInsertedRow["apartman_id"]);
$stmt4->bindParam(":userEmail", $_SESSION["mail"]);
$stmt4->execute();



$conn = null;









    
?>