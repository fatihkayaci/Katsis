<div class="cener-table">
    <div class="input-group-div">

        <div class="input-group1">
            <button type="button" class="btn-custom-outline bcoc1" id="saveButton">Kaydet</button>
            <button type="button" class="btn-custom-outline bcoc1">+</button>
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
                <th onclick="sortTable(7)">Bakiye Türü<i id="icon-table8" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(8)">Vadesi <i id="icon-table9" class="fa-solid fa-sort-down"></i></th>
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
            <tr data-userid="" class="git-ac toplu-td <?php echo $i ?>">
                <td data-title="Blok Adı" name="blok" class="br-r">
                    <?php
                                    if (!empty($row["blok_adi"]) && !empty($row["daire_sayisi"])) {
                                        echo $row["blok_adi"] . " / " . $row["daire_sayisi"];
                                    }
                                    ?>
                </td>
                <td data-title="Kat Maliki" name="katmaliki" class="p-0">
                    <div class="toplu-td-div">
                        <span class="border-1">Kat Maliki</span>
                        <span>Kiracı</span>
                    </div>
                </td>
                <td data-title="Ad Soyad" name="adsoyad" class="p-0">
                    <div class="toplu-td-div">
                        <span class="border-1">
                            <input type="text" class="input-select katMaliki"
                                value="<?php echo isset($katMalikiBilgisi['userName']) ? $katMalikiBilgisi['userName'] : ''; ?>"
                                <?php echo !empty($katMalikiBilgisi['userName']) ? 'readonly' : ''; ?> />
                        </span>
                        <span>
                            <input type="text" class="input-select kiracii"
                                value="<?php echo isset($kiraciBilgisi['userName']) ? $kiraciBilgisi['userName'] : ''; ?>"
                                <?php echo !empty($kiraciBilgisi['userName']) ? 'readonly' : ''; ?> />
                        </span>
                    </div>
                </td>
                <td data-title="T.C. Kat Maliki" name="tcKatMaliki" class="p-0">
                    <div class="toplu-td-div">
                        <span class="border-1">
                            <input type="text" class="input-select katMaliki"
                                value="<?php echo isset($katMalikiBilgisi['tc']) ? $katMalikiBilgisi['tc'] : ''; ?>"
                                <?php echo !empty($katMalikiBilgisi['userName']) ? 'readonly' : ''; ?> />
                        </span>
                        <span>
                            <input type="text" class="input-select kiracii"
                                value="<?php echo isset($kiraciBilgisi['tc']) ? $kiraciBilgisi['tc'] : ''; ?>"
                                <?php echo !empty($kiraciBilgisi['userName']) ? 'readonly' : ''; ?> />
                        </span>
                    </div>
                </td>
                <td data-title="Telefon" name="telefon" class="p-0">
                    <div class="toplu-td-div">
                        <span class="border-1">
                            <input type="text" class="input-select katMaliki"
                                value="<?php echo isset($katMalikiBilgisi['phoneNumber']) ? $katMalikiBilgisi['phoneNumber'] : ''; ?>"
                                <?php echo !empty($katMalikiBilgisi['userName']) ? 'readonly' : ''; ?> />
                        </span>
                        <span>
                            <input type="text" class="input-select kiracii"
                                value="<?php echo isset($kiraciBilgisi['phoneNumber']) ? $kiraciBilgisi['phoneNumber'] : ''; ?>"
                                <?php echo !empty($kiraciBilgisi['userName']) ? 'readonly' : ''; ?> />
                        </span>
                    </div>
                </td>
                <td data-title="E-Posta" name="eposta" class="p-0 br-end">
                    <div class="toplu-td-div">
                        <span class="border-1">
                            <input type="text" class="input-select katMaliki"
                                value="<?php echo isset($katMalikiBilgisi['userEmail']) ? $katMalikiBilgisi['userEmail'] : ''; ?>"
                                <?php echo !empty($katMalikiBilgisi['userName']) ? 'readonly' : ''; ?> />
                        </span>
                        <span>
                            <input type="text" class="input-select kiracii"
                                value="<?php echo isset($kiraciBilgisi['userEmail']) ? $kiraciBilgisi['userEmail'] : ''; ?>"
                                <?php echo !empty($kiraciBilgisi['userName']) ? 'readonly' : ''; ?> />
                        </span>
                    </div>
                </td>
                <td data-title="openingBalance" name="openingBalance" class="p-0 br-end">
                    <div class="toplu-td-div">
                        <span class="border-1">
                            <input type="text" class="input-select katMaliki"
                                value="<?php echo isset($katMalikiBilgisi['openingBalance']) ? $katMalikiBilgisi['openingBalance'] : ''; ?>"
                                <?php echo !empty($katMalikiBilgisi['userName']) ? 'readonly' : ''; ?> />
                        </span>
                        <span>
                            <input type="text" class="input-select kiracii"
                                value="<?php echo isset($kiraciBilgisi['openingBalance']) ? $kiraciBilgisi['openingBalance'] : ''; ?>"
                                <?php echo !empty($kiraciBilgisi['userName']) ? 'readonly' : ''; ?> />
                        </span>
                    </div>
                </td>
                <td data-title="balanceType" name="balanceType" class="p-0 br-end">
                    <div class="toplu-td-div">
                        <span class="border-1">
                            <input type="text" class="input-select katMaliki"
                                value="<?php echo isset($katMalikiBilgisi['balanceType']) ? $katMalikiBilgisi['balanceType'] : ''; ?>"
                                <?php echo !empty($katMalikiBilgisi['userName']) ? 'readonly' : ''; ?> />
                        </span>
                        <span>
                            <input type="text" class="input-select kiracii"
                                value="<?php echo isset($kiraciBilgisi['balanceType']) ? $kiraciBilgisi['balanceType'] : ''; ?>"
                                <?php echo !empty($kiraciBilgisi['userName']) ? 'readonly' : ''; ?> />
                        </span>
                    </div>
                </td>
                <td data-title="promise" name="promise" class="p-0 br-end">
                    <div class="toplu-td-div">
                        <span class="border-1">
                            <input type="text" class="input-select katMaliki"
                                value="<?php echo isset($katMalikiBilgisi['promise']) ? $katMalikiBilgisi['promise'] : ''; ?>"
                                <?php echo !empty($katMalikiBilgisi['userName']) ? 'readonly' : ''; ?> />
                        </span>
                        <span>
                            <input type="text" class="input-select kiracii"
                                value="<?php echo isset($kiraciBilgisi['promise']) ? $kiraciBilgisi['promise'] : ''; ?>"
                                <?php echo !empty($kiraciBilgisi['userName']) ? 'readonly' : ''; ?> />
                        </span>
                    </div>
                </td>
            </tr>
            <?php
                            ?>
            <?php
                        } else {
                            // Kullanıcı bilgileri bulunamadıysa, hata mesajı veya başka bir işlem
                            ?>
            <tr data-userid="" class="git-ac toplu-td <?php echo $i ?>">
                <td data-title="Blok Adı" name="blok" class="br-r">
                    <?php
                                    if (!empty($row["blok_adi"]) && !empty($row["daire_sayisi"])) {
                                        echo $row["blok_adi"] . " / " . $row["daire_sayisi"];
                                    }
                                    ?>
                </td>
                <td data-title="Kat Maliki" name="katmaliki" class="p-0">
                    <div class="toplu-td-div">
                        <span class="border-1">Kat Maliki</span>
                        <span>Kiracı</span>
                    </div>
                </td>
                <td data-title="Ad Soyad" name="adsoyad" class="p-0">
                    <div class="toplu-td-div">
                        <span class="border-1">
                            <input type="text" class="input-select katMaliki"
                                value="<?php echo isset($katMalikiBilgisi['userName']) ? $katMalikiBilgisi['userName'] : ''; ?>" />
                        </span>
                        <span>
                            <input type="text" class="input-select kiracii"
                                value="<?php echo isset($kiraciBilgisi['userName']) ? $kiraciBilgisi['userName'] : ''; ?>" />
                        </span>
                    </div>
                </td>
                <td data-title="T.C. Kat Maliki" name="tcKatMaliki" class="p-0">
                    <div class="toplu-td-div">
                        <span class="border-1">
                            <input type="text" class="input-select katMaliki"
                                value="<?php echo isset($katMalikiBilgisi['tc']) ? $katMalikiBilgisi['tc'] : ''; ?>" />
                        </span>
                        <span>
                            <input type="text" class="input-select kiracii"
                                value="<?php echo isset($kiraciBilgisi['tc']) ? $kiraciBilgisi['tc'] : ''; ?>" />
                        </span>
                    </div>
                </td>
                <td data-title="Telefon" name="telefon" class="p-0">
                    <div class="toplu-td-div">
                        <span class="border-1">
                            <input type="text" class="input-select katMaliki"
                                value="<?php echo isset($katMalikiBilgisi['phoneNumber']) ? $katMalikiBilgisi['phoneNumber'] : ''; ?>" />
                        </span>
                        <span>
                            <input type="text" class="input-select kiracii"
                                value="<?php echo isset($kiraciBilgisi['phoneNumber']) ? $kiraciBilgisi['phoneNumber'] : ''; ?>" />
                        </span>
                    </div>
                </td>
                <td data-title="E-Posta" name="eposta" class="p-0 br-end">
                    <div class="toplu-td-div">
                        <span class="border-1">
                            <input type="text" class="input-select katMaliki"
                                value="<?php echo isset($katMalikiBilgisi['userEmail']) ? $katMalikiBilgisi['userEmail'] : ''; ?>" />
                        </span>
                        <span>
                            <input type="text" class="input-select kiracii"
                                value="<?php echo isset($kiraciBilgisi['userEmail']) ? $kiraciBilgisi['userEmail'] : ''; ?>" />
                        </span>
                    </div>
                </td>
                <td data-title="openingBalance" name="openingBalance" class="p-0 br-end">
                    <div class="toplu-td-div">
                        <span class="border-1">
                            <input type="text" class="input-select katMaliki" value="<?php echo isset($katMalikiBilgisi['openingBalance']) 
                                                ? $katMalikiBilgisi['openingBalance'] : ''; ?>" />
                        </span>
                        <span>
                            <input type="text" class="input-select kiracii" value="<?php echo isset($kiraciBilgisi['openingBalance']) 
                                                ? $kiraciBilgisi['openingBalance'] : ''; ?>" />
                        </span>
                    </div>
                </td>
                <td data-title="balanceType" name="balanceType" class="p-0 br-end">
                    <div class="toplu-td-div">
                        <span class="border-1">
                            <input type="text" class="input-select katMaliki"
                                value="<?php echo isset($katMalikiBilgisi['balanceType']) ? $katMalikiBilgisi['balanceType'] : ''; ?>" />
                        </span>
                        <span>
                            <input type="text" class="input-select kiracii"
                                value="<?php echo isset($kiraciBilgisi['balanceType']) ? $kiraciBilgisi['balanceType'] : ''; ?>" />
                        </span>
                    </div>
                </td>
                <td data-title="promise" name="promise" class="p-0 br-end">
                    <div class="toplu-td-div">
                        <span class="border-1">
                            <input type="text" class="input-select katMaliki"
                                value="<?php echo isset($katMalikiBilgisi['promise']) ? $katMalikiBilgisi['promise'] : ''; ?>" />
                        </span>
                        <span>
                            <input type="text" class="input-select kiracii"
                                value="<?php echo isset($kiraciBilgisi['promise']) ? $kiraciBilgisi['promise'] : ''; ?>" />
                        </span>
                    </div>
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
                    var katMalikiTCInput = row.querySelector('[name="tcKatMaliki"] .katMaliki');
                    var katMalikiPhoneInput = row.querySelector('[name="telefon"] .katMaliki');
                    var katMalikiEmailInput = row.querySelector('[name="eposta"] .katMaliki');
                    var katMalikiOpeningBalanceInput = row.querySelector(
                        '[name="openingBalance"] .katMaliki');
                    var katMalikiBalanceTypeInput = row.querySelector('[name="balanceType"] .katMaliki');
                    var katMalikiPromiseInput = row.querySelector('[name="promise"] .katMaliki');

                    var kiraciUserNameInput = row.querySelector('.kiracii');
                    var kiraciTCInput = row.querySelector('[name="tcKatMaliki"] .kiracii');
                    var kiraciPhoneInput = row.querySelector('[name="telefon"] .kiracii');
                    var kiraciEmailInput = row.querySelector('[name="eposta"] .kiracii');
                    var kiraciOpeningBalanceInput = row.querySelector('[name="openingBalance"] .kiracii');
                    var kiraciBalanceTypeInput = row.querySelector('[name="balanceType"] .kiracii');
                    var kiraciPromiseInput = row.querySelector('[name="promise"] .kiracii');

                    var blokAdiText = blokAdi.innerText.trim();
                    var katMalikiUserName = katMalikiUserNameInput.value.trim();
                    var katMalikiTC = katMalikiTCInput.value.trim();
                    var katMalikiPhone = katMalikiPhoneInput.value.trim();
                    var katMalikiEmail = katMalikiEmailInput.value.trim();
                    var katMalikiOpeningBalance = katMalikiOpeningBalanceInput.value.trim(); // Düzeltildi
                    var katMalikiBalanceType = katMalikiBalanceTypeInput.value.trim();
                    var katMalikiPromise = katMalikiPromiseInput.value.trim();

                    var kiraciUserName = kiraciUserNameInput.value.trim();
                    var kiraciTC = kiraciTCInput.value.trim();
                    var kiraciPhone = kiraciPhoneInput.value.trim();
                    var kiraciEmail = kiraciEmailInput.value.trim();
                    var kiraciOpeningBalance = kiraciOpeningBalanceInput.value.trim(); // Düzeltildi
                    var kiraciBalanceType = kiraciBalanceTypeInput.value.trim();
                    var kiraciPromise = kiraciPromiseInput.value.trim();

                    if (katMalikiUserName !== "") {
                        initialData.push({
                            userName: katMalikiUserName,
                            durum: "kat Maliki",
                            blok: blokAdiText,
                            tc: katMalikiTC,
                            telefon: katMalikiPhone,
                            eposta: katMalikiEmail,
                            openingBalance: katMalikiOpeningBalance, // Düzeltildi
                            balanceType: katMalikiBalanceType,
                            promise: katMalikiPromise
                        });
                    }

                    if (kiraciUserName !== "") {
                        initialData.push({
                            userName: kiraciUserName,
                            durum: "kiracı",
                            blok: blokAdiText,
                            tc: kiraciTC,
                            telefon: kiraciPhone,
                            eposta: kiraciEmail,
                            openingBalance: kiraciOpeningBalance, // Düzeltildi
                            balanceType: kiraciBalanceType,
                            promise: kiraciPromise
                        });
                    }
                    
                    // console.log("initialData = ", JSON.stringify(initialData, null, 2));

                });
                // Kaydet butonuna tıklandığında yeni girdileri işle
                saveButton.addEventListener('click', function() {
                    
                    var newEntries = [];

                    var rows = document.querySelectorAll('.git-ac.toplu-td');
                    rows.forEach(function(row) {
                        var blokAdi = row.querySelector('[data-title="Blok Adı"]');
                        var katMalikiUserNameInput = row.querySelector('.katMaliki');
                        var katMalikiTCInput = row.querySelector('[name="tcKatMaliki"] .katMaliki');
                        var katMalikiPhoneInput = row.querySelector('[name="telefon"] .katMaliki');
                        var katMalikiEmailInput = row.querySelector('[name="eposta"] .katMaliki');
                        var katMalikiOpeningBalanceInput = row.querySelector('[name="openingBalance"] .katMaliki');
                        var katMalikiBalanceTypeInput = row.querySelector('[name="balanceType"] .katMaliki');
                        var katMalikiPromiseInput = row.querySelector('[name="promise"] .katMaliki');
                        var kiraciUserNameInput = row.querySelector('.kiracii');
                        var kiraciTCInput = row.querySelector('[name="tcKatMaliki"] .kiracii');
                        var kiraciPhoneInput = row.querySelector('[name="telefon"] .kiracii');
                        var kiraciEmailInput = row.querySelector('[name="eposta"] .kiracii');
                        var kiraciOpeningBalanceInput = row.querySelector('[name="openingBalance"] .kiracii');
                        var kiraciBalanceTypeInput = row.querySelector('[name="balanceType"] .kiracii');
                        var kiraciPromiseInput = row.querySelector('[name="promise"] .kiracii');

                        var blokAdiText = blokAdi.innerText.trim();
                        var katMalikiUserName = katMalikiUserNameInput.value.trim();
                        
                        var katMalikiTC = katMalikiTCInput.value.trim();
                        var katMalikiPhone = katMalikiPhoneInput.value.trim();
                        var katMalikiEmail = katMalikiEmailInput.value.trim();
                        var katMalikiOpeningBalance = katMalikiOpeningBalanceInput.value.trim();
                        var katMalikiBalanceType = katMalikiBalanceTypeInput.value.trim();
                        var katMalikiPromise = katMalikiPromiseInput.value.trim();
                        var kiraciUserName = kiraciUserNameInput.value.trim();
                        var kiraciTC = kiraciTCInput.value.trim();
                        var kiraciPhone = kiraciPhoneInput.value.trim();
                        var kiraciEmail = kiraciEmailInput.value.trim();
                        var kiraciOpeningBalance = kiraciOpeningBalanceInput.value.trim();
                        var kiraciBalanceType = kiraciBalanceTypeInput.value.trim();
                        var kiraciPromise = kiraciPromiseInput.value.trim();

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
                                eposta: katMalikiEmail,
                                openingBalance: katMalikiOpeningBalance, // Düzeltildi
                                balanceType: katMalikiBalanceType,
                                promise: katMalikiPromise
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
                                eposta: kiraciEmail,
                                openingBalance: kiraciOpeningBalance, // Düzeltildi
                                balanceType: kiraciBalanceType,
                                promise: kiraciPromise
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

                    // E-posta adresalerinden en az biri boşsa, hasDuplicateEmail'i false yap
                    if (emailList.some(function(email) {
                            return email === "";
                        })) {
                        hasDuplicateEmail = false;
                    }

                    if (!hasDuplicateEmail) {
                        $.ajax({
                            url: 'Controller/bulkAddingUser.php',
                            type: 'POST',
                            data: {
                                newEntries: JSON.stringify(newEntries)
                            },
                            success: function(response) {
                                console.log("response = "+response);
                                if (response == "success") {
                                    $.ajax({
                                        url: 'Controller/demo3.php',
                                        type: 'POST',
                                        data: {},
                                        success: function(secondResponse) {
                                            if (secondResponse == "success") {
                                                // location.reload();
                                                console.log("başardı");
                                            } else {
                                                alert(secondResponse);
                                            }

                                        },
                                        error: function(error) {
                                            console.error(error);
                                        }
                                    });
                                } else {
                                    alert(response);
                                }
                            },
                            error: function(error) {
                                console.error(error);
                            }
                        });
                    } else {
                        alert("Epostası aynı olanlar var lütfen düzeltiniz");
                    }
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