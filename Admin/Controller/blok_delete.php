<?php
// Veritabanı yapılandırma dosyasını içe aktar
include("../../DB/dbconfig.php");

// Güvenliğe yönelik olarak kullanıcı girdisini temizle
$id = isset($_POST['id']) ? htmlspecialchars($_POST['id']) : null;


$sql2 = "SELECT daire_sayisi FROM tbl_blok WHERE blok_id = :blokID";

// PDO sorgusunu hazırla ve çalıştır
$stmt = $conn->prepare($sql2);
$stmt->bindParam(':blokID', $id);
$stmt->execute();

// Sonuçları al
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Sonuç yoksa veya daire_sayisi sıfırdan büyükse
if ($result['daire_sayisi'] <= 0) {
    

    try {
        // Eğer $id boşsa veya geçerli bir sayı değilse, hata fırlat
        if (empty($id) || !is_numeric($id)) {
            throw new Exception("Geçersiz ID parametresi");
        }
    
        // SQL sorgusunu hazırla
        $sql = "DELETE FROM tbl_blok WHERE blok_id = :blokID";
    
        // PDO sorgusunu hazırla ve çalıştır
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':blokID', $id);
        $stmt->execute();
    
        // Başarılı bir yanıt oluştur
        $response = array(
            "sts"=>"1",
            "msg" => "Blok Başarıyla Silindi"
        );
    } catch (Exception $e) {
        // Hata durumunda işlem
        $response = array(
            "msg" => "Hata: " . $e->getMessage()
        );
    }
    
    


} else {
    $response = array(
        "sts"=>"0",   
        "msg" => "Blok ile İlişkili Daireler Olduğu İçin Silinemez. "
    );
}





// JSON formatında yanıtı gönder
header('Content-Type: application/json');
echo json_encode($response);



?>
