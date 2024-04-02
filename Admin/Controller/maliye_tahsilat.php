<?php
include("../../DB/dbconfig.php");

$daireId = $_POST['daireId'];
$userId = $_POST['userId'];
$apartmanId = $_POST['apartmanId'];
$gelir_turu = $_POST['gelir_turu'];
$aciklamaValue = $_POST['aciklamaValue'];
$tahsilatTutarValue = floatval(str_replace(',', '.', $_POST['TahsilatTutarValue']));
$dateInputValue = $_POST['dateInputValue'];

try {
    $sql = "SELECT maliye_id, borc_miktar FROM tbl_maliye WHERE daire_id = :daireId AND user_id = :userId AND apartman_id = :apartmanId AND maliye_turu = 1";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':daireId', $daireId);
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':apartmanId', $apartmanId);
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $kalanTutar = $tahsilatTutarValue;
    foreach ($rows as $row) {
        if ($kalanTutar > 0) {
            $borcId = $row['maliye_id'];
            $borcMiktar = $row['borc_miktar'];
           
            echo($borcMiktar);
            echo($kalanTutar);
            if($kalanTutar > $borcMiktar){
                $kalanTutar =  $kalanTutar-$borcMiktar ;
            }else{
                $borcMiktar =  $borcMiktar -$kalanTutar;
            }

            echo($kalanTutar);
break;
           
        }
    }

   

    
} catch(PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>

