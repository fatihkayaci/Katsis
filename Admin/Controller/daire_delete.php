
<?php

// Veritabanı yapılandırma dosyasını içe aktar
include("../../DB/dbconfig.php");
$checkedDaireIDs = isset($_POST['checkedDaireIDs']) ? $_POST['checkedDaireIDs'] : null;
$checkedBlokIDs = isset($_POST['checkedBlokIDs']) ? $_POST['checkedBlokIDs'] : null;
$id = isset($_POST['id']) ? $_POST['id'] : null;



try {
    $daireler = implode(',', $checkedDaireIDs);

    // SQL sorgusu hazırlama
    $sql = "DELETE FROM tbl_daireler WHERE daire_id IN ($daireler)";
    $sql = $sql. "AND apartman_id=".$id;
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();
    if ($result) {
        $deletedRowCount = $stmt->rowCount(); 
        $response = array(
            "sts"=>"true",
            "msg" => "Silme İşlemi Başarıyla Gerçekleşti",
            "str"=> $deletedRowCount,
        );

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
   
    } else {
        $response = array(
            "sts"=>"false",
            "msg" => "Silme İşlemi Başarısız!"
        );
    }

} catch (\Throwable $th) {
    $response = array(
        "sts"=>"false",
        "msg" => $th
    );
}

echo json_encode($response);

?>