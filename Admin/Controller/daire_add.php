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
    addDSayisi($daireBlok);
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





function addDSayisi($id){
    try {
        // PDO bağlantısı $conn değişkeni ile sağlanmalıdır, bunu varsayarak devam ediyorum
        global $conn;
       
        $sql = "UPDATE tbl_blok SET daire_sayisi = daire_sayisi + 1 WHERE blok_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        // Sorguyu çalıştırma
        $stmt->execute();
    
    } catch (PDOException $e) {
        echo "Hata: " . $e->getMessage(); // Hatanın ekrana basılması veya uygun bir şekilde işlenmesi
    }
}


?>


