<?php 
error_reporting(E_ALL);
 ini_set('display_errors', 1);
include("../../DB/dbconfig.php");

$checkedDaireIDs = isset($_POST['checkedDaireIDs']) ? $_POST['checkedDaireIDs'] : null;
$id = isset($_POST['id']) ? $_POST['id'] : null;
$daireKat = isset($_POST['daireKat']) ? $_POST['daireKat'] : null;
$daireBlok = isset($_POST['daireBlok']) ? $_POST['daireBlok'] : null;
$daireGrup = isset($_POST['daireGrup']) ? $_POST['daireGrup'] : null;
$daireBrut = isset($_POST['daireBrut']) ? $_POST['daireBrut'] : null;
$daireNet = isset($_POST['daireNet']) ? $_POST['daireNet'] : null;
$dairePay = isset($_POST['dairePay']) ? $_POST['dairePay'] : null;


try {
    $daireler = implode(',', $checkedDaireIDs);

    // SQL sorgusu hazırlama
    $sql = "UPDATE tbl_daireler SET ";

if (!empty($daireBlok)) {
    $sql .= "blok_adi = :blok_adi, ";
}
if (!empty($daireKat)) {
    $sql .= "kat = :kat, ";
}
if (!empty($daireGrup)) {
    $sql .= "dGrubu = :dGrubu, ";
}
if (!empty($daireBrut)) {
    $sql .= "brut = :brut, ";
}
if (!empty($daireNet)) {
    $sql .= "net = :net, ";
}
if (!empty($dairePay)) {
    $sql .= "pay = :pay, ";
}

// Son virgülü kaldır
$sql = rtrim($sql, ', ');

$sql .= " WHERE daire_id IN ($daireler) AND apartman_id = :apartman_id";

$stmt = $conn->prepare($sql);

// Değerlerin bağlanması
if (!empty($daireBlok)) {
    $stmt->bindParam(":blok_adi", $daireBlok);
}
if (!empty($daireKat)) {
    $stmt->bindParam(":kat", $daireKat);
}
if (!empty($daireGrup)) {
    $stmt->bindParam(":dGrubu", $daireGrup);
}
if (!empty($daireBrut)) {
    $stmt->bindParam(":brut", $daireBrut);
}
if (!empty($daireNet)) {
    $stmt->bindParam(":net", $daireNet);
}
if (!empty($dairePay)) {
    $stmt->bindParam(":pay", $dairePay);
}

$stmt->bindParam(":apartman_id", $id);

$result = $stmt->execute();
    if ($result) {
       
        $response = array(
            "sts"=>"true",
            "msg" => "Güncelleme İşlemi Başarıyla Gerçekleşti",
            
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
            "msg" => "Güncelleme İşlemi Başarısız!"
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
