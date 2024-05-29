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
        // SQL sorgusu
        $sql = "SELECT d.*, b.blok_adi, u1.userName AS katMalikiName, u1.tc AS katMalikiTC, u1.phoneNumber AS katMalikiPhoneNumber, 
                u1.userEmail AS katMalikiEmail, u1.plate AS katMalikiPlate, u1.gender AS katMalikiGender, u1.openingBalance AS katMalikiOpeningBalance, u1.balanceType AS katMalikiBalanceType, 
                u1.promise AS katMalikiPromise, u2.userName AS kiraciName, u2.tc AS kiraciTC, u2.phoneNumber AS kiraciPhoneNumber, 
                u2.userEmail AS kiraciEmail, u2.plate AS kiraciPlate, u2.gender AS kiraciGender, u2.openingBalance AS kiraciOpeningBalance, u2.balanceType AS kiraciBalanceType, 
                u2.promise AS kiraciPromise
                FROM tbl_daireler d
                LEFT JOIN tbl_blok b ON d.blok_adi = b.blok_id
                LEFT JOIN tbl_users u1 ON d.katMalikiID = u1.userID
                LEFT JOIN tbl_users u2 ON d.kiraciID = u2.userID
                WHERE d.apartman_id = :apartmanID";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':apartmanID', $_SESSION["apartID"]);
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
                <th onclick="sortTable(6)">Araç Plakası<i id="icon-table7" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(7)">Cinsiyet<i id="icon-table8" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(8)">Açılış Bakiyesi <i id="icon-table9" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(9)">Bakiye Türü<i id="icon-table10" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(10)">Vadesi <i id="icon-table11" class="fa-solid fa-sort-down"></i></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($result as $row) {
                ?>
            <tr data-userid="" class="git-ac toplu-td <?php echo $i ?>">
                <td data-title="Blok Adı" name="blok" class="br-r">
                    <?php echo !empty($row["blok_adi"]) && !empty($row["daire_sayisi"]) ? $row["blok_adi"] . " / " . $row["daire_sayisi"] : ""; ?>
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
                                value="<?php echo $row["katMalikiName"] ?? ''; ?>"
                                <?php echo isset($row["katMalikiName"]) ? 'readonly' : ''; ?> />
                        </span>
                        <span>
                            <input type="text" class="input-select kiracii"
                                value="<?php echo $row["kiraciName"] ?? ''; ?>"
                                <?php echo isset($row["kiraciName"]) ? 'readonly' : ''; ?> />
                        </span>
                    </div>
                </td>
                <td data-title="T.C. Kat Maliki" name="tcKatMaliki" class="p-0">
                    <div class="toplu-td-div">
                        <span class="border-1">
                            <input type="text" class="input-select katMaliki"  oninput="checkTCNumberLength(this)"
                                value="<?php echo $row["katMalikiTC"] ?? ''; ?>"
                                <?php echo isset($row["katMalikiName"]) ? 'readonly' : ''; ?> />
                        </span>
                        <span>
                            <input type="text" class="input-select kiracii"  oninput="checkTCNumberLength(this)"
                                value="<?php echo $row["kiraciTC"] ?? ''; ?>"
                                <?php echo isset($row["kiraciName"]) ? 'readonly' : ''; ?> />
                        </span>
                    </div>
                </td>
                <td data-title="Telefon" name="telefon" class="p-0">
                    <div class="toplu-td-div">
                        <span class="border-1">
                            <input type="text" class="input-select katMaliki" oninput="checkPhoneNumberLength(this)"
                                value="<?php echo $row["katMalikiPhoneNumber"] ?? ''; ?>"
                                <?php echo isset($row["katMalikiName"]) ? 'readonly' : ''; ?> />
                        </span>
                        <span>
                            <input type="text" class="input-select kiracii" oninput="checkPhoneNumberLength(this)"
                                value="<?php echo $row["kiraciPhoneNumber"] ?? ''; ?>"
                                <?php echo isset($row["kiraciName"]) ? 'readonly' : ''; ?> />
                        </span>
                    </div>
                </td>
                <td data-title="E-Posta" name="eposta" class="p-0 br-end">
                    <div class="toplu-td-div">
                        <span class="border-1">
                            <input type="text" class="input-select katMaliki"
                                value="<?php echo $row["katMalikiEmail"] ?? ''; ?>"
                                <?php echo isset($row["katMalikiName"]) ? 'readonly' : ''; ?> />
                        </span>
                        <span>
                            <input type="text" class="input-select kiracii"
                                value="<?php echo $row["kiraciEmail"] ?? ''; ?>"
                                <?php echo isset($row["kiraciName"]) ? 'readonly' : ''; ?> />
                        </span>
                    </div>
                </td>
                <td data-title="plate" name="plate" class="p-0 br-end">
                    <div class="toplu-td-div">
                        <span class="border-1">
                            <input type="text" class="input-select katMaliki" 
                                value="<?php echo $row["katMalikiPlate"] ?? ''; ?>"
                                <?php echo isset($row["katMalikiName"]) ? 'readonly' : ''; ?> />
                        </span>
                        <span>
                            <input type="text" class="input-select kiracii" 
                                value="<?php echo $row["kiraciPlate"] ?? ''; ?>"
                                <?php echo isset($row["kiraciName"]) ? 'readonly' : ''; ?> />
                        </span>
                    </div>
                </td>
                <td data-title="gender" name="gender" class="p-0 br-end">
                    <div class="toplu-td-div">
                        <span class="border-1">
                            <select class="input-select katMaliki"
                                <?php echo isset($row["katMalikiName"]) ? 'disabled' : ''; ?>>
                                <option value=""
                                    <?php if(isset($row["katMalikiGender"]) && $row["katMalikiGender"] === "") echo "selected"; ?>>
                                </option>
                                <option value="Erkek"
                                    <?php if(isset($row["katMalikiGender"]) && $row["katMalikiGender"] === "Erkek") echo "selected"; ?>>
                                    Erkek</option>
                                <option value="Kadın"
                                    <?php if(isset($row["katMalikiGender"]) && $row["katMalikiGender"] === "Kadın") echo "selected"; ?>>
                                    Kadın</option>
                            </select>
                        </span>
                        <span>
                            <select class="input-select kiracii"
                                <?php echo isset($row["kiraciName"]) ? 'disabled' : ''; ?>>
                                <option value=""
                                    <?php if(isset($row["kiraciGender"]) && $row["kiraciGender"] === "") echo "selected"; ?>>
                                </option>
                                <option value="Erkek"
                                    <?php if(isset($row["kiraciGender"]) && $row["kiraciGender"] === "Erkek") echo "selected"; ?>>
                                    Erkek</option>
                                <option value="Kadın"
                                    <?php if(isset($row["kiraciGender"]) && $row["kiraciGender"] === "Kadın") echo "selected"; ?>>
                                    Kadın</option>
                            </select>
                        </span>
                    </div>
                </td>
                <td data-title="openingBalance" name="openingBalance" class="p-0 br-end">
                    <div class="toplu-td-div">
                        <span class="border-1">
                            <input type="text" class="input-select katMaliki"
                                value="<?php echo $row["katMalikiOpeningBalance"] ?? ''; ?>"
                                <?php echo isset($row["katMalikiName"]) ? 'readonly' : ''; ?> />
                        </span>
                        <span>
                            <input type="text" class="input-select kiracii"
                                value="<?php echo $row["kiraciOpeningBalance"] ?? ''; ?>"
                                <?php echo isset($row["kiraciName"]) ? 'readonly' : ''; ?> />
                        </span>
                    </div>
                </td>
                <td data-title="balanceType" name="balanceType" class="p-0 br-end">
                    <div class="toplu-td-div">
                        <span class="border-1">
                            <select class="input-select katMaliki"
                                <?php echo isset($row["katMalikiName"]) ? 'disabled' : ''; ?>>
                                <option value=""
                                    <?php if(isset($row["katMalikiBalanceType"]) && $row["katMalikiBalanceType"] === "") echo "selected"; ?>>
                                </option>
                                <option value="TL"
                                    <?php if(isset($row["katMalikiBalanceType"]) && $row["katMalikiBalanceType"] === "TL") echo "selected"; ?>>
                                    TL</option>
                                <option value="Euro"
                                    <?php if(isset($row["katMalikiBalanceType"]) && $row["katMalikiBalanceType"] === "Euro") echo "selected"; ?>>
                                    Euro</option>
                                <option value="Dolar"
                                    <?php if(isset($row["katMalikiBalanceType"]) && $row["katMalikiBalanceType"] === "Dolar") echo "selected"; ?>>
                                    Dolar</option>
                            </select>
                        </span>
                        <span>
                            <select class="input-select kiracii"
                                <?php echo isset($row["kiraciName"]) ? 'disabled' : ''; ?>>
                                <option value=""
                                    <?php if(isset($row["kiraciBalanceType"]) && $row["kiraciBalanceType"] === "") echo "selected"; ?>>
                                </option>
                                <option value="TL"
                                    <?php if(isset($row["kiraciBalanceType"]) && $row["kiraciBalanceType"] === "TL") echo "selected"; ?>>
                                    TL</option>
                                <option value="Euro"
                                    <?php if(isset($row["kiraciBalanceType"]) && $row["kiraciBalanceType"] === "Euro") echo "selected"; ?>>
                                    Euro</option>
                                <option value="Dolar"
                                    <?php if(isset($row["kiraciBalanceType"]) && $row["kiraciBalanceType"] === "Dolar") echo "selected"; ?>>
                                    Dolar</option>
                            </select>
                        </span>
                    </div>
                </td>
                <td data-title="promise" name="promise" class="p-0 br-end">
                    <div class="toplu-td-div">
                        <span class="border-1">
                            <input type="Date" class="input-select katMaliki"
                                value="<?php echo $row["katMalikiPromise"] ?? ''; ?>"
                                <?php echo isset($row["katMalikiName"]) ? 'readonly' : ''; ?> />
                        </span>
                        <span>
                            <input type="Date" class="input-select kiracii"
                                value="<?php echo $row["kiraciPromise"] ?? ''; ?>"
                                <?php echo isset($row["kiraciName"]) ? 'readonly' : ''; ?> />
                        </span>
                    </div>
                </td>
            </tr>
            <?php
                ?>
            <?php
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
            <script>
            function checkTCNumberLength(input) {
    // Yalnızca sayı karakterlerine izin ver
    input.value = input.value.replace(/[^0-9]/g, '');
    
    // 11 karakter sınırı
    if (input.value.length > 11) {
        input.value = input.value.slice(0, 11);
    }
}

function checkPhoneNumberLength(input) {
    // Yalnızca sayı karakterlerine izin ver
    input.value = input.value.replace(/[^0-9]/g, '');
    
    // 10 karakter sınırı
    if (input.value.length > 10) {
        input.value = input.value.slice(0, 10);
    }
}

            </script>
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

                    if (katMalikiUserName !== "") {
                        initialData.push({
                            userName: katMalikiUserName,
                            durum: "katmaliki",
                            blok: blokAdiText,
                            tc: katMalikiTC,
                            telefon: katMalikiPhone,
                            eposta: katMalikiEmail,
                            openingBalance: katMalikiOpeningBalance,
                            balanceType: katMalikiBalanceType,
                            promise: katMalikiPromise
                        });
                    }

                    if (kiraciUserName !== "") {
                        initialData.push({
                            userName: kiraciUserName,
                            durum: "kiraci",
                            blok: blokAdiText,
                            tc: kiraciTC,
                            telefon: kiraciPhone,
                            eposta: kiraciEmail,
                            openingBalance: kiraciOpeningBalance,
                            balanceType: kiraciBalanceType,
                            promise: kiraciPromise
                        });
                    }

                    // console.log("initialData = ", JSON.stringify(initialData, null, 2));
                });
            };

            // Kaydet butonuna tıklandığında yeni girdileri işle
            document.getElementById('saveButton').addEventListener('click', function() {
                var rows = document.querySelectorAll('.git-ac.toplu-td');
                var newEntries = [];
                var hasError = false;

                rows.forEach(function(row) {
                    var blokAdi = row.querySelector('[data-title="Blok Adı"]');
                    var katMalikiUserNameInput = row.querySelector('.katMaliki');
                    var katMalikiTCInput = row.querySelector('[name="tcKatMaliki"] .katMaliki');
                    var katMalikiPhoneInput = row.querySelector('[name="telefon"] .katMaliki');
                    var katMalikiEmailInput = row.querySelector('[name="eposta"] .katMaliki');
                    var katMalikiPlateInput = row.querySelector('[name="plate"] .katMaliki');
                    var katMalikiGenderInput = row.querySelector('[name="gender"] .katMaliki');
                    var katMalikiOpeningBalanceInput = row.querySelector(
                        '[name="openingBalance"] .katMaliki');
                    var katMalikiBalanceTypeInput = row.querySelector(
                    '[name="balanceType"] .katMaliki');
                    var katMalikiPromiseInput = row.querySelector('[name="promise"] .katMaliki');

                    var kiraciUserNameInput = row.querySelector('.kiracii');
                    var kiraciTCInput = row.querySelector('[name="tcKatMaliki"] .kiracii');
                    var kiraciPhoneInput = row.querySelector('[name="telefon"] .kiracii');
                    var kiraciEmailInput = row.querySelector('[name="eposta"] .kiracii');
                    var kiraciPlateInput = row.querySelector('[name="plate"] .kiracii');
                    var kiraciGenderInput = row.querySelector('[name="gender"] .kiracii');
                    var kiraciOpeningBalanceInput = row.querySelector(
                        '[name="openingBalance"] .kiracii');
                    var kiraciBalanceTypeInput = row.querySelector('[name="balanceType"] .kiracii');
                    var kiraciPromiseInput = row.querySelector('[name="promise"] .kiracii');

                    var blokAdiText = blokAdi.innerText.trim();
                    var katMalikiUserName = katMalikiUserNameInput.value.trim();
                    var katMalikiTC = katMalikiTCInput.value.trim();
                    var katMalikiPhone = katMalikiPhoneInput.value.trim();
                    var katMalikiEmail = katMalikiEmailInput.value.trim();
                    var katMalikiPlate = katMalikiPlateInput.value.trim();
                    var katMalikiGender = katMalikiGenderInput.value.trim();
                    var katMalikiOpeningBalance = katMalikiOpeningBalanceInput.value.trim();
                    var katMalikiBalanceType = katMalikiBalanceTypeInput.value.trim();
                    var katMalikiPromise = katMalikiPromiseInput.value.trim();

                    var kiraciUserName = kiraciUserNameInput.value.trim();
                    var kiraciTC = kiraciTCInput.value.trim();
                    var kiraciPhone = kiraciPhoneInput.value.trim();
                    var kiraciEmail = kiraciEmailInput.value.trim();
                    var kiraciPlate = kiraciPlateInput.value.trim();
                    var kiraciGender = kiraciGenderInput.value.trim();
                    var kiraciOpeningBalance = kiraciOpeningBalanceInput.value.trim();
                    var kiraciBalanceType = kiraciBalanceTypeInput.value.trim();
                    var kiraciPromise = kiraciPromiseInput.value.trim();

                    if (katMalikiUserName !== "" && !initialData.some(function(item) {
                            return item.userName === katMalikiUserName && item.durum ===
                                "katmaliki" && item.blok === blokAdiText;
                        })) {
                        newEntries.push({
                            userName: katMalikiUserName,
                            durum: "katmaliki",
                            blok: blokAdiText,
                            tc: katMalikiTC,
                            telefon: katMalikiPhone,
                            eposta: katMalikiEmail,
                            plate: katMalikiPlate,
                            gender: katMalikiGender,
                            openingBalance: katMalikiOpeningBalance,
                            balanceType: katMalikiBalanceType,
                            promise: katMalikiPromise
                        });
                    } else if (katMalikiUserName === "" && (katMalikiTC !== "" || katMalikiPhone !==
                            "" || katMalikiEmail !== "" || katMalikiPlate !== "" ||
                            katMalikiOpeningBalance !== "") && !initialData.some(function(item) {
                            return item.userName === katMalikiUserName && item.durum ===
                                "katmaliki" && item.blok === blokAdiText;
                        })) {
                        alert(blokAdiText +
                            " daire Kat Maliki kullanıcısı ad soyad sütünu boş bırakılmıştır lütfen doldurunuz."
                            );
                        hasError = true;
                        return false; // Döngüden çık
                    }

                    if (kiraciUserName !== "" && !initialData.some(function(item) {
                            return item.userName === kiraciUserName && item.durum === "kiraci" &&
                                item.blok === blokAdiText;
                        })) {
                        newEntries.push({
                            userName: kiraciUserName,
                            durum: "kiraci",
                            blok: blokAdiText,
                            tc: kiraciTC,
                            telefon: kiraciPhone,
                            eposta: kiraciEmail,
                            plate: kiraciPlate,
                            gender: kiraciGender,
                            openingBalance: kiraciOpeningBalance,
                            balanceType: kiraciBalanceType,
                            promise: kiraciPromise
                        });
                    } else if (kiraciUserName === "" && (kiraciTC !== "" || kiraciPhone !== "" ||
                            kiraciEmail !== "" || kiraciPlate !== "" || kiraciOpeningBalance !== "") &&
                        !initialData.some(function(item) {
                            return item.userName === kiraciUserName && item.durum === "kiraci" &&
                                item.blok === blokAdiText;
                        })) {
                        alert(blokAdiText +
                            " daire kiracı kullanıcısı ad soyad sütünu boş bırakılmıştır lütfen doldurunuz."
                            );
                        hasError = true;
                        return false; // Döngüden çık
                    }
                });

                if (hasError) {
                    return; // Eğer bir hata varsa fonksiyondan çık
                }

                var hasDuplicateEmail = false;
                var emailList = newEntries.map(function(entry) {
                    return entry.eposta;
                });

                emailList.forEach(function(email, index) {
                    if (emailList.indexOf(email) !== index) {
                        hasDuplicateEmail = true;
                    }
                });

                if (emailList.some(function(email) {
                        return email === "";
                    })) {
                    hasDuplicateEmail = false;
                }

                if (hasDuplicateEmail) {
                    alert("Epostası aynı olanlar var lütfen düzeltiniz");
                    return; // Eğer e-posta adreslerinde çakışma varsa, AJAX çağrısını yapmadan işlemi sonlandır
                }

                // AJAX çağrısı döngünün dışında yapılır
                $.ajax({
                    url: 'Controller/bulkAddingUser.php',
                    type: 'POST',
                    data: {
                        newEntries: JSON.stringify(newEntries)
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });
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