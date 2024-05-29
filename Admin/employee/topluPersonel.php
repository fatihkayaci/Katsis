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
        WHERE apartman_ID = :apartmanID AND arsive = 0";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':apartmanID', $_SESSION["apartID"]);
        $stmt->execute();
    
        // Sonuç kümesinin satır sayısını kontrol etme
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if ($result) {
            ?>
        <div id="table" class="employee-main">

        <hr class="horizontal dark mt-0 w-100">

            <?php
            foreach ($result as $row) {
                ?>
            <div id="toplu-box" data-userid="" class="toplu-islem">

                <div data-title="Ad Soyad" name="fullName" class="toplu-islem-inside">
                    <label for="ad">İsim Soyisim:</label>
                    <input id="ad" type="text" class="input-toplu" value="<?php echo $row["fullName"] ?? ''; ?>"
                        <?php echo isset($row["fullName"]) ? 'readonly' : ''; ?> />
                </div>

                <div data-title="TC No" name="TC" class="toplu-islem-inside">
                    <label for="tc">TC Numarası:</label>
                    <input id="tc" type="text" class="input-toplu" oninput="checkTCNumberLength(this)"
                        value="<?php echo $row["TC"] ?? ''; ?>"
                        <?php echo isset($row["fullName"]) ? 'readonly' : ''; ?> />
                </div>

                <div data-title="gender" name="gender" class="toplu-islem-inside">
                    <label for="gender">Cinsiyet:</label>
                    <select id="gender" class="input-toplu" <?php echo isset($row["fullName"]) ? 'disabled' : ''; ?>>
                        <option value="Erkek"
                            <?php if(isset($row["gender"]) && $row["gender"] === "Erkek") echo "selected"; ?>>
                            Erkek</option>
                        <option value="Kadın"
                            <?php if(isset($row["gender"]) && $row["gender"] === "Kadın") echo "selected"; ?>>
                            Kadın</option>
                    </select>
                </div>

                <div data-title="E-Posta" name="eposta" class="toplu-islem-inside">
                    <label for="mail">Email:</label>
                    <input id="mail" type="text" class="input-toplu" value="<?php echo $row["userEmail"] ?? ''; ?>"
                        <?php echo isset($row["fullName"]) ? 'readonly' : ''; ?> />
                </div>

                <div data-title="Telefon" name="telefon" class="toplu-islem-inside">
                    <label for="phone">Telefon Numarası:</label>
                    <input id="phone" type="text" class="input-toplu" oninput="checkPhoneNumberLength(this)"
                        value="<?php echo $row["phoneNumber"] ?? ''; ?>"
                        <?php echo isset($row["fullName"]) ? 'readonly' : ''; ?> />
                </div>

                <div data-title="educationStatus" name="educationStatus" class="toplu-islem-inside">
                    <label for="education">Öğrenim Durumu:</label>
                    <select id="education" class="input-toplu" <?php echo isset($row["fullName"]) ? 'disabled' : ''; ?>>
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
                </div>

                <div data-title="Iban" name="Iban" class="toplu-islem-inside">
                    <label for="iban">Iban:</label>
                    <input id="iban" type="text" class="input-toplu" value="<?php echo $row["Iban"] ?? ''; ?>"
                        <?php echo isset($row["fullName"]) ? 'readonly' : ''; ?> />
                </div>

                <div data-title="startingWorking" name="startingWorking" class="toplu-islem-inside">
                    <label for="start-date">İşe Başlangıç Tarihi:</label>
                    <input id="start-date" type="date" class="input-toplu" value="<?php echo $row["startingWorking"] ?? ''; ?>"
                        <?php echo isset($row["fullName"]) ? 'readonly' : ''; ?> />
                </div>

                <div data-title="task" name="task" class="toplu-islem-inside">
                    <label for="task">Görevi:</label>
                    <input id="task" type="text" class="input-toplu" value="<?php echo $row["task"] ?? ''; ?>"
                        <?php echo isset($row["fullName"]) ? 'readonly' : ''; ?> />
                </div>

                <div data-title="sigorta" name="sigorta" class="toplu-islem-inside">
                    <label for="sigortaNo">Sigorta Numarası:</label>
                    <input id="sigortaNo" type="text" class="input-toplu" value="<?php echo $row["sigortaNo"] ?? ''; ?>"
                        <?php echo isset($row["fullName"]) ? 'readonly' : ''; ?> />
                </div>

                <div data-title="salary" name="salary" class="toplu-islem-inside">
                    <label for="salary">Maaş:</label>
                    <input id="salary" type="text" class="input-toplu" value="<?php echo $row["salary"] ?? ''; ?>"
                        <?php echo isset($row["fullName"]) ? 'readonly' : ''; ?> />
                </div>

                <div data-title="unit" name="unit" class="toplu-islem-inside">
                    <label for="unit">Birim:</label>
                    <input id="unit" type="text" class="input-toplu" value="<?php echo $row["unit"] ?? ''; ?>"
                        <?php echo isset($row["fullName"]) ? 'readonly' : ''; ?> />
                </div>

                <div data-title="openingBalance" name="openingBalance" class="toplu-islem-inside">
                    <label for="openingBalance">Açılış Bakiyesi:</label>
                    <input id="openingBalance" type="text" class="input-toplu" value="<?php echo $row["openingBalance"] ?? ''; ?>"
                        <?php echo isset($row["fullName"]) ? 'readonly' : ''; ?> />
                </div>

                <div data-title="balanceType" name="balanceType" class="toplu-islem-inside">
                    <label for="balanceType">Bakiye Türü:</label>
                    <select id="balanceType" class="input-toplu" <?php echo isset($row["balanceType"]) ? 'disabled' : ''; ?>>
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
                </div>

                <div data-title="promise" name="promise" class="toplu-islem-inside">
                    <label for="promise">Ödeme Tarihi:</label>
                    <input id="promise" type="Date" class="input-toplu" value="<?php echo $row["promise"] ?? ''; ?>"
                        <?php echo isset($row["fullName"]) ? 'readonly' : ''; ?> />
                </div>
            </div>

            <hr class="horizontal dark w-100">

            <div id="employee-main" class="employee-main-yeniveri">

            </div>

           
            
            <?php
            }
            echo '
            <button id="addRowBtn" onclick="addRow()" class="btn-custom-outline bcoc1"><i class="fa-solid fa-user-plus"></i> Personel Ekle</button>
                </div>
            </div>
        </div>
        
       ';
        } else {
            
            ?>
              <div id="employee-main" class="employee-main-yeniveri"></div>

        <button id="addRowBtn" onclick="addRow()" class="btn-custom-outline bcoc1">
            <i class="fa-solid fa-user-plus"></i> Personel Ekle
        </button>

                    <?php
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
    var container = document.getElementById("employee-main");

    // Yeni bir satır için ana div oluştur
    var newRow = document.createElement('div');
    newRow.classList.add('toplu-islem');

    // Her bir hücre için div oluştur ve içerik ekle
    var fields = [
        {name: 'fullName', type: 'text', label: 'İsim Soyisim:'},
        {name: 'TC', type: 'text', label: 'TC Numarası:', oninput: 'checkTCNumberLength(this)'},
        {name: 'gender', type: 'select', label: 'Cinsiyet:', options: [{value: 'Erkek', text: 'Erkek'}, {value: 'Kadın', text: 'Kadın'}]},
        {name: 'eposta', type: 'text', label: 'Email:'},
        {name: 'telefon', type: 'text', label: 'Telefon Numarası:', oninput: 'checkPhoneNumberLength(this)'},
        {name: 'educationStatus', type: 'select', label: 'Öğrenim Durumu:', options: [{value: 'ilkOkul', text: 'İlk Okul'}, {value: 'ortaOkul', text: 'Orta Okul'}, {value: 'lise', text: 'Lise'}, {value: 'universite', text: 'Üniversite'}]},
        {name: 'Iban', type: 'text', label: 'Iban:'},
        {name: 'startingWorking', type: 'date', label: 'İşe Başlangıç Tarihi:'},
        {name: 'task', type: 'text', label: 'Görevi:'},
        {name: 'sigorta', type: 'text', label: 'Sigorta Numarası:'},
        {name: 'salary', type: 'text', label: 'Maaş:'},
        {name: 'unit', type: 'text', label: 'Birim:'},
        {name: 'openingBalance', type: 'text', label: 'Açılış Bakiyesi:'},
        {name: 'balanceType', type: 'select', label: 'Bakiye Türü:', options: [{value: 'TL', text: 'TL'}, {value: 'Euro', text: 'Euro'}, {value: 'Dolar', text: 'Dolar'}]},
        {name: 'promise', type: 'date', label: 'Ödeme Tarihi:'}
    ];

    fields.forEach(function(field) {
        var cell = document.createElement('div');
        cell.classList.add('toplu-islem-inside');

        var label = document.createElement('label');
        label.innerText = field.label;
        cell.appendChild(label);

        if (field.type === 'select') {
            var select = document.createElement('select');
            select.name = field.name;
            select.classList.add('input-toplu');
            field.options.forEach(function(option) {
                var opt = document.createElement('option');
                opt.value = option.value;
                opt.innerText = option.text;
                select.appendChild(opt);
            });
            cell.appendChild(select);
        } else {
            var input = document.createElement('input');
            input.type = field.type;
            input.name = field.name;
            input.classList.add('input-toplu');
            if (field.oninput) input.setAttribute('oninput', field.oninput);
            cell.appendChild(input);
        }

        newRow.appendChild(cell);
    });

    container.appendChild(newRow);

    // Yeni satırdan sonra <hr> ekle
    var hr = document.createElement('hr');
    hr.classList.add('horizontal', 'dark', 'w-100');
    container.appendChild(hr);
}
</script>

            <script type="text/javascript">
            saveButton.addEventListener('click', function() {
    var tableRows = document.querySelectorAll("#employee-main .toplu-islem");
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