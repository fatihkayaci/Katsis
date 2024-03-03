<?php
include("../../DB/dbconfig.php");

$daireNo = $_POST['daireNo'];
$daireKat = $_POST['daireKat'];
$daireBlok = $_POST['daireBlok'];
$daireGrup = $_POST['daireGrup'];
$daireBrut = $_POST['daireBrut'];
$daireNet = $_POST['daireNet'];
$dairePay = $_POST['dairePay'];
$id = $_POST['id'];

try {
    // SQL sorgusu hazırlama
    $sql = "INSERT INTO tbl_daireler (apartman_id, blok_adi,daire_sayisi,kat, dGrubu,brut,net,pay) VALUES (:apartman_id, :blok_adi, :daire_sayisi,:kat, :dGrubu, :brut, :net, :pay)";
    $stmt = $conn->prepare($sql);

    // Değişkenleri bağlama
    $stmt->bindParam(':apartman_id', $id);
    $stmt->bindParam(':blok_adi', $daireBlok);
    $stmt->bindParam(':daire_sayisi', $daireNo);
    $stmt->bindParam(':kat', $daireKat);
    $stmt->bindParam(':dGrubu', $daireGrup);
    $stmt->bindParam(':brut', $daireBrut);
    $stmt->bindParam(':net', $daireNet);
    $stmt->bindParam(':pay', $dairePay);
    // Sorguyu çalıştırma
    $stmt->execute();

    // Yeni eklenen kaydın blok_id değerini al
    $msg =" Daire Başarıyla Eklendi";
    $sql = "SELECT blok_adi, COUNT(*) as adet FROM tbl_daireler WHERE apartman_id = :id GROUP BY blok_adi";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
    
    $sql3 = "UPDATE tbl_blok SET daire_sayisi = 0 WHERE apartman_idd = $id";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->execute();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    
        $sql2 = "UPDATE tbl_blok SET daire_sayisi = :adet WHERE blok_id = :blok_id";
    
      
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bindParam(':adet', $row['adet']);
        $stmt2->bindParam(':blok_id', $row['blok_adi']);
        $stmt2->execute();
        
    } 
    }
    // Başarılı olduğunda JSON yanıtı hazırla
    $response = array(
        "status" => 1,
        "msg" => $msg  
    );

    // JSON formatında yanıtı gönder
    header('Content-Type: application/json');
    echo json_encode($response);
} catch (PDOException $e) {
    // Hata durumunda işlem
    $response = array(
        "status" => 0,
        "error" => "Hata: " . $e->getMessage()
    );

    // JSON formatında yanıtı gönder
    header('Content-Type: application/json');
    echo json_encode($response);
}

?>


