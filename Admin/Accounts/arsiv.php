<?php

try {

    $sql2 = "SELECT u.userID, u.userName, u.phoneNumber,d.daire_id, b.blok_adi AS blok_adi,u.oldBlock, u.oldNumber, u.oldState, d.daire_sayisi,
    CASE
        WHEN d.katMalikiID = u.userID THEN 'Kat Maliki'
        WHEN d.kiraciID = u.userID THEN 'kiraci'
        ELSE 'Belirtilmemiş'
    END AS durum
    FROM tbl_users u
    LEFT JOIN tbl_daireler d ON u.userID = d.katMalikiID OR u.userID = d.kiraciID
    LEFT JOIN tbl_blok b ON d.blok_adi = b.blok_id
    WHERE arsive = 1 AND rol=3 AND u.apartman_id = " . $_SESSION["apartID"] . "
    ORDER BY u.userID ASC";

    $stmt = $conn->prepare($sql2);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //contenteditable="true"
    if ($result) {
        ?>

        <div class="cener-table">

            <div class="input-group-div">
               <div class="input-group1">

                    <div class="check-box">
                        <div class="custom-checkbox">
                            <input id="editToggle">
                            <label for="editToggle">
                                <div class="status-switch" data-unchecked="kapalı" data-checked="açık"></div>
                            </label>
                        </div>
                    </div >
                </div>
                <div class="input-group1">
                    <button class="topluSil btn-custom-outline bcoc4" id="silButton" style="display: none;">Sil</button>


                    <div class="search-box">
                        <i class="fas fa-search search-icon" aria-hidden="true"></i>
                        <input type="text" class="search-input" id="searchValue" onkeyup="filtrele()" placeholder="Arama...">
                    </div>
                </div>

            </div>

            <hr class="horizontal dark mb-1 w-100">

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
                        <th onclick="sortTable(2)">Telefon Numarası <i id="icon-table2" class="fa-solid fa-sort-down"></i></th>
                        <th onclick="sortTable(3)">Blok / Daire <i id="icon-table3" class="fa-solid fa-sort-down"></i></th>
                        <th onclick="sortTable(4)">Durum <i id="icon-table5" class="fa-solid fa-sort-down"></i></th>
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

                                <?php echo $row["userName"]; ?>
                            </td>

                            <td data-title="Telefon Numarası" class="table_tt table_td phoneNumberTable" contenteditable="false">

                                <?php echo $row["phoneNumber"]; ?>
                            </td>

                            <td data-title="Blok Adi" class="table_tt table_td">
                                <?php
                                if (!empty($row["oldBlock"]) && !empty($row["oldNumber"])) {
                                    echo $row["oldBlock"] . " / " . $row["oldNumber"];
                                }
                                ?>
                            </td>

                            <td data-title="Durum" class="table_tt table_td">
                                <div class="main-durum <?php
                                if ($row["oldState"] == "kiraci") {
                                    echo "kiracı";
                                } elseif ($row["oldState"] == "katMaliki") {
                                    echo "kat Maliki";
                                }
                                ?>">
                                    <?php echo $row["oldState"]; ?>
                                </div>
                            </td>
                        </tr>

                        <?php
                    }
                    ?>


                </tbody>
            </table>

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
    } else {
        ?>

        <div class="cener-table">

            <div class="input-group-div">

                <div class="input-group1">

                    <button class="adduser btn-custom-outline bcoc1">Kullanıcı Ekle</button>
                    <button class="toplu btn-custom-outline bcoc2">Toplu İşlemler</button>

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
                    <button class="topluGuncelle btn-custom-outline bcoc3" id="guncelleButton"
                        style="display: none;">Güncelle</button>
                    <button class="topluSil btn-custom-outline bcoc4" id="silButton" style="display: none;">Sil</button>


                    <div class="search-box">
                        <i class="fas fa-search search-icon" aria-hidden="true"></i>
                        <input type="text" class="search-input" id="searchValue" onkeyup="filtrele()" placeholder="Arama...">
                    </div>
                </div>

            </div>

            <hr class="horizontal dark mb-1 w-100">

            <table id="example" class="users-table">
                <thead>
                    <tr class="users-table-info">
                        <th class="check-style">
                        </th>
                        <th onclick="sortTable(1)">Ad Soyad <i id="icon-table1" class="fa-solid fa-sort-down"></i></th>
                        <th onclick="sortTable(2)">Telefon Numarası <i id="icon-table2" class="fa-solid fa-sort-down"></i></th>
                        <th onclick="sortTable(3)">Blok / Daire <i id="icon-table3" class="fa-solid fa-sort-down"></i></th>
                        <th onclick="sortTable(4)">Durum <i id="icon-table5" class="fa-solid fa-sort-down"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Kullanıcı Bulunamamaktadır</td>
                    </tr>
                </tbody>
            </table>

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
    }
} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
?>

<!-- Popup Form -->
<div id="popup">

    <form class="login-form" id="userForm">

        <h2 class="form-signin-heading">Kullanıcı Ekleme</h2>

        <div class="row mb-1">
            <div class="col-md-6 col">
                <input class="input" type="text" name="userName" required="">
                <label for="userName">Ad Soyad :</label>
            </div>

            <div class="col-md-6 col">
                <input class="input" type="text" name="tc" required="" require>
                <label for="tc">T.C. Kimlik No :</label>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col">
                <input class="input tel" type="number" name="phoneNumber" required="">
                <label for="phoneNumber">Telefon Numarası :</label>
            </div>

            <div class="col-md-6 col">
                <input class="input" type="text" name="userEmail" required="">
                <label for="userEmail">E-Posta :</label>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col margint">
                <input class="input" type="text" name="plate" required="">
                <label for="plate">Araç Plakası</label>
            </div>

            <div class="col-md-6 col">
                <select class="input select-ayar" id="gender" required="">
                    <option style="display: none;" value="" selected disabled></option>
                    <option value="Erkek">Erkek</option>
                    <option value="Kadın">Kadın</option>
                </select>
                <label for="gender">Cinsiyet :</label>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col">
                <input class="input" type="text" name="apartman_id" value=<?php echo $_SESSION["apartID"]; ?> hidden>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-btn">
                <button type="button" class="daireEkle btn-custom-daire">Daire Ata</button>
            </div>
        </div>
        <div class="indexAdd">
        </div>

        <hr class="horizontal dark mt-0 w-100">

        <div class="row row-btn">
            <button type="button" class="btn-custom-close" onclick="closePopup()">Kapat</button>
            <button type="button" class="btn-custom" onclick="saveUser()" id="saveButton">Kaydet</button>
        </div>


    </form>
</div>
<!--buraya toplu hesap eklenmesi için popup eklendi içeriğinin düzenlenmesi lazım-->
<div id="topluPopup">

    <form class="login-form-toplu" id="userForm2" action="">

        <h2 class="form-signin-heading">oluşturma şeklini seçiniz!</h2>

        <div class="row">
            <div class="col-md-12 col-btn mb-0">
                <a class="ahref btn-custom-daire w-100" href="index?parametre=TopluHesap">Toplu Hesap</a>
                <button class="btn-custom-daire w-100" type="button">Excel İle Dışarıdan Aktar</button>
                <!--bakılacak excel-->
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
    <form class="login-form-daire" id="userForm1" action="">

        <h2 class="form-signin-heading">Daire Atama</h2>

        <div class="row w-90">
            <div class="col-btn">
                <select class="input" id="optionsBlok" name="options" required="">
                    <?php echo $optionsBlok; ?>
                </select>
                <label for="options">Daire:</label>
            </div>
            <div class="col-btn">
                <select class="input" id="durum">
                    <option value="katmaliki">kat Maliki</option>
                    <option value="kiraci">kiraci</option>
                </select>
                <label for="durum">Durum :</label>
            </div>
        </div>

        <div class="row row-btn">
            <button type="button" class="btn-custom-close" onclick="closeDaire()">Kapat</button>
            <button type="button" class="btn-custom" id="ekle" onclick="newDaire()">Ekle</button>
        </div>

    </form>
</div>

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
    function sortTable(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("example");
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
        var userName = row.querySelector('.table_tt.table_td').textContent;
        var phoneNumber = row.querySelector('.phoneNumberTable').textContent;
        if (userIdArray[userID]) {
            // Tekrarlanan bir kullanıcı kimliği bulunduğunda tüm satırı gizle
            document.querySelectorAll('[id^="tr-' + userID + '"]').forEach(function (item) {
                item.style.display = 'none';
                item.classList.add('none');
            });

            if (!emptyRowCreated[userID]) {
                var newRow = document.createElement('tr');
                var newCell3 = document.createElement('td');
                var newCell1 = document.createElement('td');
                var newCell2 = document.createElement('td');
                var newCell4 = document.createElement('td');

                var newTextCell = document.createElement('td'); // Yeni metin hücresi oluştur
                newTextCell.textContent = "Birden Fazla Daire"; // Metin içeriğini ayarla

                newRow.classList.add('git-ac');
                newRow.setAttribute('data-userid', userID);
                newCell3.colSpan = "1"; // Üçüncü hücre 1 sütunu kaplasın
                newCell1.colSpan = "1"; // İlk hücre 1 sütunu kaplasın
                newCell2.colSpan = "1"; // İkinci hücre 2 sütunu kaplasın
                newCell4.colSpan = "1"; // Dördüncü hücre 1 sütunu kaplasın

                newCell1.textContent = userName; // İlk hücreye userName değerini ekle
                newCell2.textContent = phoneNumber;
                newCell1.setAttribute('contenteditable', 'false');
                newCell2.setAttribute('contenteditable', 'false');
                newCell3.innerHTML = "<i class='fa-solid fa-turn-up tumu-btn'></i>";

                newRow.appendChild(newCell3);
                newRow.appendChild(newCell1); // Yeni hücreleri yeni satıra ekle
                newRow.appendChild(newCell2);
                newRow.appendChild(newTextCell);
                newRow.appendChild(newCell4);

                // Yeni satırı ekleyeceğimiz referans satırı bul
                var referenceRow = document.querySelector('[data-userid="' + userID + '"]');

                referenceRow.parentNode.insertBefore(newRow,
                    referenceRow); // Yeni satırı referans satırının üstüne ekle
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

        var optionsElement = document.getElementById("optionsBlok");
        var selectedValue = optionsElement.value;

        var optionsDurum = document.getElementById("durum");
        var selectedDurum = optionsDurum.value;

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
                var userName = row.querySelector('td:nth-child(2)').textContent.trim();
                var phoneNumber = row.querySelector('td:nth-child(3)').textContent.trim();
                var arsive = 0;
                console.log(userName);
                $.ajax({
                    url: 'Controller/update_user.php',
                    type: 'POST',
                    data: {
                        userID: userID,
                        userName: userName,
                        phoneNumber: phoneNumber,
                        arsive: arsive
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
                url: 'Controller/batchupdate.php',
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
                                url: 'Controller/delete_user.php',
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
        const blockName = row.querySelector('td:nth-child(4)').textContent.trim(); // Blok Adı
        let block = '';
        let flatCount = '';
        let status = '';

        // Blok adı uygun şekilde ayrıştırılabiliyorsa işlem yap
        if (blockName.includes('/')) {
            block = blockName.split('/')[0].trim();
            flatCount = blockName.split('/')[1].trim();
        }

        // Durumu uygun şekilde alabiliyorsanız işlem yap
        const statusElement = row.querySelector('td:nth-child(5) .main-durum');
        if (statusElement) {
            status = statusElement.textContent.trim();
            if (status === "Kat Maliki") {
                status = "katmaliki";
            } else if (status === "kiraci") {
                status = "kiraci";
            }
        }

        // Verileri obje olarak diziye ekle
        rowData.push({
            block: block,
            flatCount: flatCount,
            status: status
        });

    });

    // Alınan verileri kontrol etmek için konsola yazdır
    console.log(rowData);

    //bakılacak
    //var saveButton = document.getElementById('saveButton');
    function saveUser() {
        var userName = $('input[name="userName"]').val();
        var tc = $('input[name="tc"]').val();
        var phoneNumber = $('input[name="phoneNumber"]').val();
        var userEmail = $('input[name="userEmail"]').val();
        var plate = $('input[name="plate"]').val();
        var gender = $('select#gender').val();
        var apartman_id = $('input[name="apartman_id"]').val();
        var optionsBlok = $('select#optionsBlok').val();
        var blokArray = [];
        var durumArray = [];
        var isConflict = false; // Çakışma durumunu kontrol etmek için bir bayrak
        var arsive = 0;
        //console.log(userName + "," + tc + "," + phoneNumber + "," + userEmail + "," + plate + "," + gender);

        for (var i = 0; i < selectedDurumArray.length; i++) {
            var durumParcalari = selectedDurumArray[i].split(',');

            for (var j = 0; j < durumParcalari.length; j++) {
                durumArray.push(durumParcalari[j]);
            }
        }


        for (var i = 0; i < selectedValuesArray.length; i++) {
            var element = selectedValuesArray[i];
            var match = element.match(/\d+/);
            var letterPart = element.charAt(0);
            var numberPart = match ? match[0] : null;

            /*console.log("element = " + element + ", letterpart = " + letterPart + ", numberpart = " +
                numberPart);*/

            var blokElement = {
                letter: letterPart,
                number: numberPart
            };

            blokArray.push(blokElement);
        }

        for (var i = 0; i < rowData.length; i++) {
            var row = rowData[i];
            var block = row.block;
            var flatCount = row.flatCount;
            var status = row.status;

            // blokArray içindeki blok elementlerini dolaş ve karşılaştır
            for (var j = 0; j < blokArray.length; j++) {
                var blokElement = blokArray[j];
                var letterPart = blokElement.letter;
                var numberPart = blokElement.number;
                // Blok adı ve daire numarası eşleşirse
                if (block == letterPart && flatCount == numberPart) {
                    // DurumArray içindeki durumları dolaş ve karşılaştır
                    for (var k = 0; k < durumArray.length; k++) {
                        var durum = durumArray[k];

                        // Eğer durum eşleşiyorsa 
                        if (status == durum) {
                            // Çakışma durumu olduğunda bayrağı ayarla ve döngüyü kır
                            isConflict = true;
                            break;
                        }
                    }
                }
            }
            // Çakışma durumu varsa uyarı ver

        }
        console.log(isConflict);
        if (isConflict) {
            //alert("Çakışma durumu bulundu: Blok ismi: " + block + ", Daire sayısı: " + flatCount + ", Durum: " + status);
            if (confirm("Çakışma durumu bulundu: Blok ismi: " + block + ", Daire sayısı: " + flatCount + ", Durum: " +
                status + " bu dairede oturan kullanıcıyı silmek ister misin?")) {
                if (kisitlamalar(userName /* tc, phoneNumber, userEmail, plate*/)) {
                    arsive = 1;
                    saveUserData(userName, tc, phoneNumber, durumArray, userEmail, plate, gender, apartman_id, blokArray, arsive);

                } else {
                    return;
                }
            } else {
                return;
            }
        } else {
            if (kisitlamalar(userName /* tc, phoneNumber, userEmail, plate*/)) {
                arsive = 0;
                saveUserData(userName, tc, phoneNumber, durumArray, userEmail, plate, gender, apartman_id, blokArray, arsive);
            } else {
                return;
            }
        }

    };

    function saveUserData(userName, tc, phoneNumber, durumArray, userEmail, plate, gender, apartman_id, blokArray, arsive) {
        $.ajax({
            url: 'Controller/save_user.php',
            type: 'POST',
            data: {
                userName: userName,
                tc: tc,
                phoneNumber: phoneNumber,
                durumArray: JSON.stringify(durumArray),
                userEmail: userEmail,
                plate: plate,
                gender: gender,
                apartman_id: apartman_id
            },
            success: function (response) {
                if (response == 1) {
                    // İkinci AJAX isteği
                    sendData(blokArray, durumArray, arsive);
                }
            },
            error: function (error) {
                console.error(error);
            }
        });
    }

    function sendData(blokArray, durumArray, arsive) {
        $.ajax({
            url: 'Controller/demo.php',
            type: 'POST',
            data: {
                blokArray: JSON.stringify(blokArray),
                durumArray: JSON.stringify(durumArray)
            },
            success: function (secondResponse) {
                if (secondResponse == 1) {
                    arsiveUser(arsive);
                }
            },
            error: function (secondError) {
                console.error(secondError);
            }
        });
    }

    function arsiveUser(arsive) {
        $.ajax({
            url: 'Controller/arsiveUser.php',
            type: 'POST',
            data: {
                arsive: arsive
            },
            success: function (arsiveResponse) {
                if (arsiveResponse == 1) {
                    location.reload();
                }
            },
            error: function (secondError) {
                console.error(secondError);
            }
        });
    }
    /*
    var deleteButtons = document.querySelectorAll('.deleteButton');
    
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var row = this.closest('tr'); // Güncellenen satırı bul
            var userName = row.querySelector('td:nth-child(1)').textContent;
            var tc = row.querySelector('td:nth-child(2)').textContent;
            var phoneNumber = row.querySelector('td:nth-child(3)').textContent;
            var userEmail = row.querySelector('td:nth-child(4)').textContent;
            var userPass = row.querySelector('td:nth-child(5)').textContent;
            var plate = row.querySelector('td:nth-child(6)').textContent;
            var gender = row.querySelector('td:nth-child(7)').textContent;
            var userID = row.getAttribute('data-userid');
            $.ajax({
                url: 'Controller/delete_user.php',
                type: 'POST',
                data: {
                    userID: userID,
                    userName: userName,
                    tc: tc,
                    phoneNumber: phoneNumber,
                    userEmail: userEmail,
                    userPass: userPass,
                    plate: plate,
                    gender: gender
                },
                success: function(response) {
                    if (response == 1) {
                        //alert("güncellendi"+response);
                        location.reload();
                    }
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
    });
    */
    var checkEdit = true;
    // Checkbox durumuna göre düzenleme fonksiyonlarını etkinleştirme veya devre dışı bırakma
    document.getElementById("editToggle").addEventListener("change", function () {
        if (this.checked) {
            openEdit();
            disableDemoFunction();
            checkEdit = false;
            // Checkbox işaretlendiğinde 2. ve 3. sütunlara "color-new" class'ını ekle
            var trElements = document.querySelectorAll('.git-ac');
            $('#guncelleButton').css('display', 'inline-block');
            trElements.forEach(function (trElement) {
                var tdElements = trElement.querySelectorAll('td:nth-child(2), td:nth-child(3)');
                tdElements.forEach(function (tdElement) {
                    tdElement.classList.add('color-new');
                });
            });
        } else {
            closeEdit();
            enableDemoFunction();
            checkEdit = true;
            // Checkbox işaretlenmediğinde 2. ve 3. sütunlardan "color-new" class'ını kaldır
            var trElements = document.querySelectorAll('.git-ac');
            $('#guncelleButton').css('display', 'none');
            trElements.forEach(function (trElement) {
                var tdElements = trElement.querySelectorAll('td:nth-child(2), td:nth-child(3)');
                tdElements.forEach(function (tdElement) {
                    tdElement.classList.remove('color-new');
                });
            });
        }
    });
    var initiallyVisibleRows = "";
    document.addEventListener("DOMContentLoaded", function () {
        initiallyVisibleRows = document.querySelectorAll('.git-ac:not([style*="display: none"])');
    });

    function openEdit() {
        initiallyVisibleRows.forEach(function (row) {
            var editableCells = row.querySelectorAll('td[contenteditable="false"]');
            editableCells.forEach(function (cell) {
                cell.setAttribute('contenteditable', 'true');
            });
        });
    }


    function closeEdit() {
        var editableCells = document.querySelectorAll('td[contenteditable="true"]');
        editableCells.forEach(function (cell) {
            cell.setAttribute('contenteditable', 'false');
        });
    }

    function disableDemoFunction() {


        var tableTds = document.getElementsByClassName("table_tt");
        for (var i = 0; i < tableTds.length; i++) {
            tableTds[i].classList.remove("table_td");
        }
    }

    function enableDemoFunction() {
        /*  var rows = document.querySelectorAll('.git-ac');
          rows.forEach(function(row) {
              row.addEventListener('click', handleClick);
          });*/

        var tableTds = document.getElementsByClassName("table_tt");
        for (var i = 0; i < tableTds.length; i++) {
            tableTds[i].classList.add("table_td");
        }

    }
    /*
    function handleClick(event) {
        var isCheckboxClicked = event.target.tagName === 'INPUT' && event.target.getAttribute('type') === 'checkbox';
    
        if (isCheckboxClicked) {
            event.stopPropagation();
            return;
        }
    
        var userID = this.getAttribute('data-userid');
        window.location.href = 'index.php?parametre=custom&userID=' + encodeURIComponent(userID);
    }  */

    enableDemoFunction();





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