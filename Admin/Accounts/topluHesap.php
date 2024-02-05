<!--
    sonradan eklenecekler işlemler kısmı eklenecek.
    icra durumu
    bakiye.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <button type="button" class="btn btnx btn-primary btn-size" id="saveButton">Kaydet</button>
    <?php
try {
    $sql = "SELECT blok_adi, daire_sayisi, kiraciID, katMalikiID
            FROM tbl_daireler
            WHERE apartman_id=" . $_SESSION["apartID"];

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Sonuç kümesinin satır sayısını kontrol etme
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        echo '<table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Blok Adı</th>
                        <th>Daire Sayısı</th>
                        <th>Kiracı Adı</th>
                        <th>Kat Maliki Adı</th>
                    </tr>
                </thead>
                <tbody>';

                foreach ($result as $row) {
                    $kiraciID = $row["kiraciID"];
                    $katMalikiID = $row["katMalikiID"];
                
                    // Diğer tablodan ilgili kiracı bilgilerini çekme
                    $sqlKiraci = "SELECT * FROM tbl_users WHERE userID = :kiraciID";
                    $stmtKiraci = $conn->prepare($sqlKiraci);
                    $stmtKiraci->bindParam(':kiraciID', $kiraciID);
                    $stmtKiraci->execute();
                    $kiraciBilgisi = $stmtKiraci->fetch(PDO::FETCH_ASSOC);
                
                    // Diğer tablodan ilgili kat maliki bilgilerini çekme
                    $sqlKatMaliki = "SELECT * FROM tbl_users WHERE userID = :katMalikiID";
                    $stmtKatMaliki = $conn->prepare($sqlKatMaliki);
                    $stmtKatMaliki->bindParam(':katMalikiID', $katMalikiID);
                    $stmtKatMaliki->execute();
                    $katMalikiBilgisi = $stmtKatMaliki->fetch(PDO::FETCH_ASSOC);
                
                    // Kiracı ve Kat Maliki bilgileri var mı kontrolü
                    if ($kiraciBilgisi && $katMalikiBilgisi) {
                        echo '<tr data-userid="">
                                <td>' . $row["blok_adi"] . '</td>
                                <td>' . $row["daire_sayisi"] . '</td>
                                <td contenteditable="true">' . $kiraciBilgisi['userName'] . '</td>
                                <td contenteditable="true">' . $katMalikiBilgisi['userName'] . '</td>
                            </tr>';
                    } else {
                        // Kullanıcı bilgileri bulunamadıysa, hata mesajı veya başka bir işlem
                        echo '<tr data-userid="">
                                <td>' . $row["blok_adi"] . '</td>
                                <td>' . $row["daire_sayisi"] . '</td>
                                <td contenteditable="true">' . ($kiraciBilgisi ? $kiraciBilgisi['userName'] : '') . '</td>
                                <td contenteditable="true">' . ($katMalikiBilgisi ? $katMalikiBilgisi['userName'] : '') . '</td>
                            </tr>';
                    }
                }
        echo '</tbody>
            </table>';
    } else {
        echo "0 results";
    }
} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
?>


    <body>