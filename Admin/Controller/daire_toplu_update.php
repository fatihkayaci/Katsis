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
