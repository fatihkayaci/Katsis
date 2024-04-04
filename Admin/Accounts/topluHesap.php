<div class="cener-table">
    <div class="input-group-div">

        <div class="input-group1">
            <button type="button" class="btn-custom-outline bcoc1" id="saveButton">Kaydet</button>
        </div>
        <div class="input-group1">
            <div class="search-box">
                <i class="fas fa-search search-icon" aria-hidden="true"></i>
                <input type="text" class="search-input" placeholder="Arama...">
            </div>
        </div>

    </div>

    <input class="input" type="text" name="apartman_id" value=<?php echo $_SESSION["apartID"]; ?> hidden>

    <?php

    $idapartman = $_SESSION["apartID"];

    try {



        $sql = "SELECT d.*, b.blok_adi
        FROM tbl_daireler d
        LEFT JOIN tbl_blok b ON d.blok_adi = b.blok_id
        WHERE d.apartman_id = " . $_SESSION["apartID"];

        /* $sql = "SELECT blok_adi, daire_sayisi, kiraciID, katMalikiID
                FROM tbl_daireler
                WHERE apartman_id=" . $_SESSION["apartID"];
                */

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Sonuç kümesinin satır sayısını kontrol etme
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            ?>
    <table id="table" class="users-table">
        <thead>
            <tr class="users-table-info toplu-th">
                <th onclick="sortTable(0)">Blok / Daire <i id="icon-table1" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(1)">Tip <i id="icon-table2" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(2)">Adı Soyadı <i id="icon-table3" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(3)">T.C. No <i id="icon-table4" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(4)">Telefon <i id="icon-table5" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(5)">E-Posta <i id="icon-table6" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(6)">Açılış Bakiyesi <i id="icon-table7" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(7)">Vadesi <i id="icon-table8" class="fa-solid fa-sort-down"></i></th>
            </tr>
        </thead>
        <tbody>

            <?php
                    $i = 1;
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
                            ?>
            <tr data-userid="" class="git-ac toplu-td <?php echo $i?>">
                <td data-title="Blok Adı" name="blok">
                    <?php
                                    if (!empty($row["blok_adi"]) && !empty($row["daire_sayisi"])) {
                                        echo $row["blok_adi"] . " / " . $row["daire_sayisi"];
                                    }
                                    ?>
                </td>
                <td data-title="Kat Maliki" name="katmaliki">Kat Maliki <br><br> Kiracı</td>
                <td data-title="Ad Soyad" name="adsoyad">
                    <input type="text" class="input-select katMaliki"
                        <?php if (!empty($katMalikiBilgisi['userName'])): ?>
                        value="<?php echo $katMalikiBilgisi['userName']; ?>" readonly <?php endif; ?> />
                    <br><br>
                    <input type="text" class="input-select kiracii" <?php if (!empty($kiraciBilgisi['userName'])): ?>
                        value="<?php echo $kiraciBilgisi['userName']; ?>" readonly <?php endif; ?> />
                </td>
                <td data-title="T.C. Kat Maliki" name="tcKatMaliki">
                    <input type="text" class="input-select katMaliki" <?php if (!empty($katMalikiBilgisi['tc'])): ?>
                        value="<?php echo $katMalikiBilgisi['tc']; ?>" readonly <?php endif; ?> />
                    <br><br>
                    <input type="text" class="input-select kiracii" <?php if (!empty($kiraciBilgisi['tc'])): ?>
                        value="<?php echo $kiraciBilgisi['tc']; ?>" readonly <?php endif; ?> />
                </td>
                <td data-title="Telefon" name="telefon">
                    <input type="text" class="input-select katMaliki"
                        <?php if (!empty($katMalikiBilgisi['phoneNumber'])): ?>
                        value="<?php echo $katMalikiBilgisi['phoneNumber']; ?>" readonly <?php endif; ?> />
                    <br><br>
                    <input type="text" class="input-select kiracii" <?php if (!empty($kiraciBilgisi['phoneNumber'])): ?>
                        value="<?php echo $kiraciBilgisi['phoneNumber']; ?>" readonly <?php endif; ?> />
                </td>
                <td data-title="E-Posta" name="eposta">
                    <input type="text" class="input-select katMaliki"
                        <?php if (!empty($katMalikiBilgisi['userEmail'])): ?>
                        value="<?php echo $katMalikiBilgisi['userEmail']; ?>" readonly <?php endif; ?> />
                    <br><br>
                    <input type="text" class="input-select kiracii" <?php if (!empty($kiraciBilgisi['userEmail'])): ?>
                        value="<?php echo $kiraciBilgisi['userEmail']; ?>" readonly <?php endif; ?> />
                </td>
            </tr>
            <?php
                        } else {
                            // Kullanıcı bilgileri bulunamadıysa, hata mesajı veya başka bir işlem
                            ?>
            <tr data-userid="" class="git-ac toplu-td">
                <td data-title="Blok Adı" name="blok">
                    <?php
                                    if (!empty($row["blok_adi"]) && !empty($row["daire_sayisi"])) {
                                        echo $row["blok_adi"] . " / " . $row["daire_sayisi"];
                                    }
                                    ?>
                </td>
                <td data-title="Kat Maliki" name="katmaliki">Kat Maliki <br><br> Kiracı</td>
                <td data-title="Ad Soyad" name="adsoyad">
                    <input type="text" class="input-select katMaliki"
                        <?php if (!empty($katMalikiBilgisi['userName'])): ?>
                        value="<?php echo $katMalikiBilgisi['userName']; ?>" readonly <?php endif; ?> />
                    <br><br>
                    <input type="text" class="input-select kiracii" <?php if (!empty($kiraciBilgisi['userName'])): ?>
                        value="<?php echo $kiraciBilgisi['userName']; ?>" readonly <?php endif; ?> />
                </td>
                <td data-title="T.C. Kat Maliki" name="tcKatMaliki">
                    <input type="text" class="input-select katMaliki" <?php if (!empty($katMalikiBilgisi['tc'])): ?>
                        value="<?php echo $katMalikiBilgisi['tc']; ?>" readonly <?php endif; ?> />
                    <br><br>
                    <input type="text" class="input-select kiracii" <?php if (!empty($kiraciBilgisi['tc'])): ?>
                        value="<?php echo $kiraciBilgisi['tc']; ?>" readonly <?php endif; ?> />
                </td>
                <td data-title="Telefon" name="telefon">
                    <input type="text" class="input-select katMaliki"
                        <?php if (!empty($katMalikiBilgisi['phoneNumber'])): ?>
                        value="<?php echo $katMalikiBilgisi['phoneNumber']; ?>" readonly <?php endif; ?> />
                    <br><br>
                    <input type="text" class="input-select kiracii" <?php if (!empty($kiraciBilgisi['phoneNumber'])): ?>
                        value="<?php echo $kiraciBilgisi['phoneNumber']; ?>" readonly <?php endif; ?> />
                </td>
                <td data-title="E-Posta" name="eposta">
                    <input type="text" class="input-select katMaliki"
                        <?php if (!empty($katMalikiBilgisi['userEmail'])): ?>
                        value="<?php echo $katMalikiBilgisi['userEmail']; ?>" readonly <?php endif; ?> />
                    <br><br>
                    <input type="text" class="input-select kiracii" <?php if (!empty($kiraciBilgisi['userEmail'])): ?>
                        value="<?php echo $kiraciBilgisi['userEmail']; ?>" readonly <?php endif; ?> />
                </td>
            </tr>
            <?php
                        }
                        $i++;
                    }

                    echo '</tbody>
                </table>
            </div>';
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
                var rows = document.querySelectorAll('.git-ac.toplu-td');

                rows.forEach(function(row) {
                    var blokAdi = row.querySelector('[data-title="Blok Adı"]');
                    var katMalikiUserNameInput = row.querySelector('.katMaliki');
                    var kiraciUserNameInput = row.querySelector('.kiracii');
                    var katMalikiTCInput = row.querySelector('[name="tcKatMaliki"] .katMaliki');
                    var kiraciTCInput = row.querySelector('[name="tcKatMaliki"] .kiracii');
                    var katMalikiPhoneInput = row.querySelector('[name="telefon"] .katMaliki');
                    var kiraciPhoneInput = row.querySelector('[name="telefon"] .kiracii');
                    var katMalikiEmailInput = row.querySelector('[name="eposta"] .katMaliki');
                    var kiraciEmailInput = row.querySelector('[name="eposta"] .kiracii');

                    var blokAdiText = blokAdi.innerText.trim();
                    var katMalikiUserName = katMalikiUserNameInput.value.trim();
                    var kiraciUserName = kiraciUserNameInput.value.trim();
                    var katMalikiTC = katMalikiTCInput.value.trim();
                    var kiraciTC = kiraciTCInput.value.trim();
                    var katMalikiPhone = katMalikiPhoneInput.value.trim();
                    var kiraciPhone = kiraciPhoneInput.value.trim();
                    var katMalikiEmail = katMalikiEmailInput.value.trim();
                    var kiraciEmail = kiraciEmailInput.value.trim();

                    if (katMalikiUserName !== "") {
                        initialData.push({
                            userName: katMalikiUserName,
                            durum: "kat Maliki",
                            blok: blokAdiText,
                            tc: katMalikiTC,
                            telefon: katMalikiPhone,
                            eposta: katMalikiEmail
                        });
                    }

                    if (kiraciUserName !== "") {
                        initialData.push({
                            userName: kiraciUserName,
                            durum: "kiracı",
                            blok: blokAdiText,
                            tc: kiraciTC,
                            telefon: kiraciPhone,
                            eposta: kiraciEmail
                        });
                    }
                });
                // Kaydet butonuna tıklandığında yeni girdileri işle
                saveButton.addEventListener('click', function() {
                    var newEntries = [];

                    var rows = document.querySelectorAll('.git-ac.toplu-td');
                    rows.forEach(function(row) {
                        var blokAdi = row.querySelector('[data-title="Blok Adı"]');
                        var katMalikiUserNameInput = row.querySelector('.katMaliki');
                        var kiraciUserNameInput = row.querySelector('.kiracii');
                        var katMalikiTCInput = row.querySelector('[name="tcKatMaliki"] .katMaliki');
                        var kiraciTCInput = row.querySelector('[name="tcKatMaliki"] .kiracii');
                        var katMalikiPhoneInput = row.querySelector('[name="telefon"] .katMaliki');
                        var kiraciPhoneInput = row.querySelector('[name="telefon"] .kiracii');
                        var katMalikiEmailInput = row.querySelector('[name="eposta"] .katMaliki');
                        var kiraciEmailInput = row.querySelector('[name="eposta"] .kiracii');

                        var blokAdiText = blokAdi.innerText.trim();
                        var katMalikiUserName = katMalikiUserNameInput.value.trim();
                        var kiraciUserName = kiraciUserNameInput.value.trim();
                        var katMalikiTC = katMalikiTCInput.value.trim();
                        var kiraciTC = kiraciTCInput.value.trim();
                        var katMalikiPhone = katMalikiPhoneInput.value.trim();
                        var kiraciPhone = kiraciPhoneInput.value.trim();
                        var katMalikiEmail = katMalikiEmailInput.value.trim();
                        var kiraciEmail = kiraciEmailInput.value.trim();

                        // Sadece yeni girdileri kontrol et
                        if (katMalikiUserName !== "" && !initialData.some(function(item) {
                                return item.userName === katMalikiUserName && item.durum ===
                                    "kat Maliki" && item.blok === blokAdiText;
                            })) {
                            newEntries.push({
                                userName: katMalikiUserName,
                                durum: "kat Maliki",
                                blok: blokAdiText,
                                tc: katMalikiTC,
                                telefon: katMalikiPhone,
                                eposta: katMalikiEmail
                            });
                        }

                        if (kiraciUserName !== "" && !initialData.some(function(item) {
                                return item.userName === kiraciUserName && item.durum ===
                                    "kiracı" && item.blok === blokAdiText;
                            })) {
                            newEntries.push({
                                userName: kiraciUserName,
                                durum: "kiracı",
                                blok: blokAdiText,
                                tc: kiraciTC,
                                telefon: kiraciPhone,
                                eposta: kiraciEmail
                            });
                        }
                    });

                    console.log(newEntries);

                    // E-posta kontrolü yap
                    var hasDuplicateEmail = false;
                    var emailList = newEntries.map(function(entry) {
                        return entry.eposta;
                    });

                    // E-posta listesindeki her bir adresi kontrol et
                    emailList.forEach(function(email, index) {
                        if (emailList.indexOf(email) !== index) {
                            hasDuplicateEmail = true;
                        }
                    });
                        $.ajax({
                            url: 'Controller/bulkAddingUser.php',
                            type: 'POST',
                            data: {
                                newEntries: JSON.stringify(newEntries)
                            },
                            success: function(response) {
                                alert(response);
                                if (response == "success") {
                                    
                                    $.ajax({
                                        url: 'Controller/demo3.php',
                                        type: 'POST',
                                        data: {},
                                        success: function(secondResponse) {
                                            if(secondResponse == "success"){
                                                location.reload();
                                            }else{
                                                alert(secondResponse);
                                            }
                                            
                                        },
                                        error: function(error) {
                                            console.error(error);
                                        }
                                    });
                                }else{
                                    alert(response);
                                }
                            },
                            error: function(error) {
                                console.error(error);
                            }
                        });
                });
            };
            </script>

            <script>
            function sortTable(n) {
                var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
                table = document.getElementById("table");
                switching = true;
                dir = "asc";
                while (switching) {
                    switching = false;
                    rows = table.rows;
                    for (i = 1; i < (rows.length - 1); i++) {
                        shouldSwitch = false;
                        x = rows[i].getElementsByTagName("TD")[n];
                        y = rows[i + 1].getElementsByTagName("TD")[n];

                        for (var j = 1; j < 8; j++) {
                            if (n != j) {
                                $('#icon-table' + j).removeClass("rotate");
                                $('#icon-table' + j).removeClass("opacity");
                            }
                        }

                        if (dir == "asc") {
                            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                                shouldSwitch = true;
                                $('#icon-table' + n).removeClass("rotate");
                                $('#icon-table' + n).addClass("opacity");
                                break;
                            }
                        } else if (dir == "desc") {
                            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                                shouldSwitch = true;
                                $('#icon-table' + n).addClass("rotate");
                                $('#icon-table' + n).addClass("opacity");
                                break;
                            }
                        }
                    }
                    if (shouldSwitch) {
                        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                        switching = true;
                        switchcount++;
                    } else {
                        if (switchcount == 0 && dir == "asc") {
                            dir = "desc";
                            switching = true;
                        }
                    }
                }
                // Döngü tamamlandığında 'i' değeri burada kapanır
            }
            </script>


            <script type="text/javascript">
            // Sayfa yüklendiğinde mevcut input değerlerini bir diziye kaydetme
            // var initialData = [];

            // window.onload = function () {
            //     var kiraciUserNameInputs = document.getElementsByName('kiraciUserName');
            //     var katMalikiUserNameInputs = document.getElementsByName('katMalikiUserName');
            //     var blok = document.getElementsByName('blok');
            //     var daire = document.getElementsByName('daire');

            //     for (var i = 0; i < kiraciUserNameInputs.length; i++) {
            //         if (kiraciUserNameInputs[i].value.trim() !== "") {
            //             initialData.push({
            //                 userName: kiraciUserNameInputs[i].value,
            //                 durum: "kiracı",
            //                 blok: blok[i].innerText,
            //                 daire: daire[i].innerText
            //             });
            //         }
            //     }

            //     for (var i = 0; i < katMalikiUserNameInputs.length; i++) {
            //         if (katMalikiUserNameInputs[i].value.trim() !== "") {
            //             initialData.push({
            //                 userName: katMalikiUserNameInputs[i].value,
            //                 durum: "kat Maliki",
            //                 blok: blok[i].innerText,
            //                 daire: daire[i].innerText
            //             });
            //         }
            //     }
            // };
            // console.log(initialData);
            // Save buttona basıldığında verileri karşılaştırma ve sunucuya gönderme
            </script>
            </body>

            </html>