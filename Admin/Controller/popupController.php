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



    ////////////////////////////////////
   


  
    $sql3 = "SELECT * FROM tbl_apartman WHERE apartman_id = :lastInsertedId";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->bindParam(":lastInsertedId", $lastInsertedId);
    $stmt3->execute();

 
    $lastInsertedRow = $stmt3->fetch(PDO::FETCH_ASSOC);  //DEĞER CEPTE
     

    ////////////////////////////////////////

    try {
      $sql = "INSERT INTO tbl_blok (apartman_idd, blok_adi, daire_sayisi) VALUES ";
      $values1 = array();
  
      $apartman_id = $lastInsertedRow["apartman_id"];
  
      for ($i = 0; $i < count($BlokArray); $i++) {
          $daire_sayisi = $BlokArray[$i];
          $blok_adi = $BloknameArray[$i];
          $values1[] = "(?, ?, ?)";
      }
  
      $sql .= implode(", ", $values1);
      $stmt = $conn->prepare($sql);
  
      // Değişkenlerin türlerini belirterek bindParam kullanarak parametreleri bağlayın
      for ($i = 0; $i < count($BlokArray); $i++) {
          $stmt->bindParam(($i * 3) + 1, $apartman_id, PDO::PARAM_INT);
          $stmt->bindParam(($i * 3) + 2, $BloknameArray[$i], PDO::PARAM_STR);
          $stmt->bindParam(($i * 3) + 3, $BlokArray[$i], PDO::PARAM_INT);
      }
  
      $stmt->execute();
      
      echo "Veri başarıyla eklendi";
  } catch (PDOException $e) {
      echo "Hata: " . $e->getMessage();
  }
  


////////burada kaldım
    $sql45 = "SELECT * FROM tbl_blok WHERE apartman_idd = :lastInsertedId";
    $stmt33 = $conn->prepare($sql45);
    $stmt33->bindParam(":lastInsertedId", $lastInsertedId);
    $stmt33->execute();
    $rows = $stmt33->fetchAll(PDO::FETCH_ASSOC);
    $blokIdMapping = [];
// $rows içindeki verileri döngüye alıyoruz
foreach ($rows as $row) {
  // Blok adını anahtar, blok id'yi değer olarak atıyoruz
  $blokIdMapping[$row['blok_adi']] = $row['blok_id'];
}












    try {
      $sql = "INSERT INTO tbl_daireler (apartman_id, daire_sayisi, blok_adi) VALUES ";
      $values = array();
  
      $apartman_id = $lastInsertedRow["apartman_id"];
  
      for ($i = 0; $i < count($BlokArray); $i++) {
          $daire_sayisi = $BlokArray[$i];
          $blok_adi =$blokIdMapping[ $BloknameArray[$i]];
          
          for ($j = 1; $j <= $daire_sayisi; $j++) {
              $values[] = "( $apartman_id, $j,'" . "$blok_adi')";
          }
        }
      
      $sql .= implode(", ", $values);
      $stmt = $conn->prepare($sql);
      $stmt->execute();
  
      echo "Veri başarıyla eklendi";
  } catch (PDOException $e) {
      echo "Hata: " . $e->getMessage();
  }
  

/////////////////////////////////


$sql3 = "UPDATE tbl_users SET apartman_id = :apartman_id WHERE userEmail = :userEmail";
$stmt4 = $conn->prepare($sql3);
$stmt4->bindParam(":apartman_id", $lastInsertedRow["apartman_id"]);
$stmt4->bindParam(":userEmail", $_SESSION["mail"]);
$stmt4->execute();



$conn = null;
?>