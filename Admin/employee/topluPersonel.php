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
        $sql = "SELECT * from tbl_employed
        WHERE apartman_ID = :apartmanID";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':apartmanID', $_SESSION["apartID"]);
        $stmt->execute();
    
        // Sonuç kümesinin satır sayısını kontrol etme
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if ($result) {
            ?>
    <table id="table" class="users-table">
        <thead>
            <tr class="users-table-info">
                <th onclick="sortTable(0)">İsim Soyisim<i id="icon-table1" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(1)">TC Numarası<i id="icon-table2" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(2)">Cinsiyet<i id="icon-table3" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(3)">Email<i id="icon-table4" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(4)">Telefon Numarası<i id="icon-table5" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(5)">Öğrenim Durumu<i id="icon-table6" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(6)">Iban<i id="icon-table7" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(7)">İşe Başlangıç Tarihi<i id="icon-table8" class="fa-solid fa-sort-down"></i>
                </th>
                <th onclick="sortTable(8)">Görevi<i id="icon-table9" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(9)">Sigorta Numarası<i id="icon-table10" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(10)">Maaş<i id="icon-table11" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(11)">Birim<i id="icon-table12" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(12)">Açılış Bakiyesi<i id="icon-table13" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(13)">Bakiye Türü<i id="icon-table14" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(14)">Ödeme Tarihi<i id="icon-table15" class="fa-solid fa-sort-down"></i></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($result as $row) {
                ?>
            <tr data-userid="" class="git-ac<?php echo $i ?>">

                <td data-title="Ad Soyad" name="fullName" class="table_tt table_td">
                    <input type="text" class="input-select" value="<?php echo $row["fullName"] ?? ''; ?>"
                        <?php echo isset($row["fullName"]) ? 'readonly' : ''; ?> />
                </td>
                <td data-title="TC No" name="TC" class="table_tt table_td">
                    <input type="text" class="input-select" oninput="checkTCNumberLength(this)"
                        value="<?php echo $row["TC"] ?? ''; ?>"
                        <?php echo isset($row["fullName"]) ? 'readonly' : ''; ?> />
                </td>
                <td data-title="gender" name="gender" class="table_tt table_td">
                    <select class="input-select" <?php echo isset($row["fullName"]) ? 'disabled' : ''; ?>>
                        <option value="Erkek"
                            <?php if(isset($row["gender"]) && $row["gender"] === "Erkek") echo "selected"; ?>>
                            Erkek</option>
                        <option value="Kadın"
                            <?php if(isset($row["gender"]) && $row["gender"] === "Kadın") echo "selected"; ?>>
                            Kadın</option>
                    </select>
                </td>
                <td data-title="E-Posta" name="eposta" class="table_tt table_td">
                    <input type="text" class="input-select" value="<?php echo $row["userEmail"] ?? ''; ?>"
                        <?php echo isset($row["fullName"]) ? 'readonly' : ''; ?> />
                </td>

                <td data-title="Telefon" name="telefon" class="table_tt table_td">
                    <input type="text" class="input-select" oninput="checkPhoneNumberLength(this)"
                        value="<?php echo $row["phoneNumber"] ?? ''; ?>"
                        <?php echo isset($row["fullName"]) ? 'readonly' : ''; ?> />
                </td>
                <td data-title="educationStatus" name="educationStatus" class="table_tt table_td">
                    <select class="input-select" <?php echo isset($row["fullName"]) ? 'disabled' : ''; ?>>
                        <option value="ilkOkul"
                            <?php if(isset($row["educationStatus"]) && $row["educationStatus"] === "ilkOkul") echo "selected"; ?>>
                            İlk Okul</option>
                        <option value="ortaOkul"
                            <?php if(isset($row["educationStatus"]) && $row["educationStatus"] === "ortaOkul") echo "selected"; ?>>
                            Orta Okul</option>
                        <option value="lise"
                            <?php if(isset($row["educationStatus"]) && $row["educationStatus"] === "lise") echo "selected"; ?>>
                            Lise</option>
                        <option value="universite"
                            <?php if(isset($row["educationStatus"]) && $row["educationStatus"] === "universite") echo "selected"; ?>>
                            Üniversite</option>
                    </select>
                </td>
                <td data-title="Iban" name="Iban" class="table_tt table_td">
                    <input type="text" class="input-select" value="<?php echo $row["Iban"] ?? ''; ?>"
                        <?php echo isset($row["fullName"]) ? 'readonly' : ''; ?> />
                </td>
                <td data-title="startingWorking" name="startingWorking" class="table_tt table_td">
                    <input type="date" class="input-select" value="<?php echo $row["startingWorking"] ?? ''; ?>"
                        <?php echo isset($row["fullName"]) ? 'readonly' : ''; ?> />
                </td>
                <td data-title="task" name="task" class="table_tt table_td">
                    <input type="text" class="input-select" value="<?php echo $row["task"] ?? ''; ?>"
                        <?php echo isset($row["fullName"]) ? 'readonly' : ''; ?> />
                </td>
                <td data-title="sigorta" name="sigorta" class="table_tt table_td">
                    <input type="text" class="input-select" value="<?php echo $row["sigortaNo"] ?? ''; ?>"
                        <?php echo isset($row["fullName"]) ? 'readonly' : ''; ?> />
                </td>
                <td data-title="salary" name="salary" class="table_tt table_td">
                    <input type="text" class="input-select" value="<?php echo $row["salary"] ?? ''; ?>"
                        <?php echo isset($row["fullName"]) ? 'readonly' : ''; ?> />
                </td>
                <td data-title="unit" name="unit" class="table_tt table_td">
                    <input type="text" class="input-select" value="<?php echo $row["unit"] ?? ''; ?>"
                        <?php echo isset($row["fullName"]) ? 'readonly' : ''; ?> />
                </td>
                <td data-title="openingBalance" name="openingBalance" class="table_tt table_td">
                    <input type="text" class="input-select" value="<?php echo $row["openingBalance"] ?? ''; ?>"
                        <?php echo isset($row["fullName"]) ? 'readonly' : ''; ?> />
                </td>
                <td data-title="balanceType" name="balanceType" class="table_tt table_td">
                    <select class="input-select" <?php echo isset($row["balanceType"]) ? 'disabled' : ''; ?>>
                        <option value="TL"
                            <?php if(isset($row["balanceType"]) && $row["balanceType"] === "TL") echo "selected"; ?>>
                            TL</option>
                        <option value="Euro"
                            <?php if(isset($row["balanceType"]) && $row["balanceType"] === "Euro") echo "selected"; ?>>
                            Euro</option>
                        <option value="Dolar"
                            <?php if(isset($row["balanceType"]) && $row["balanceType"] === "Dolar") echo "selected"; ?>>
                            Dolar</option>
                    </select>
                </td>
                <td data-title="promise" name="promise" class="table_tt table_td">
                    <input type="Date" class="input-select" value="<?php echo $row["promise"] ?? ''; ?>"
                        <?php echo isset($row["fullName"]) ? 'readonly' : ''; ?> />
                </td>
            </tr>
            <?php
                ?>
            <?php
            }
            echo '
            </tbody>
                    </table>
                <button id="addRowBtn" onclick="addRow()" class="btn-custom-outline bcoc1">+</button>
                </div>';
        } else {
            echo "0 results";
        }
    } catch (PDOException $e) {
        echo "Bağlantı hatası: " . $e->getMessage();
    }
    ?>
            <script>
            // TC kimlik numarasının uzunluğunu kontrol eden fonksiyon
            function checkTCNumberLength(input) {
                if (input.value.length > 11) {
                    input.value = input.value.slice(0, 11); // Input değerini 11 karaktere kırp
                }
            }

            // Telefon numarasının uzunluğunu kontrol eden fonksiyon
            function checkPhoneNumberLength(input) {
                if (input.value.length > 10) {
                    input.value = input.value.slice(0, 10); // Input değerini 10 karaktere kırp
                }
            }
            </script>
            <script>
            function addRow() {
                var table = document.getElementById("table").getElementsByTagName('tbody')[0];
                var newRow = table.insertRow(table.rows.length);

                // İsim Soyisim
                var cell1 = newRow.insertCell(0);
                cell1.innerHTML = '<input type="text" class="input-select" name="fullName" value="">';

                // TC Numarası
                var cell2 = newRow.insertCell(1);
                cell2.innerHTML =
                    '<input type="text" class="input-select" name="TC" oninput="checkTCNumberLength(this)" value="">';

                // Cinsiyet
                var cell3 = newRow.insertCell(2);
                cell3.innerHTML = '<select class="input-select" name="gender">' +
                    '<option value="Erkek">Erkek</option>' +
                    '<option value="Kadın">Kadın</option>' +
                    '</select>';

                // Email
                var cell4 = newRow.insertCell(3);
                cell4.innerHTML = '<input type="text" class="input-select" name="eposta" value="">';

                // Telefon Numarası
                var cell5 = newRow.insertCell(4);
                cell5.innerHTML =
                    '<input type="text" class="input-select" name="telefon" oninput="checkPhoneNumberLength(this)" value="">';

                // Öğrenim Durumu
                var cell6 = newRow.insertCell(5);
                cell6.innerHTML = '<select class="input-select" name="educationStatus">' +
                    '<option value="ilkOkul">İlk Okul</option>' +
                    '<option value="ortaOkul">Orta Okul</option>' +
                    '<option value="lise">Lise</option>' +
                    '<option value="universite">Üniversite</option>' +
                    '</select>';

                // Iban
                var cell7 = newRow.insertCell(6);
                cell7.innerHTML = '<input type="text" class="input-select" name="Iban" value="">';

                // İşe Başlangıç Tarihi
                var cell8 = newRow.insertCell(7);
                cell8.innerHTML = '<input type="date" class="input-select" name="startingWorking" value="">';

                // Görevi
                var cell9 = newRow.insertCell(8);
                cell9.innerHTML = '<input type="text" class="input-select" name="task" value="">';

                // Sigorta Numarası
                var cell10 = newRow.insertCell(9);
                cell10.innerHTML = '<input type="text" class="input-select" name="sigorta" value="">';

                // Maaş
                var cell11 = newRow.insertCell(10);
                cell11.innerHTML = '<input type="text" class="input-select" name="salary" value="">';

                // Birim
                var cell12 = newRow.insertCell(11);
                cell12.innerHTML = '<input type="text" class="input-select" name="unit" value="">';

                // Açılış Bakiyesi
                var cell13 = newRow.insertCell(12);
                cell13.innerHTML = '<input type="text" class="input-select" name="openingBalance" value="">';

                // Bakiye Türü
                var cell14 = newRow.insertCell(13);
                cell14.innerHTML = '<select class="input-select" name="balanceType">' +
                    '<option value="TL">TL</option>' +
                    '<option value="Euro">Euro</option>' +
                    '<option value="Dolar">Dolar</option>' +
                    '</select>';

                // Ödeme Tarihi
                var cell15 = newRow.insertCell(14);
                cell15.innerHTML = '<input type="date" class="input-select" name="promise" value="">';
            }
            </script>

            <script type="text/javascript">
            saveButton.addEventListener('click', function() {
                var tableRows = document.querySelectorAll("#table tbody tr");
                var dataToSend = [];

                // Tüm satırları döngüye al
                tableRows.forEach(function(row) {
                    var rowData = {};

                    // Satır içindeki input ve select elementlerini seç
                    var inputs = row.querySelectorAll("input, select");

                    // Her bir input/select için değeri rowData objesine ekle
                    inputs.forEach(function(input) {
                        var name = input.getAttribute("name");
                        var value = input.value;
                        rowData[name] = value;
                    });

                    // rowData objesini gönderilecek veriler dizisine ekle
                    dataToSend.push(rowData);
                });

                console.log(dataToSend);
                // AJAX isteği oluştur
                $.ajax({
                    url: 'Controller/Employeed/bulkAddingEmployed.php',
                    type: 'POST',
                    data: {
                        dataToSend: JSON.stringify(dataToSend)
                    },
                    success: function(response) {
                        console.log(response);
                        if (response == "success") {
                            console.log("Başarılı!");
                            location.reload();
                        } else {
                            alert(response);
                        }
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