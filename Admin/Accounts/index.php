<?php
require_once 'Controller/class.func.php';
$userPass = randomPassword();

$optionsBlok = [];
$optionsDurum = '';
try {
    //burada yeni eklendi css eklenmesi lazım.
    $sql = "SELECT d.daire_id, d.blok_adi, d.daire_sayisi, b.blok_adi
    FROM tbl_daireler d
    INNER JOIN tbl_blok b ON d.blok_adi = b.blok_id
    WHERE d.apartman_id = " . $_SESSION["apartID"];

    $result = $conn->query($sql);

    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            // Diziye değerleri ekle
            $optionsBlok[] = '<option name="optionsBlok" data-user-id="' . $row['daire_id'] . '" value="' . $row['blok_adi'] . " Blok - Daire " . $row['daire_sayisi'] . '">' . $row['blok_adi'] . " Blok - Daire " . $row['daire_sayisi'] . '</option>';
        }
    }

    $sql2 = "SELECT u.userID, u.userName, u.tc, u.phoneNumber,d.daire_id, b.blok_adi AS blok_adi, d.daire_sayisi,
    CASE
        WHEN d.katMalikiID = u.userID THEN 'Kat Maliki'
        WHEN d.kiraciID = u.userID THEN 'kiraci'
        ELSE 'Belirtilmemiş'
    END AS durum
    FROM tbl_users u
    LEFT JOIN tbl_daireler d ON u.userID = d.katMalikiID OR u.userID = d.kiraciID
    LEFT JOIN tbl_blok b ON d.blok_adi = b.blok_id
    WHERE rol=3 AND u.apartman_id = " . $_SESSION["apartID"] . "
    ORDER BY u.userName ASC";

    $stmt = $conn->prepare($sql2);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //contenteditable="true"
    ?>
    <style>
        .hidden {
            display: none;
        }
        .input::placeholder {
            color: transparent;
        }

        .input:focus::placeholder {
            color: #999; /* İstediğiniz renk burada olabilir */
        }
    </style>
    <div class="cener-table">

        <div class="input-group-div">

            <div class="input-group1">

                <button class="adduser btn-custom-outline userClr">Kullanıcı Ekle</button>
                <button class="toplu btn-custom-outline userClr">Toplu İşlemler</button>


                <div class="check-box">
                    <p class="check-p">Düzenleme :</p>

                    <div class="custom-checkbox">
                        <input type="checkbox" name="status" id="editToggle">
                        <label for="editToggle">
                            <div class="status-switch" data-unchecked="kapalı" data-checked="açık"></div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="input-group1">
                <button class="topluGuncelle btn-custom-outline bcoc3" id="guncelleButton" style="display: none;">Güncelle</button>
                <button class="topluSil btn-custom-outline bcoc4" id="silButton" style="display: none;">Sil</button>


                <div class="search-box">
                    <i class="fas fa-search search-icon" aria-hidden="true"></i>
                    <input type="text" class="search-input userSrch" id="searchValue" onkeyup="filtrele()" placeholder="Arama...">
                </div>
            </div>

        </div>

        <hr class="horizontal dark mb-1 w-100">

<div class="table-overflow">
        <table id="example" class="users-table">
            <thead>
                <tr class="users-table-info">
                    <th class="check-style">
                        <input id="mainCheckbox" type="checkbox" onclick="toggleAll(this)" />
                        <label for="mainCheckbox" class="check">
                            <svg width="18px" height="18px" viewBox="0 0 18 18">
                                <path
                                    d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z">
                                </path>
                                <polyline points="1 9 7 14 15 4"></polyline>
                            </svg>
                        </label>
                    </th>
                    <th onclick="sortTable(1)">Ad Soyad <i id="icon-table1" class="fa-solid fa-sort-down"></i></th>
                    <th onclick="sortTable(2)">TC <i id="icon-table2" class="fa-solid fa-sort-down"></i></th>
                    <th onclick="sortTable(3)">Telefon Numarası <i id="icon-table3" class="fa-solid fa-sort-down"></i></th>
                    <th onclick="sortTable(4)">Blok / Daire <i id="icon-table4" class="fa-solid fa-sort-down"></i></th>
                    <th onclick="sortTable(5)">Durum <i id="icon-table5" class="fa-solid fa-sort-down"></i></th>
                </tr>
            </thead>

            <tbody>

                <?php
                $i = 0;
                foreach ($result as $row) {
                    $i++;
                    ?>
                    <tr data-userid="<?php echo $row["userID"]; ?>" data-d="<?php echo $row["daire_id"]; ?>"
                        id="tr-<?php echo $row["userID"] . '-' . $i; ?>" class="git-ac">
                        <td data-title="Seç" class="check-style">
                            <!-- Checkbox id'sine $i değerini ekliyoruz -->
                            <input id="check-<?php echo $row["userID"] . '-' . $i; ?>" class="check1" type="checkbox"
                                onclick="toggleCheckbox(<?php echo $row['userID']; ?>, <?php echo $i; ?>)" />
                            <label for="check-<?php echo $row["userID"] . '-' . $i; ?>" class="check">
                                <svg width="18px" height="18px" viewBox="0 0 18 18">
                                    <path
                                        d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z">
                                    </path>
                                    <polyline points="1 9 7 14 15 4"></polyline>
                                </svg>
                            </label>
                        </td>
                        <td data-title="Ad Soyad" class="table_tt table_td" contenteditable="false">
                            <input class="edit-input" id="adSoyad" type="text" value="<?php echo $row["userName"]; ?>">
                        </td>
                        <td data-title="TC" class="table_tt table_td tc" contenteditable="false">
                            <input class="edit-input" id="tcNo" type="text" value="<?php echo $row["tc"]; ?>" oninput="validateTC(this)">
                        </td>

                        <td data-title="Telefon Numarası" class="table_tt table_td phoneNumberTable" contenteditable="false">
                            <input class="edit-input" id="numara" type="text" value="<?php echo $row["phoneNumber"]; ?>" oninput="validatePhoneNumber(this)">
                        </td>

                        <td data-title="Blok Adi" class="table_tt table_td">
                            <?php
                            if (!empty($row["blok_adi"]) && !empty($row["daire_sayisi"])) {
                                echo $row["blok_adi"] . " / " . $row["daire_sayisi"];
                            }
                            ?>
                        </td>

                        <td data-title="Durum" class="table_tt table_td">
                            <div class="main-durum <?php
                            if ($row["durum"] == "kiraci") {
                                echo "kiraci";
                            } elseif ($row["durum"] == "Kat Maliki") {
                                echo "kat-maliki";
                            } else {
                                echo "belirtilmemis";
                            }
                            ?>">
                                <?php if ($row["durum"] == "kiraci") {
                                    echo "Kiracı";
                                } elseif ($row["durum"] == "Kat Maliki") {
                                    echo "kat Maliki";
                                } else {
                                    echo "Belirtilmemiş";
                                }
                                ?>
                            </div>
                        </td>
                    </tr>

                    <?php
                }
                ?>


            </tbody>
        </table>
</div>

        <hr class="horizontal dark mb-0 w-100">

        <div class="input-group-div">

            <div class="input-group1">

                <div class="custom-select">
                    <select>
                        <option selected value="1">10</option>
                        <option value="2">20</option>
                        <option value="3">50</option>
                        <option value="4">100</option>
                    </select>
                </div>

                <p class="adet-txt">Adet Veri Gösteriliyor</p>

            </div>
            <button class="export-btn excel-btn" id="exportButton"><i class="fa-solid fa-file-excel"></i> Excel'e Aktar</button>
            <div class="input-group1">

                <ul class="pagination">
                    <a href="#" class="pagination-arrow arrow-left">
                        <i class="fa-solid fa-angle-left"></i>
                    </a>
                    <a href="#" class="pagination-number">1</a>
                    <a href="#" class="pagination-number">2</a>
                    <a href="#" class="pagination-number current-number">3</a>
                    <a href="#" class="pagination-number">4</a>
                    <a href="#" class="pagination-number">5</a>
                    <a href="#" class="pagination-arrow arrow-right">
                        <i class="fa-solid fa-angle-right"></i>
                    </a>
                </ul>

            </div>

        </div>

    </div>

    <?php
} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
?>

<!-- Popup Form -->
<div id="popup">

    <form class="login-form userInpClr" id="userForm">

        <h2 class="form-signin-heading mb-3">Kullanıcı Ekleme</h2>

        <hr class="horizontal dark mt-0 w-100">

        <div class="row mb-1">
            <div class="col-md-6 col-btn">
                <input class="input" type="text" name="userName" required="">
                <label for="userName">Ad Soyad :</label>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col">
                <input class="input" type="text" name="tc" required="" require>
                <label for="tc">T.C. Kimlik No :</label>
            </div>
            <div class="col-md-6 col">
                <input class="input tel" type="number" name="phoneNumber"  placeholder="555 555 55 55" required="">
                <label for="phoneNumber">Telefon Numarası :</label>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col">
                <input class="input" type="text" name="userEmail" required="">
                <label for="userEmail">E-Posta :</label>
            </div>

            <div class="col-md-6 col margint">
                <input class="input" type="text" name="plate" required="">
                <label for="plate">Araç Plakası : </label>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col margint">
                <div class="select-div m-0">
                    <div class="dropdown-nereden">
                        <div class="group">
                            <input class="search-selectx input" data-user-id="" type="text" list="Users" id="gender"
                                required="" />
                            <label class="selectx-label" for="gender">Cinsiyet : </label>
                        </div>

                        <div class="dropdown-content-nereden searchInput-btn" id="genderDp">
                            <div class="dropdown-content-inside-nereden userPopup">
                                <input type="hidden" id="searchInput3" placeholder="Ara...">
                                <button data-user-id="Erkek" name="gender" class="genderButton">Erkek</button>
                                <button data-user-id="Kadin" name="gender" class="genderButton">Kadın</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col margint">
                <input class="input" type="text" id="userPass" name="password" value="<?= $userPass ?>"
                    required="">
                <label for="sifre">Şifre :</label>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 check-label margint">
                <div class="yeni-check acilischc">
                    <input onchange="toggleDisplay()" class="yenichk-inpt" id="onay" name="onay" type="checkbox"/>
                    <label class="yenichk-label" for="onay"><span>
                        <svg width="12px" height="10px">
                            <use xlink:href="#check-4"></use>
                        </svg></span><span>Açılış Bakiyesi Ekleme</span>
                    </label>
                    <svg class="inline-svg">
                        <symbol id="check-4" viewbox="0 0 12 10">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                        </symbol>
                    </svg>
                </div>
            </div>
        </div>

        <div class="additional-fields hidden">
            <div class="row">
                <div class="col-md-6 col mt-4 margint">
                    <input class="input" type="text" name="openingBalance" required="">
                    <label for="openingBalance">Açılış Bakiyesi</label>
                </div>

                <div class="col-md-6 col mt-4 margint">
                    <div class="select-div m-0">
                        <div class="dropdown-nereden">
                            <div class="group">
                                <input class="search-selectx input" data-user-id="" type="text" id="odemeDurumu"
                                    required="" />
                                <label class="selectx-label" for="odemeDurumu">Ödeme Durumu: </label>
                            </div>

                            <div class="dropdown-content-nereden searchInput-btn" id="odemeDurumuDP">
                                <div class="dropdown-content-inside-nereden userPopup">
                                    <input type="hidden" id="odemeSearch" placeholder="Ara...">
                                    <button data-odeme-durumu="Borç" name="odemeDurumu" class="odemeButton">Borç</button>
                                    <button data-odeme-durumu="Alacak" name="odemeDurumu" class="odemeButton">Alacak</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-btn margint">
                    <input class="input" data-user-id="" id="datepickerAcilis" name="promise" type="text" required="">
                    <label for="datepickerAcilis">Ekleme Tarihi</label>
                </div>
            </div>
        </div>
        <!-- buraya kadar -->
        <input class="input" type="text" name="apartman_id" value=<?php echo $_SESSION["apartID"]; ?> hidden>

        <div class="row">
            <div class="col-md-12 col-btn">
                <button type="button" class="daireEkle btn-custom-daire userClr">Daire Ata</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-btn mb-0">
                <div class="indexAdd">
                </div>
            </div>
        </div>

        <hr class="horizontal dark mt-0 w-100">

        <div class="row row-btn">
            <button type="button" class="btn-custom-close" onclick="closePopup()">Kapat</button>
            <button type="button" class="btn-custom bcoc1" id="saveButton">Kaydet</button>
        </div>


    </form>
</div>
<!--buraya toplu hesap eklenmesi için popup eklendi içeriğinin düzenlenmesi lazım-->
<div id="topluPopup">

    <form class="login-form-toplu" id="userForm2" action="">

        <h2 class="form-signin-heading">Oluşturma Şeklini Seçiniz!</h2>

        <div class="row">
            <div class="col-md-12 col-btn mb-0">
                <a class="ahref btn-custom-daire userClr w-100" href="index?parametre=TopluHesap">Toplu Kullanıcı Ekleme</a>
                <a class="ahref btn-custom-daire userClr w-100" href="Controller/excelCreate.php" id="excelDownload"
                    download="KullaniciEkle.xlsx">Excel İndir</a>
                <p class="text-left">Excel İle Kullanıcı Ekleme:</p>
                <div class="upload-box usereupl">
                    <input type="file" id="excel_file" accept=".xlsx" hidden>
                    <label for="excel_file" class="file_label userUpl">Dosya Seçin</label>
                    <!-- name of file chosen -->
                    <span id="file-chosen"></span>

                    <button id="upload_btn" class="userClr">Gönder</button>
                </div>
            </div>
        </div>

        <hr class="horizontal dark w-100">

        <div class="row">
            <div class="col-md-12 col-btn">
                <button type="button" class="btn-custom-close w-100" onclick="closeToplu()">Kapat</button>
            </div>
        </div>

    </form>
</div>
<!--buraya daire için popup eklendi içeriğinin düzenlenmesi lazım-->
<div id="dairePopup">
    <form class="login-form-daire userInpClr" id="userForm1" >

        <h2 class="form-signin-heading">Daire Atama</h2>

        <div class="row w-90">
            <div class="col-btn">
                <div class="select-div">
                    <div class="dropdown-nereden">
                        <div class="group">
                            <input class="search-selectx input" data-user-id="" type="text" list="dairegrup" id="daireGrup" name="daireGrup" required="" />

                            <label class="selectx-label" for="daireGrup">Daire: </label>
                        </div>

                        <div class="dropdown-content-nereden searchInput-btn" id="daireGrupDP">
                            <div class="dropdown-content-inside-nereden userPopup">
                                <input type="text" id="daireSearchInput" placeholder="Ara...">

                               
<?php 
foreach ($optionsBlok as $bloks) {
    // Buton oluşturma, seçenek içindeki data-user-id özelliğini butona aktarıyorum
    preg_match('/data-user-id="(\d+)"/', $bloks, $matches);
    $userId = isset($matches[1]) ? $matches[1] : ''; // Eşleşen user id

    // Value değerini çıkartma
    preg_match('/value="([^"]+)"/', $bloks, $valueMatches);
    $value = isset($valueMatches[1]) ? $valueMatches[1] : ''; // Eşleşen value

    echo '<button value="'.htmlspecialchars($value).'" data-user-id="' . $userId . '">' . strip_tags($bloks) . '</button>';
}
?>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-btn">
                <div class="select-div">
                    <div class="dropdown-nereden">
                        <div class="group">
                            <input class="search-selectx input" data-user-id="" type="text" id="durum"
                                required="" />
                            <label class="selectx-label" for="durum">Durumu: </label>
                        </div>

                        <div class="dropdown-content-nereden searchInput-btn" id="durumDP">
                            <div class="dropdown-content-inside-nereden userPopup">
                                <input type="text" id="durumSearch" placeholder="Ara...">
                                <button data-user-id="0">Kat Maliki</button>
                                <button data-user-id="1">Kiracı</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row row-btn">
            <button type="button" class="btn-custom-close" onclick="closeDaire()">Kapat</button>
            <button type="button" class="btn-custom" id="ekle" onclick="newDaire()">Ekle</button>
        </div>

    </form>
</div>
<script>
function validateTC(element) {
    let tc = element.value;

    // Sadece sayılara izin ver ve uzunluğu 11 karakterle sınırla
    if (!/^\d*$/.test(tc) || tc.length > 11) {
        element.value = tc.slice(0, 11).replace(/\D/g, '');
        alert("TC numarası sadece sayılardan oluşmalı ve 11 karakter uzunluğunda olmalıdır.");
    }
}

function validatePhoneNumber(element) {
    let phoneNumber = element.value;

    // Sadece sayılara izin ver ve uzunluğu 10 karakterle sınırla
    if (!/^\d*$/.test(phoneNumber) || phoneNumber.length > 10) {
        element.value = phoneNumber.slice(0, 10).replace(/\D/g, '');
        alert("Telefon numarası sadece sayılardan oluşmalı ve 10 karakter uzunluğunda olmalıdır.");
    }
}
    window.onload = function () {
        var tcInput = document.getElementsByName('tc')[0];
        var phoneInput = document.getElementsByName('phoneNumber')[0];

        // TC için 11 karakter sınırlaması ve sadece rakam girişine izin verme
        tcInput.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 11);
        });

        // Telefon numarası için 10 karakter sınırlaması ve sadece rakam girişine izin verme
        phoneInput.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 10);
        });

        var userPopup = document.getElementById('popup');
        var dairePopup = document.getElementById('dairePopup');
        var topluPopup = document.getElementById('topluPopup');
        // ESC tuşuna basıldığında popup'ı kapat
        window.addEventListener('keydown', function (event) {
            if (event.key === "Escape") {
                if (dairePopup.style.display === 'flex') {
                    closeDaire();
                } else if (userPopup.style.display === 'flex') {
                    closePopup();
                } else if (topluPopup.style.display === 'flex') {
                    closeToplu();
                }
            }
        });
    };
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        toggleExportButton();

        // Tablodaki veriler güncellendiğinde butonun durumunu tekrar kontrol edin.
        // Örneğin, tablo verilerini güncellediğiniz bir fonksiyonunuz varsa, orada da toggleExportButton'u çağırın.
    });

    function toggleExportButton() {
        var table = document.getElementById('example');
        var tbody = table.getElementsByTagName('tbody')[0];
        var exportButton = document.getElementById('exportButton');
        var rows = tbody.getElementsByTagName('tr').length;

        if (rows === 0) {
            exportButton.style.display = 'none';
        } else {
            exportButton.style.display = 'inline-block'; // Veya 'block' ya da 'inline', tasarımınıza göre
        }
    }
</script>
<!-- jQuery'yi ekleyin -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var usersData = <?php echo json_encode($result); ?>;

        // userID'yi çıkartarak ve blokAdi ile daireSayisi'ni birleştirerek yeni bir dizi oluşturma
        var usersArray = usersData.map(function(user) {
            return {
                userName: user.userName,
                tc: user.tc,
                phoneNumber: user.phoneNumber ? user.phoneNumber.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3') : '', // Telefon numarası düzenleme
                blokDaire: user.blok_adi + " / " + user.daire_sayisi, // Blok ve daire sayısını birleştirme
                durum: user.durum
            };
        });

        document.getElementById('exportButton').addEventListener('click', function() {
            var ws = XLSX.utils.json_to_sheet(usersArray);
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Users");

            // Başlıkları ayarlama
            ws['A1'].v = 'Ad Soyad';
            ws['B1'].v = 'TC';
            ws['C1'].v = 'Telefon Numarası';
            ws['D1'].v = 'Blok / Daire';
            ws['E1'].v = 'Durum';

            // Sütun genişliklerini ayarlama
            ws['!cols'] = [
                { wpx: 150 }, // Ad Soyad
                { wpx: 100 }, // TC
                { wpx: 120 }, // Telefon Numarası
                { wpx: 150 }, // Blok / Daire
                { wpx: 100 }  // Durum
            ];

            XLSX.writeFile(wb, 'Users.xlsx');
        });
    });
</script>

</body>

</html>

<script>
    $('#upload_btn').click(function () {
        event.preventDefault();
        var excel_file = $('#excel_file').prop('files')[0];
        var form_data = new FormData();
        form_data.append('excel_file', excel_file);

        $.ajax({
            url: 'Controller/Accounts/uploadFiles.php',
            type: 'POST',
            data: form_data,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response === "Geçersiz dosya yapısı. Lütfen doğru dosyayı yükleyin.") {
                    alert(response);
                } else if ("Kullanıcılar başarıyla yüklendi!") {
                    alert(response);
                    location.reload();
                } else {
                    alert(response);
                }

            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
</script>

<script>
    //buraya bakılacak fatih bey
    function toggleDisplay() {
        var checkbox = document.getElementById('onay');
        var additionalFields = document.querySelector('.additional-fields');

        if (checkbox.checked) {
            additionalFields.classList.remove('hidden');
        } else {
            additionalFields.classList.add('hidden');
        }
    }
</script>

<!-- =============================== -->
<!-- select input start -->

<script>
    var x, i, j, l, ll, selElmnt, a, b, c;
    x = document.getElementsByClassName("custom-select");
    l = x.length;
    for (i = 0; i < l; i++) {
        selElmnt = x[i].getElementsByTagName("select")[0];
        ll = selElmnt.length;
        a = document.createElement("DIV");
        a.setAttribute("class", "select-selected");
        a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
        x[i].appendChild(a);
        b = document.createElement("DIV");
        b.setAttribute("class", "select-items select-hide");
        for (j = 0; j < ll; j++) {
            c = document.createElement("DIV");
            c.innerHTML = selElmnt.options[j].innerHTML;
            c.addEventListener("click", function (e) {
                var y, i, k, s, h, sl, yl;
                s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                sl = s.length;
                h = this.parentNode.previousSibling;
                for (i = 0; i < sl; i++) {
                    if (s.options[i].innerHTML == this.innerHTML) {
                        s.selectedIndex = i;
                        h.innerHTML = this.innerHTML;
                        y = this.parentNode.getElementsByClassName("same-as-selected");
                        yl = y.length;
                        for (k = 0; k < yl; k++) {
                            y[k].removeAttribute("class");
                        }
                        this.setAttribute("class", "same-as-selected");
                        break;
                    }
                }
                h.click();
            });
            b.appendChild(c);
        }
        x[i].appendChild(b);
        a.addEventListener("click", function (e) {
            e.stopPropagation();
            closeAllSelect(this);
            this.nextSibling.classList.toggle("select-hide");
            this.classList.toggle("select-arrow-active");
        });
    }

    function closeAllSelect(elmnt) {
        var x, y, i, xl, yl, arrNo = [];
        x = document.getElementsByClassName("select-items");
        y = document.getElementsByClassName("select-selected");
        xl = x.length;
        yl = y.length;
        for (i = 0; i < yl; i++) {
            if (elmnt == y[i]) {
                arrNo.push(i)
            } else {
                y[i].classList.remove("select-arrow-active");
            }
        }
        for (i = 0; i < xl; i++) {
            if (arrNo.indexOf(i) === -1) {
                x[i].classList.add("select-hide");
            }
        }
    }
    document.addEventListener("click", closeAllSelect);
</script>

<!-- select input end -->
<!-- =============================== -->

<script>
    function sortTable(columnIndex) {
        const table = document.getElementById("example");
        const rows = Array.from(table.rows).slice(1);
        const groups = {};

        // Grupları ayır ve grupları objeye yerleştir
        rows.forEach(row => {
            const groupId = row.getAttribute('data-userid');
            if (!groups[groupId]) groups[groupId] = [];
            groups[groupId].push(row);
        });

        let isAscending = table.getAttribute('data-sort-dir') === 'desc';
        const sortedGroups = Object.values(groups).sort((groupA, groupB) => {
            const cellA = groupA[0].cells[columnIndex].innerText.toLowerCase();
            const cellB = groupB[0].cells[columnIndex].innerText.toLowerCase();

            if (cellA < cellB) return isAscending ? -1 : 1;
            if (cellA > cellB) return isAscending ? 1 : -1;
            return 0;
        });

        sortedGroups.forEach(group => {
            group.forEach(row => table.appendChild(row));
        });

        table.setAttribute('data-sort-dir', isAscending ? 'asc' : 'desc');

        // Clear all icon states
        for (let i = 1; i <= 4; i++) {
            $(`#icon-table${i}`).removeClass("rotate opacity");
        }

        // Update the sorted column's icon state
        $(`#icon-table${columnIndex}`).toggleClass("rotate", !isAscending);
        $(`#icon-table${columnIndex}`).addClass("opacity");
    }
</script>

<!-- ============================== -->
<!-- table dropdown area start -->
<!-- fatih burası -->

<script type="text/javascript">
    var rows = document.querySelectorAll('#example tbody tr');
    var userIdArray = {};
    var emptyRowCreated = {}; // Boş satır oluşturulduğunu kontrol etmek için bir nesne

    rows.forEach(function (row) {
        var userID = row.getAttribute('data-userid');
        var userName = row.querySelector('td[data-title="Ad Soyad"] input').value;
        var tc = row.querySelector('td[data-title="TC"] input').value;
        var phoneNumber = row.querySelector('td[data-title="Telefon Numarası"] input').value;
        
        if (userIdArray[userID]) {
            // Tekrarlanan bir kullanıcı kimliği bulunduğunda tüm satırı gizle
            document.querySelectorAll('[id^="tr-' + userID + '"]').forEach(function (item) {
                item.style.display = 'none';
                item.classList.add('none');
            });

            if (!emptyRowCreated[userID]) {
                var newRow = document.createElement('tr');
                
                var newCell1 = document.createElement('td');
                var newCell2 = document.createElement('td');
                var newCell3 = document.createElement('td');
                var newCell4 = document.createElement('td');
                var newCell5 = document.createElement('td');
                var newCell6 = document.createElement('td');

                var newTextCell = document.createElement('td'); // Yeni metin hücresi oluştur
                newTextCell.textContent = "Birden Fazla Daire"; // Metin içeriğini ayarla
                newRow.classList.add('git-ac');
                newRow.setAttribute('data-userid', userID);

                newCell3.colSpan = "1"; // Üçüncü hücre 1 sütunu kaplasın
                newCell1.colSpan = "1"; // İlk hücre 1 sütunu kaplasın
                newCell2.colSpan = "1"; // İkinci hücre 2 sütunu kaplasın
                newCell4.colSpan = "1"; // Dördüncü hücre 1 sütunu kaplasın
                newCell5.colSpan = "1"; // Dördüncü hücre 1 sütunu kaplasın
                newCell6.colSpan = "1"; // Dördüncü hücre 1 sütunu kaplasın

                var userNameInput = document.createElement('input');
                userNameInput.type = 'text';
                userNameInput.value = userName;
                userNameInput.className = 'edit-input';

                var TCInput =  document.createElement('input');
                TCInput.type = 'text';
                TCInput.value = tc;
                TCInput.className = 'edit-input';
                TCInput.setAttribute('oninput', 'validateTC(this)'); // oninput özelliğini ekle

                var phoneNumberInput =  document.createElement('input');
                phoneNumberInput.type = 'text';
                phoneNumberInput.value = phoneNumber;
                phoneNumberInput.className = 'edit-input';
                phoneNumberInput.setAttribute('oninput', 'validatePhoneNumber(this)'); // oninput özelliğini ekle
                
                newCell2.setAttribute('oninput', 'validateTC(this)');
                newCell4.setAttribute('oninput', 'validatePhoneNumber(this)');
                newCell1.setAttribute('contenteditable', 'false');
                newCell2.setAttribute('contenteditable', 'false');
                newCell4.setAttribute('contenteditable', 'false');
                newCell3.innerHTML = "<i class='fa-solid fa-turn-up tumu-btn'></i>";

                newCell1.appendChild(userNameInput);
                newCell2.appendChild(TCInput);
                newCell4.appendChild(phoneNumberInput);

                newRow.appendChild(newCell3);
                newRow.appendChild(newCell1); // Yeni hücreleri yeni satıra ekle
                newRow.appendChild(newCell2);
                newRow.appendChild(newCell4);
                newRow.appendChild(newTextCell);
                newRow.appendChild(newCell6);

                // Yeni satırı ekleyeceğimiz referans satırı bul
                var referenceRow = document.querySelector('[data-userid="' + userID + '"]');

                referenceRow.parentNode.insertBefore(newRow, referenceRow); // Yeni satırı referans satırının üstüne ekle
                emptyRowCreated[userID] = true; // Boş satır oluşturulduğunu işaretle

                newCell3.querySelector('.tumu-btn').addEventListener('click', function () {
                    // Tıklanan düğmeye ait kullanıcıya ait satırları göster/gizle
                    var rows = document.querySelectorAll('[id^="tr-' + userID + '"]');
                    rows.forEach(function (item) {
                        if (item.style.display === 'none') {
                            item.style.display = 'table-row'; // Eğer gizli ise görünür yap
                            item.classList.add('open-tr');
                            this.classList.add('active-tumu');
                            newCell3.parentNode.classList.add('git-ac-active');
                        } else {
                            item.style.display = 'none'; // Eğer görünür ise gizle
                            this.classList.remove('active-tumu');
                            item.classList.remove('open-tr');
                            newCell3.parentNode.classList.remove('git-ac-active');
                        }
                    }, this);
                });
            }
        } else {
            userIdArray[userID] = true;
        }
    });
</script>

<!-- table dropdown area end -->
<!-- ============================== -->

<script type="text/javascript">
    var selectedValuesArray = [];
    var selectedDurumArray = [];
    var sayac = 0;


    function newDaire() {
            // Seçilen değeri al
            var optionsElement = document.getElementById("daireGrup");
            var selectedValue = optionsElement ? optionsElement.value : null;

        var optionsDurum = document.getElementById("durum");
        var selectedDurum = optionsDurum ? optionsDurum.value : null;
        
        selectedValuesArray.push(selectedValue);
        selectedDurumArray.push(selectedDurum);
        // Yeni bir ana div oluştur
        var newContainer = document.createElement('div');
        newContainer.className = 'daire-container';

        // Yeni <div> elementini oluştur
        var newDaire = document.createElement('div');
        newDaire.className = 'daire';
        newDaire.innerHTML = selectedValue;
        //durum için div oluşturuldu.
        var newDurum = document.createElement('div');
        newDurum.className = 'durum';
        newDurum.innerHTML = selectedDurum;

        if (selectedDurum == "katMaliki") {
            newDurum.innerHTML = "Kat Maliki";
        } else if (selectedDurum == "kiraci") {
            newDurum.innerHTML = "Kiracı";
        }

        //durum için div oluşturuldu.
        var sil = document.createElement('button');
        sil.className = 'sil blok-ico color-red';
        sil.id = "demo" + sayac;
        sil.innerHTML = '<i class="fa-solid fa-trash"></i>';
        sil.addEventListener('click', function () {
            newContainer.remove(); // newContainer'ı sil
            var index = parseInt(this.id.replace('demo', ''), 10);
            selectedValuesArray.splice(index, 1); // selectedValuesArray'den ilgili elemanı sildaire_id
            selectedDurumArray.splice(index, 1); // selectedDurumArray'den ilgili elemanı sil
            sayac--;
        });

        // Yeni div'leri ana div içerisine ekle
        newContainer.appendChild(newDaire);
        newContainer.appendChild(newDurum);
        newContainer.appendChild(sil); // sil butonunu ekleyin

        // Oluşturulan ana div'i belirli bir alana ekleyin (indexAdd)
        var indexAddElement = document.querySelector('.indexAdd');
        indexAddElement.appendChild(newContainer);
        closeDaire();

        sayac++;
    }

    function toggleAll(masterCheckbox) {

        var checkboxes = document.getElementsByClassName('check1');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = masterCheckbox.checked;
        }
        if (masterCheckbox.checked) {
            $('#silButton').css('display', 'inline-block');
            $('.git-ac').addClass('git-ac-color');
        } else if (!masterCheckbox.checked) {
            $('#silButton').css('display', 'none');
            $('.git-ac').removeClass('git-ac-color');
        }
    }

    function toggleCheckbox(id, i) {
        var checkboxes = document.querySelectorAll('.check1'); // Tüm checkboxları al
        var guncelleButton = document.getElementById('guncelleButton');
        var silButton = document.getElementById('silButton');
        var enAzBirSecili = false;

        checkboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                enAzBirSecili = true;
            }
        });

        if (enAzBirSecili) {
            silButton.style.display = 'inline-block';
        } else {
            silButton.style.display = 'none';
        }

        var checkbox2 = document.getElementById('check-' + id + '-' + i);

        if (checkbox2.checked) {
            $('#tr-' + id + '-' + i).addClass('git-ac-color');
        } else {
            $('#tr-' + id + '-' + i).removeClass('git-ac-color');
        }
    }

    // Herhangi bir alt checkbox işaret kaldırıldığında, "Hepsini Seç" kutusunu kaldırır
    var checkboxes = document.getElementsByClassName('check1');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('change', function () {
            var allChecked = true;
            for (var j = 0; j < checkboxes.length; j++) {
                if (!checkboxes[j].checked) {
                    allChecked = false;
                    break;
                }
            }
            document.getElementById('mainCheckbox').checked = allChecked;
        });
    }


    $('.adduser').click(function () {
        $('#popup').show().css('display', 'flex').delay(100).queue(function (next) {
            $('body').css('overflow', 'hidden');
            $('#popup').css('opacity', '1');
            $('#userForm').css('opacity', '1');
            $('#userForm').css('transform', 'translateY(0)');
            next();
        });
    });

    function closePopup() {
        $('#userForm').css('opacity', '0').css('transform', 'translateY(-180px)').delay(100).queue(function (next) {
            $('#popup').css('opacity', '0').delay(300).queue(function (nextInner) {
                $(this).hide().css('display', 'none');
                nextInner();
                $('body').css('overflow', 'auto');
            });
            next();
        });
    }

    $('.toplu').click(function () {
        $('#topluPopup').show().css('display', 'flex').delay(100).queue(function (next) {
            $('body').css('overflow', 'hidden');
            $('#topluPopup').css('opacity', '1');
            $('#userForm2').css('opacity', '1');
            $('#userForm2').css('transform', 'translateY(0)');
            next();
        });
    });

    function closeToplu() {
        $('#userForm2').css('opacity', '0').css('transform', 'translateY(-180px)').delay(100).queue(function (next) {
            $('#topluPopup').css('opacity', '0').delay(300).queue(function (nextInner) {
                $(this).hide().css('display', 'none');
                nextInner();
                $('body').css('overflow', 'auto');
            });
            next();
        });
    }

    $('.daireEkle').click(function () {
        $('#dairePopup').show().css('display', 'flex').delay(100).queue(function (next) {
            $('body').css('overflow', 'hidden');
            $('#dairePopup').css('opacity', '1');
            $('#userForm1').css('opacity', '1');
            $('#userForm1').css('transform', 'translateY(0)');
            next();
        });
    });

    function closeDaire() {
        $('#userForm1').css('opacity', '0').css('transform', 'translateY(-180px)').delay(100).queue(function (next) {
            $('#dairePopup').css('opacity', '0').delay(300).queue(function (nextInner) {
                $(this).hide().css('display', 'none');
                nextInner();
                $('body').css('overflow', 'auto');
            });
            next();
        });
    }
    //burası her data-userid değeri değiştiğinde altına çizgi koyar //
    var trElements = document.querySelectorAll('tr.git-ac');
    for (var i = 0; i < trElements.length; i++) {
        if (trElements[i].dataset.userid !== trElements[i + 1]?.dataset.userid) {
            trElements[i].style.borderBottom = '2px solid #ebebeb';
        }
    }

    //kısıtlama ile ilgili fonksiyonlar başlangıç...
    function validateFullName(userName) {
        const regex = /^[A-Za-zÇçĞğİıÖöŞşÜü\s]+$/;
        return regex.test(userName);
        event.preventDefault(); // Formun gönderimini engelle
    }

    function kisitlamalar(userName) {
        if (userName.length < 3) {
            alert('Full Name en az 3 karakter olmalıdır.');
            return;
        }
        if (userName.length > 100) {
            alert('Full Name 100den fazla karakter olamaz.');
            return;
        }
        return true;
    }

    //kısıtlama ile ilgili fonksiyonlar bitiş...
    //var toplusil 
    var topluGuncelleButtons = document.querySelectorAll('.topluGuncelle');

    topluGuncelleButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var rows = document.querySelectorAll('#example tbody tr.git-ac:not(.none)');
            rows.forEach(function (row) {
                var userID = row.getAttribute('data-userid');
                var userName = row.querySelector('td:nth-child(2) input').value.trim();
                var tc = row.querySelector('td:nth-child(3) input').value.trim();
                var phoneNumber = row.querySelector('td:nth-child(4) input').value.trim();
                $.ajax({
                    url: 'Controller/Accounts/update_user.php',
                    type: 'POST',
                    data: {
                        userID: userID,
                        userName: userName,
                        tc: tc,
                        phoneNumber: phoneNumber
                    },
                    success: function (response) {
                        if (response == 1) {
                            location.reload();
                        }
                    },
                    error: function (error) {
                        console.error('Gönderim hatası:', error);
                    }
                });
            });
        });
    });
    // Toplu silme işlemi için butonları seç
    var topluSilButton = document.getElementById('silButton');

    // Silme işlemi butonuna tıklanınca bu fonksiyon çalışacak
    topluSilButton.addEventListener('click', function () {
        var guncelleButton = document.getElementById('guncelleButton');
        var silButton = document.getElementById('silButton');
        var checkboxes = document.querySelectorAll('#example tbody input[type="checkbox"]:checked');

        checkboxes.forEach(function (checkbox) {
            var row = checkbox.closest('tr');
            var userID = row.getAttribute('data-userid');
            var durum = row.querySelector('td[data-title="Durum"]').textContent;

            var blok_ve_daire = row.querySelector('td[data-title="Blok Adi"]').textContent;
            // Blok adı ve daire sayısını ayırmak için "/" işaretine göre ayırın
            var blok_ve_daire_parts = blok_ve_daire.split("/");
            if (blok_ve_daire_parts.length === 2) {
                var blok_adi = blok_ve_daire_parts[0].trim();
                var daire_sayisi = blok_ve_daire_parts[1].trim();
                //alert(userID + ", " + durum + ", " + blok_adi + ", " + daire_sayisi);
            } else {
                var blok_adi = null;
                var daire_sayisi = null;
                console.error("Blok Adi hücresi beklenen formatta değil.");
            }

            // Sunucuya silme isteği gönder
            $.ajax({
                url: 'Controller/Accounts/batchupdate.php',
                type: 'POST',
                data: {
                    userID: userID,
                    blok_adi: blok_adi,
                    daire_sayisi: daire_sayisi,
                    durum: durum
                },
                success: function (response) {
                    if (response == 1) {
                        row.remove();
                        if (document.querySelector('[id^="tr-' + userID + '"]') == null) {
                            $.ajax({
                                url: 'Controller/Accounts/delete_user.php',
                                type: 'POST',
                                data: {
                                    userID: userID
                                },
                                success: function (deleteResponse) {
                                    location.reload();
                                },
                                error: function (deleteError) {
                                    console.error('Silme hatası:', deleteError);
                                }
                            });
                        }
                    }
                },
                error: function (error) {
                    console.error('Silme hatası:', error);
                }
            });
        });
        guncelleButton.style.display = 'none';
        silButton.style.display = 'none';
    });


    // Tüm tablo satırlarını seç
    const tableRows = document.querySelectorAll('tr.git-ac');

    // Verileri saklamak için boş bir dizi oluştur
    const rowData = [];
    // Her bir satırı dolaşarak verileri al
    tableRows.forEach(row => {
        const blockName = row.querySelector('td:nth-child(5)').textContent.trim(); // Blok Adı
        let block = '';
        let flatCount = '';
        let status = '';

        // Blok adı uygun şekilde ayrıştırılabiliyorsa işlem yap
        if (blockName.includes('/')) {
            block = blockName.split('/')[0].trim();
            flatCount = blockName.split('/')[1].trim();
        }

        // Durumu uygun şekilde alabiliyorsanız işlem yap
        const statusElement = row.querySelector('td:nth-child(6) .main-durum');
        if (statusElement) {
            status = statusElement.textContent.trim();
            if (status === "kat Maliki") {
                status = "Kat Maliki";
            } else if (status === "kiracı") {
                status = "kiraci";
            }
        }

        // Verileri obje olarak diziye ekle
        rowData.push({
            block: block,
            flatCount: flatCount,
            status: status
        });

        // console.log(JSON.stringify(rowData, null, 2));
    });

    var demo = 0;
    
    //bakılacak
    //var saveButton = document.getElementById('saveButton');
    $(document).ready(function() {
        var selectedGender = null;
        var selectedOdemeDurumu = null;

        $('.genderButton').click(function() {
            selectedGender = $(this).data('user-id');
            console.log("Selected gender: " + selectedGender);
        });
        $('.odemeButton').click(function() {
            selectedOdemeDurumu = $(this).data('odeme-durumu');
            console.log("Selected ödeme durumu: " + selectedOdemeDurumu);
        });
    $('#saveButton').click(function() {
        // Form verilerini topla
        var formData = {
            userName: $('input[name="userName"]').val(),
            tc: $('input[name="tc"]').val(),
            phoneNumber: $('input[name="phoneNumber"]').val(),
            userEmail: $('input[name="userEmail"]').val() || null,
            plate: $('input[name="plate"]').val(),
            gender: selectedGender,
            password: $('#userPass').val(),
            openingBalance: $('input[name="openingBalance"]').val() || null,
            balanceStatus: selectedOdemeDurumu,
            promise: $('input[name="promise"]').val(),
            blokArray: getBlockArray(), // Blok dizisini al
            durumArray: getDurumArray() // Durum dizisini al
        };
        // console.log("Form Verileri:");
        // console.log("User Name:", formData.userName);
        // console.log("TC:", formData.tc);
        // console.log("Phone Number:", formData.phoneNumber);
        // console.log("User Email:", formData.userEmail);
        // console.log("Plate:", formData.plate);
        // console.log("Gender:", formData.gender);
        // console.log("Password:", formData.password);
        // console.log("Opening Balance:", formData.openingBalance);
        // console.log("Balance Status:", formData.balanceStatus);
        // console.log("Promise:", formData.promise);
        console.log("Block Array:", formData.blokArray);
        // console.log("Durum Array:", formData.durumArray);

        // Şifre kontrolleri
        if (!formData.password) {
            alert("Şifre kısmı boş bırakılamaz");
            return;
        } else if (formData.password.length < 6) {
            alert("Şifre kısmı 6 karakterden az olamaz.");
            return;
        }

        // Çakışma kontrolü ve işlemler
        checkConflict(formData, function(isConflict, lastBlock, lastFlotCount, lastDurum) {
            if (isConflict) {
                if (confirm(`Çakışma durumu bulundu: Blok ismi: ${lastBlock}, Daire sayısı: ${lastFlotCount}, Durum: ${lastDurum}. Bu dairede oturan kullanıcıyı silmek ister misiniz?`)) {
                    if (kisitlamalar(formData.userName /* tc, phoneNumber, userEmail, plate */)) {
                        saveUserData(formData);
                        arsiveUser();
                    }
                }
            } else {
                if (kisitlamalar(formData.userName /* tc, phoneNumber, userEmail, plate */)) {
                    saveUserData(formData);
                }
            }
        });
    });

    function getBlockArray() {
    // Blok dizisini oluştur
    var blokArray = [];
    selectedValuesArray.forEach(function(element) {
        // "blok" kelimesini bul ve öncesindeki kısmı al
        var blokIndex = element.toLowerCase().indexOf("blok");
        var letterPart = blokIndex > -1 ? element.substring(0, blokIndex).trim() : '';
        
        // Sayı kısmını ayır
        var match = element.match(/\d+/);
        var numberPart = match ? match[0] : null;
        
        blokArray.push({ letter: letterPart, number: numberPart });
    });
    return blokArray;
}


    function getDurumArray() {
        // Durum dizisini oluştur
        var durumArray = [];
        selectedDurumArray.forEach(function(durum) {
            durum.split(',').forEach(function(d) {
                durumArray.push(d);
            });
        });
        return durumArray;
    }

    function checkConflict(formData, callback) {
        var isConflict = false;
        var lastBlock, lastFlotCount, lastDurum;
        
        rowData.forEach(function(row) {
            var block = row.block;
            var flatCount = row.flatCount;
            var status = row.status;

            formData.blokArray.forEach(function(blokElement) {
                if (block === blokElement.letter && flatCount === blokElement.number) {
                    lastBlock = blokElement.letter;
                    lastFlotCount = blokElement.number;
                    formData.durumArray.forEach(function(durum) {
                        lastDurum = durum;
                        if (status === durum) {
                            isConflict = true;
                        }
                    });
                }
            });
        });
        
        callback(isConflict, lastBlock, lastFlotCount, lastDurum);
    }
    function saveUserData(formData) {
        $.ajax({
            url: 'Controller/Accounts/save_user.php',
            type: 'POST',
            data: {
                userName: formData.userName,
                tc: formData.tc,
                phoneNumber: formData.phoneNumber,
                userEmail: formData.userEmail,
                gender: formData.gender,
                plate:formData.plate,
                password: formData.password,
                openingBalance: formData.openingBalance,
                balanceStatus: formData.balanceStatus,
                promise: formData.promise,
                blokArray: JSON.stringify(formData.blokArray),
                durumArray: JSON.stringify(formData.durumArray)
            },
            success: function(response) {
                alert("Kullanıcı ve daire bilgileri başarıyla güncellendi.");
                location.reload();
            },
            error: function(error) {
                console.error("AJAX hatası: ", error);
            }
        });
    }
});

    function arsiveUser() {
        demo = 0;
        $.ajax({
            url: 'Controller/Accounts/arsiveUser.php',
            type: 'POST',
            data: {},
            success: function (arsiveResponse) {
                alert(arsiveResponse);
                location.reload();
            },
            error: function (secondError) {
                console.error(secondError);
            }
        });
    }

    var checkEdit = true;
    // Checkbox durumuna göre düzenleme fonksiyonlarını etkinleştirme veya devre dışı bırakma

    /* Yeni Düzenleme Alanı (Ben ekledim fatih ama problemler olabilir) (ben == yusuf) */
    document.addEventListener('DOMContentLoaded', () => {
        const editToggle = document.getElementById('editToggle');
        
        // editToggle checkbox'ının durumunu kontrol et ve uygun fonksiyonu çağır
        editToggle.addEventListener('change', () => {
            if (editToggle.checked) {
                checkEdit = false;
                okuma();
            } else {
                iptal();
            }
        });
    });

    function okuma() {
    // Tüm .edit-input öğelerine "active" sınıfını ekle
    const allRows = document.querySelectorAll('.users-table tbody tr');
    const processedUserIDs = new Set();

    allRows.forEach(row => {
        const userID = row.getAttribute('data-userid');

        if (!processedUserIDs.has(userID)) {
            // İlk kez karşılaşılan userID, sadece bu satırın .edit-input öğelerine sınıf ekle
            const elements = row.querySelectorAll('.edit-input');
            elements.forEach(element => {
                element.classList.add('activeEdit');
            });
            processedUserIDs.add(userID);
        }
    });

    // Tüm tablo satırlarına "active" sınıfını ekle 
    allRows.forEach(row => {
        row.classList.add('activeEdit');
    });

    // .table_td sınıfındaki tüm öğelere cursor: inline ekle
    const tableTdElements = document.querySelectorAll('.table_td');
    tableTdElements.forEach(element => {
        element.style.cursor = 'inherit';
    });

    // Butonu görünür yap
    const guncelleButton = document.getElementById('guncelleButton');
    guncelleButton.style.display = 'block';
}

function iptal() {
    // .edit-input öğelerini seç ve "activeEdit" sınıfını kaldır
    const elements = document.querySelectorAll('.edit-input');
    elements.forEach(element => {
        element.classList.remove('activeEdit');
    });

    // Tüm tablo satırlarından "activeEdit" sınıfını kaldır
    const allRows = document.querySelectorAll('.users-table tbody tr');
    allRows.forEach(row => {
        row.classList.remove('activeEdit');
    });

    // .table_td sınıfındaki tüm öğelere cursor: pointer ekle
    const tableTdElements = document.querySelectorAll('.table_td');
    tableTdElements.forEach(element => {
        element.style.cursor = 'pointer';
    });

    // Butonu görünmez yap
    const guncelleButton = document.getElementById('guncelleButton');
    guncelleButton.style.display = 'none';

    location.reload();
}


/* ======================================================== */





    // filtreleme search ile
    function filtrele() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchValue");
        filter = input.value.toUpperCase();
        table = document.getElementById("example");
        tr = table.getElementsByTagName("tr");

        // Her satırı kontrol et
        for (i = 0; i < tr.length; i++) {
            // İlk satır başlıksa atla
            if (tr[i].getElementsByTagName("th").length > 0) {
                continue;
            }
            // Her hücreyi kontrol et
            var display = false;
            td = tr[i].getElementsByTagName("td");
            for (var j = 0; j < td.length; j++) {
                if (td[j]) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        display = true;
                        break;
                    }
                }
            }
            // Eğer filtre metni herhangi bir hücrede bulunuyorsa, satırı göster; aksi takdirde gizle
            if (display) {
                tr[i].style.display = "";
                tr[i].querySelector('.check-style input[type="checkbox"]').classList.add('check1');


            } else {
                tr[i].style.display = "none";
                tr[i].querySelector('.check-style input[type="checkbox"]').classList.remove('check1');


            }
        }
    }
    var tableTdElements = document.querySelectorAll('.table_td');

    tableTdElements.forEach(function (element) {
        element.addEventListener('click', function () {

            var trId = element.parentElement.getAttribute('data-userid');
            var dId = element.parentElement.getAttribute('data-d');
            var d = "user";


            $.ajax({
                url: 'Controller/create_session.php',
                type: 'POST',
                data: {
                    id: trId,
                    dId: dId,
                    d: d,
                },
                success: function (response) {
                    if (response && checkEdit) {
                        window.location.href = "index.php?parametre=custom";
                    }
                },
                error: function (xhr, status, error) {
                    var errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Hata alındı: ' + errorMessage);
                }
            });
        });
    });
</script>

<!-- Excel Icin Dosya Secme Script i -->

<script>
    const actualBtn = document.getElementById('excel_file');

    const fileChosen = document.getElementById('file-chosen');

    actualBtn.addEventListener('change', function () {
        fileChosen.textContent = this.files[0].name
    })
</script>



<script src="assets/js/mycode/dropdown.js"></script>
<script>
    
    dropDownn('gender', 'genderDp', 'searchInput3');
    dropDownn('odemeDurumu', 'odemeDurumuDP', 'odemeSearch');
    dropDownn('daireGrup', 'daireGrupDP', 'daireSearchInput');  
    dropDownn('durum', 'durumDP', 'durumSearch');  
</script>

<!-- secme Tarihi -->
<script src="assets/js/mycode/moment.min.js"></script>
    <script src="assets/js/mycode/moment.js"></script>
    <script src="assets/js/mycode/lightpick.js"></script>

<script>
 // yeni eklenen kısım
moment.locale('tr', {
    months : [
        "Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", 
        "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"
    ],
    monthsShort : [
        "Oca", "Şub", "Mar", "Nis", "May", "Haz", 
        "Tem", "Ağu", "Eyl", "Eki", "Kas", "Ara"
    ],
    weekdays : [
        "Pazar", "Pazartesi", "Salı", "Çarşamba", "Perşembe", "Cuma", "Cumartesi"
    ],
    weekdaysShort : [
        "Paz", "Pzt", "Sal", "Çar", "Per", "Cum", "Cmt"
    ],
    weekdaysMin : [
        "Pz", "Pt", "Sa", "Ça", "Pe", "Cu", "Ct"
    ],
    longDateFormat : {
        LT : "HH:mm",
        LTS : "HH:mm:ss",
        L : "DD/MM/YYYY",
        LL : "D MMMM YYYY",
        LLL : "D MMMM YYYY HH:mm",
        LLLL : "dddd, D MMMM YYYY HH:mm"
    }
});

function tarihSec(veri, day) {
    var dateFormat = 'DD MMMM YYYY';
    var picker = new Lightpick({
        field: document.getElementById(veri),
        singleDate: true,
        selectForward: true,
        selectBackward: false,
        lang: 'tr',
        minDate: moment(),
        repick: true,
        startDate: moment().add(day, 'days'),
        onSelect: function(date) {
            document.getElementById(veri).value = date.format(dateFormat);
            document.getElementById(veri).setAttribute('data-user-id',  date.format("YYYY-MM-DD"));
        }
      
    });

    // Başlangıç tarihini input alanına yazdır
    document.getElementById(veri).value = moment().add(day, 'days').format(dateFormat);
    document.getElementById(veri).setAttribute('data-user-id',  moment().add(day, 'days').format("YYYY-MM-DD"));
}

// Fonksiyonları çağırma
tarihSec('datepickerAcilis', 0);

    </script>