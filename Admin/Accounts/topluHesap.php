<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toplu Hesap Ekleme</title>
</head>

<body>

    <div class="table-responsive-vertical cener-table">
        <div class="input-group-div">

            <div class="input-group1">
                <button type="button" class="btn-custom-outline" id="saveButton">Kaydet</button>
            </div>

            <div class="input-group">
                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                <input type="text" class="form-control" placeholder="Arama...">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col">
            <input class="input" type="text" name="apartman_id" value=<?php echo $_SESSION["apartID"]; ?> hidden>
        </div>
    </div>
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
            echo '
            <div class="table-responsive-vertical shadow-z-1 cener-table">
                <table id="example" class="table table-hover table-mc-light-blue">
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
                $blokAdi = $row["blok_adi"];
                $daireSayisi = $row["daire_sayisi"];
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
                                <td data-title="Blok Adı" name="blok">' . $blokAdi . '</td>
                                <td data-title="Daire Sayısı" name="daire">' . $daireSayisi . '</td>
                                <td data-title="Kiracı Adı"><input type="text" name="kiraciUserName" value="' . $kiraciBilgisi['userName'] . '" /></td>
                                <td data-title="Kat Maliki Adı"><input type="text" name="katMalikiUserName" value="' . $katMalikiBilgisi['userName'] . '" /></td>
                            </tr>';
                } else {
                    // Kullanıcı bilgileri bulunamadıysa, hata mesajı veya başka bir işlem
                    echo '<tr data-userid="">
                                <td data-title="Blok Adı" name="blok">' . $blokAdi . '</td>
                                <td data-title="Daire Sayısı" name="daire">' . $daireSayisi . '</td>
                                <td data-title="Kiracı Adı"><input class="input-select" type="text" name="kiraciUserName" value="' . ($kiraciBilgisi ? $kiraciBilgisi['userName'] : '') . '" /></td>
                                <td data-title="Kat Maliki Adı"><input class="input-select" type="text" name="katMalikiUserName" value="' . ($katMalikiBilgisi ? $katMalikiBilgisi['userName'] : '') . '" /></td>
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
    <script type="text/javascript">
    // Sayfa yüklendiğinde mevcut input değerlerini bir diziye kaydetme
    var initialData = [];

    window.onload = function() {
        var kiraciUserNameInputs = document.getElementsByName('kiraciUserName');
        var katMalikiUserNameInputs = document.getElementsByName('katMalikiUserName');
        var blok = document.getElementsByName('blok');
        var daire = document.getElementsByName('daire');

        for (var i = 0; i < kiraciUserNameInputs.length; i++) {
            if (kiraciUserNameInputs[i].value.trim() !== "") {
                initialData.push({
                    userName: kiraciUserNameInputs[i].value,
                    durum: "kiracı",
                    blok: blok[i].innerText,
                    daire: daire[i].innerText
                });
            }
        }

        for (var i = 0; i < katMalikiUserNameInputs.length; i++) {
            if (katMalikiUserNameInputs[i].value.trim() !== "") {
                initialData.push({
                    userName: katMalikiUserNameInputs[i].value,
                    durum: "kat Maliki",
                    blok: blok[i].innerText,
                    daire: daire[i].innerText
                });
            }
        }
    };

    // Save buttona basıldığında verileri karşılaştırma ve sunucuya gönderme
    saveButton.addEventListener('click', function() {
        var kiraciUserNameInputs = document.getElementsByName('kiraciUserName');
        var katMalikiUserNameInputs = document.getElementsByName('katMalikiUserName');
        var blok = document.getElementsByName('blok');
        var daire = document.getElementsByName('daire');
        var apartman_id = $('input[name="apartman_id"]').val();

        var newEntries = [];

        // Yeni eklenen verileri bulma
        for (var i = 0; i < kiraciUserNameInputs.length; i++) {
            if (kiraciUserNameInputs[i].value.trim() !== "") {
                var entry = {
                    userName: kiraciUserNameInputs[i].value,
                    durum: "kiracı",
                    blok: blok[i].innerText,
                    daire: daire[i].innerText
                };
                newEntries.push(entry);
            }
        }

        for (var i = 0; i < katMalikiUserNameInputs.length; i++) {
            if (katMalikiUserNameInputs[i].value.trim() !== "") {
                var entry = {
                    userName: katMalikiUserNameInputs[i].value,
                    durum: "kat Maliki",
                    blok: blok[i].innerText,
                    daire: daire[i].innerText
                };
                newEntries.push(entry);
            }
        }

        // Karşılaştırma
        var toSend = newEntries.filter(function(entry) {
            return !initialData.some(function(initialEntry) {
                return initialEntry.userName === entry.userName &&
                    initialEntry.durum === entry.durum &&
                    initialEntry.blok === entry.blok &&
                    initialEntry.daire === entry.daire;
            });
        });
        
        console.log("ToSend:", toSend);
        $.ajax({
            url: 'Controller/demo2.php',
            type: 'POST',
            data: {
                toSend: JSON.stringify(toSend),
                apartman_id: apartman_id
            },
            success: function(response) {
                alert(response);
                if (response == 1) {
                    $.ajax({
                        url: 'Controller/demo3.php',
                        type: 'POST',
                        data: {
                            toSend: JSON.stringify(toSend)
                        },
                        success: function(secondResponse) {
                            alert(secondResponse);
                            if (secondResponse == 1) {
                                location.reload();
                            }
                        },
                        error: function(secondError) {
                            console.error(secondError);
                        }
                    });
                }
            },
            error: function(error) {
                console.error(error);
            }
        });
    });
    </script>
</body>

</html>