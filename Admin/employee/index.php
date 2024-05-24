<?php
try {
    $sql2 = "SELECT * 
    FROM tbl_employed
    WHERE apartman_id = " . $_SESSION["apartID"] . " AND arsive=0
    ORDER BY userID ASC";

    $stmt = $conn->prepare($sql2);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //contenteditable="true"
        ?>
<style>
.hidden {
    display: none;
}
</style>
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
                <th onclick="sortTable(3)">Email<i id="icon-table3" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(4)">Görevi<i id="icon-table4" class="fa-solid fa-sort-down"></i></th>
            </tr>
        </thead>
        <tbody>

            <?php
                    $i = 0;
                    foreach ($result as $row) {
                        $i++;
                        ?>
            <tr data-userid="<?php echo $row["userID"]; ?>"
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
                    <?php echo $row["fullName"]; ?>
                </td>

                <td data-title="Telefon Numarası" class="table_tt table_td phoneNumberTable" contenteditable="false">

                    <?php echo $row["phoneNumber"]; ?>
                </td>

                <td data-title="Email" class="table_tt table_td email" contenteditable="false">
                   <?php echo $row["userEmail"]; ?>
                </td> 

                <td data-title="Task" class="table_tt table_td Task" contenteditable="false">
                   <?php echo $row["task"]; ?>
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

    <form class="login-form" id="userForm">

        <h2 class="form-signin-heading">personel Ekleme</h2>

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
            <div class="col-md-6 col margint mt-0">
                <div class="select-div">
                    <input class="search-selectx input" type="text" list="Users" id="userInput" required="" />
                    <label class="selectx-label" for="userInput" for="gender">Cinsiyet :</label>
                    <ul class="value-listx" id="userInputDrop">
                        <li class="li-select" data-user-id="Erkek">Erkek</li>
                        <li class="li-select" data-user-id="Kadin">Kadın</li>
                    </ul>
                </div>
            </div>

            <div class="col-md-6 col margint mt-0">
                <div class="select-div">
                    <input class="search-selectx input" type="text" list="Users" id="educationStatus" name="educationStatus" required="" />
                    <label class="selectx-label" for="educationStatus" for="gender">Öğrenim Durumu :</label>
                    <ul class="value-listx" id="educationStatusDrop">
                    <li class="li-select" data-user-id="ilkokul">ilkokul</li>
                    <li class="li-select" data-user-id="ortaokul">ortaokul</li>
                    <li class="li-select" data-user-id="lise">lise</li>
                    <li class="li-select" data-user-id="üniversite">üniversite</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col margint">
                <input class="input" type="text" id="iban" name="iban" maxlength="28" oninput="addTRPrefix(this)" required="" />
                <label for="iban">Iban</label>
            </div>
            <!-- labela Bakilicak Kutuphane ile Yapilicak -->
            <div class="col-md-6 col margint">
                <input class="input" type="date" name="startingWorking" required="">
                <label for="startingWorking">İşe Giriş Tarihi</label>
            </div>
        </div>

        <div class="row">
            <!-- burayı beraber konuşmamız gerekiyor. -->
            <div class="col-md-6 col margint">
                <input class="input" type="text" name="task" required="">
                <label for="task">Görevi</label>
            </div>

            <div class="col-md-6 col margint">
                <input class="input" type="text" name="sigortaNo" required="">
                <label for="sigortaNo">Sigorta No</label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col margint">
                <input class="input" type="text" name="salary" required="">
                <label for="salary">Maaş</label>
            </div>
            <div class="col-md-6 col margint mt-0">
                <div class="select-div">
                    <input class="search-selectx input" type="text" list="Users" id="unit" required="" />
                    <label class="selectx-label" for="unit" for="gender">Brim :</label>
                    <ul class="value-listx" id="unitDrop">
                        <li class="li-select" data-user-id="tl">TL (₺)</li>
                        <li class="li-select" data-user-id="euro">EURO (€)</li>
                        <li class="li-select" data-user-id="dolar">DOLAR ($)</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- buraya bak yusuf bunlara css atılacak -->
        <div class="row">
            <div class="col-md-6 check-label margint">
                <input onchange="toggleDisplay()" type="checkbox" id="onay" name="onay" value="bakiye">
                <label for="onay"> Açılış Bakiyesi Ekleme</label>
            </div>
        </div>

        <div class="additional-fields hidden">
            <div class="row">
                <div class="col-md-6 col margint">
                    <input class="input" type="text" name="openingBalance" required="">
                    <label for="openingBalance">Açılış Bakiyesi</label>
                </div>

                <div class="col-md-6 col margint">
                    <div class="select-div m-0">
                        <input class="search-selectx input" type="text" list="Users" id="userInput-bakiye" required="" />
                        <label class="selectx-label" for="userInput-bakiye" for="gender">Durum :</label>
                        <ul class="value-listx" id="userInputDrop-bakiye">
                            <li class="li-select" data-user-id="Borç">Borç</li>
                            <li class="li-select" data-user-id="Alacak">Alacak</li>
                        </ul>
                    </div>
                    <!-- fatih burdaki selecti iptal ettim yeni select bu yukardaki -->
                    <!-- <select name="balanceType">
                        <option value=""></option>
                        <option value="Borç">Borç</option>
                        <option value="Alacak">Alacak</option>
                    </select> -->
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-btn margint">
                    <input class="input" type="date" name="promise" required="">
                </div>
            </div>
        </div>
        <!-- buraya kadar -->
        <input class="input" type="text" name="apartman_id" value=<?php echo $_SESSION["apartID"]; ?> hidden>

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
                <a class="ahref btn-custom-daire w-100" href="index?parametre=TopluPersonel">Toplu Personel Ekleme</a>
                <a class="ahref btn-custom-daire w-100" href="Controller/Employeed/excelCreate.php" id="excelDownload" download="PersonelEkle.xlsx">Excel İndir</a>
                <p class="text-left">Excel İle Kullanıcı Ekleme:</p>
                <div class="upload-box">
                    <input type="file" id="excel_file" accept=".xlsx" hidden>
                    <label for="excel_file" class="file_label">Dosya Seçin</label>
                    <!-- name of file chosen -->
                    <span id="file-chosen"></span>

                    <button id="upload_btn">Gönder</button>
                </div>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        toggleExportButton();
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<script>
    document.getElementById("exportButton").addEventListener("click", function() {
        let table = document.getElementById("example");
        let rows = table.querySelectorAll("tr");
        let data = [];
        rows.forEach((row, rowIndex) => {
            let cols = row.querySelectorAll("td, th");
            let rowData = [];
            cols.forEach((col, colIndex) => {
                if (colIndex !== 0) { // İlk sütunu atla
                    rowData.push(col.innerText.trim());
                }
            });
            data.push(rowData);
        });

        let wb = XLSX.utils.book_new();
        let ws = XLSX.utils.aoa_to_sheet(data);

        // Hücre stillerini tanımlama
        const headerCellStyle = {
            font: { bold: true, color: { rgb: "FFFFFF" } },
            fill: { fgColor: { rgb: "000000" } },
            alignment: { horizontal: "center", vertical: "center" }
        };

        const dataCellStyle = {
            alignment: { horizontal: "center", vertical: "center" }
        };

        // Stil uygulama
        let range = XLSX.utils.decode_range(ws['!ref']);
        for (let rowNum = range.s.r; rowNum <= range.e.r; rowNum++) {
            for (let colNum = range.s.c; colNum <= range.e.c; colNum++) {
                let cellAddress = { c: colNum, r: rowNum };
                let cellRef = XLSX.utils.encode_cell(cellAddress);
                if (!ws[cellRef]) continue; // hücre boşsa geç
                if (rowNum === 0) { // Başlık satırlarına stil uygula
                    ws[cellRef].s = headerCellStyle;
                } else { // Veri satırlarına stil uygula
                    ws[cellRef].s = dataCellStyle;
                }
            }
        }

        // Sütun genişliklerini ayarlama
        ws['!cols'] = [
            { wpx: 150 }, 
            { wpx: 150 }, 
            { wpx: 150 }, 
            { wpx: 100 }  
        ];

        XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
        XLSX.writeFile(wb, "exported_table.xlsx");
    });
    </script>

<script>
    $(document).ready(function(){
        $('#upload_btn').click(function(){
            var excel_file = $('#excel_file').prop('files')[0];
            var form_data = new FormData();
            form_data.append('excel_file', excel_file);
            
            $.ajax({
                url: 'Controller/Employeed/uploadFiles.php',
                type: 'POST',
                data: form_data,
                contentType: false,
                processData: false,
                success: function(response){
                    alert(response);
                },
                error: function(xhr, status, error){
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
<script>
    //deneme scripti
    function addTRPrefix(input) {
    // Kullanıcının girdiği değeri al
    var ibanValue = input.value.trim();

    // TR ön eki eklemek için kontrol
    if (!ibanValue.startsWith("TR")) {
        // TR ön eki ekle
        ibanValue = "TR" + ibanValue;
        
        // Eğer 28 karakterden fazlaysa, sınırı aşmamak için kırp
        if (ibanValue.length > 28) {
            ibanValue = ibanValue.substring(0, 28);
        }

        // Input değerini güncelle
        input.value = ibanValue;
    }
}
function formatIBAN(input) {
    // Kullanıcının girdiği değeri al
    var ibanInput = document.getElementById("iban");
    var ibanValue = ibanInput.value.trim();

    // Sadece rakamlardan oluşan bir IBAN oluşturmak için kontrol
    var formattedIBAN = ibanValue.replace(/\D/g, ''); // Sadece rakamları tutar

    // IBAN'ı güncelle
    ibanInput.value = formattedIBAN;
}
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
<!-- custom gender input start -->
<script>
function setupSearchSelect(inputSelector, dropdownSelector) {
    const inputField = document.querySelector(inputSelector);
    const dropdown = document.querySelector(dropdownSelector);
    const dropdownArray = [...dropdown.querySelectorAll('.li-select')];
    let valueArray = [];

    inputField.focus();

    dropdownArray.forEach(item => {
        valueArray.push(item.textContent);
    });

    const closeDropdown = () => {
        setTimeout(() => {
            dropdown.classList.remove('open');
        }, 100);
    }

    inputField.addEventListener('input', () => {
        setTimeout(() => {
            dropdown.classList.add('open');
            let inputValue = inputField.value.toLowerCase();
            if (inputValue.length > 0) {
                dropdownArray.forEach((item, j) => {
                    if (!(inputValue.substring(0, inputValue.length) === valueArray[j].substring(0, inputValue.length).toLowerCase())) {
                        dropdownArray[j].classList.add('closed');
                    } else {
                        dropdownArray[j].classList.remove('closed');
                    }
                });
            } else {
                dropdownArray.forEach(item => {
                    item.classList.remove('closed');
                });
            }
        }, 100);
    });

    dropdownArray.forEach(item => {
        item.addEventListener('click', (evt) => {
            setTimeout(() => {
                const selectedUserID = evt.target.dataset.userId;
                inputField.value = item.textContent;
                dropdownArray.forEach(dropdown => {
                    dropdown.classList.add('closed');
                });
            }, 100);
        });
    });

    inputField.addEventListener('focus', () => {
        setTimeout(() => {
            dropdown.classList.add('open');
            dropdownArray.forEach(dropdown => {
                dropdown.classList.remove('closed');
            });
        }, 100);
    });

    inputField.addEventListener('blur', () => {
        setTimeout(() => {
            dropdown.classList.remove('open');
        }, 100);
    });

    document.addEventListener('click', (evt) => {
        setTimeout(() => {
            const isDropdown = dropdown.contains(evt.target);
            const isInput = inputField.contains(evt.target);
            if (!isDropdown && !isInput) {
                dropdown.classList.remove('open');
            }
        }, 100);
    });
}

setupSearchSelect('#userInput', '#userInputDrop');
setupSearchSelect('#educationStatus', '#educationStatusDrop');
setupSearchSelect('#unit', '#unitDrop');
setupSearchSelect('#userInput-bakiye', '#userInputDrop-bakiye');

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
        c.addEventListener("click", function(e) {
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
    a.addEventListener("click", function(e) {
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

rows.forEach(function(row) {
    var userID = row.getAttribute('data-userid');
    var userName = row.querySelector('.table_tt.table_td').textContent;
    var phoneNumber = row.querySelector('.phoneNumberTable').textContent;
    if (userIdArray[userID]) {
        // Tekrarlanan bir kullanıcı kimliği bulunduğunda tüm satırı gizle
        document.querySelectorAll('[id^="tr-' + userID + '"]').forEach(function(item) {
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

            newCell3.querySelector('.tumu-btn').addEventListener('click', function() {
                // Tıklanan düğmeye ait kullanıcıya ait satırları göster/gizle
                var rows = document.querySelectorAll('[id^="tr-' + userID + '"]');
                rows.forEach(function(item) {
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

    checkboxes.forEach(function(checkbox) {
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
    checkboxes[i].addEventListener('change', function() {
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


$('.adduser').click(function() {
    $('#popup').show().css('display', 'flex').delay(100).queue(function(next) {
        $('body').css('overflow', 'hidden');
        $('#popup').css('opacity', '1');
        $('#userForm').css('opacity', '1');
        $('#userForm').css('transform', 'translateY(0)');
        next();
    });
});

function closePopup() {
    $('#userForm').css('opacity', '0').css('transform', 'translateY(-180px)').delay(100).queue(function(next) {
        $('#popup').css('opacity', '0').delay(300).queue(function(nextInner) {
            $(this).hide().css('display', 'none');
            nextInner();
            $('body').css('overflow', 'auto');
        });
        next();
    });
}

$('.toplu').click(function() {
    $('#topluPopup').show().css('display', 'flex').delay(100).queue(function(next) {
        $('body').css('overflow', 'hidden');
        $('#topluPopup').css('opacity', '1');
        $('#userForm2').css('opacity', '1');
        $('#userForm2').css('transform', 'translateY(0)');
        next();
    });
});

function closeToplu() {
    $('#userForm2').css('opacity', '0').css('transform', 'translateY(-180px)').delay(100).queue(function(next) {
        $('#topluPopup').css('opacity', '0').delay(300).queue(function(nextInner) {
            $(this).hide().css('display', 'none');
            nextInner();
            $('body').css('overflow', 'auto');
        });
        next();
    });
}

$('.daireEkle').click(function() {
    $('#dairePopup').show().css('display', 'flex').delay(100).queue(function(next) {
        $('body').css('overflow', 'hidden');
        $('#dairePopup').css('opacity', '1');
        $('#userForm1').css('opacity', '1');
        $('#userForm1').css('transform', 'translateY(0)');
        next();
    });
});

function closeDaire() {
    $('#userForm1').css('opacity', '0').css('transform', 'translateY(-180px)').delay(100).queue(function(next) {
        $('#dairePopup').css('opacity', '0').delay(300).queue(function(nextInner) {
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
    event.preventDefault(); // Formun gönderimini engellfe
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

var demo = 0;

//bakılacak
//var saveButton = document.getElementById('saveButton');
function saveUser() {
    var apartman_id = $('input[name="apartman_id"]').val();
    var userName = $('input[name="userName"]').val();
    var tc = $('input[name="tc"]').val();
    var phoneNumber = $('input[name="phoneNumber"]').val();
    var userEmail = $('input[name="userEmail"]').val() || null;
    var gender = $('input#userInputgender').val();
    var educationStatus = $('input[name="educationStatus"]').val();
    var iban =  $('input[name="iban"]').val();
    var startingWorking = $('input[name="startingWorking"]').val();
    var task = $('input[name="task"]').val();
    var sigortaNo = $('input[name="sigortaNo"]').val();
    var salary = $('input[name="salary"]').val();
    var unit = $('input[name="unit"]').val();
    var openingBalance = $('input[name="openingBalance"]').val() || null;
    var balanceType = $('select[name="balanceType"]').val() || null;
    var promise = $('input[name="promise"]').val() || null;
    /*
    console.log("apartman_id:", apartman_id);
    console.log("userName:", userName);
    console.log("tc:", tc);
    console.log("phoneNumber:", phoneNumber);
    console.log("userEmail:", userEmail);
    console.log("gender:", gender);
    console.log("educationStatus:", educationStatus);
    console.log("iban:", iban);
    console.log("startingWorking:", startingWorking);
    console.log("task:", task);
    console.log("sigortaNo:", sigortaNo);
    console.log("salary:", salary);
    console.log("unit:", unit);
    console.log("openingBalance:", openingBalance);
    console.log("balanceType:", balanceType);
    console.log("promise:", promise);
    */
    saveUserData(apartman_id, userName, tc, phoneNumber, userEmail, gender, educationStatus,
    iban, startingWorking, task, sigortaNo, salary, unit, openingBalance, balanceType, promise);
}

function saveUserData(apartman_id, userName, tc, phoneNumber, userEmail, gender, educationStatus, 
iban, startingWorking, task, sigortaNo, salary, unit, openingBalance, balanceType, promise) {
    $.ajax({
        url: 'Controller/Employeed/employedSave.php',
        type: 'POST',
        data: {
            apartman_id: apartman_id,
            userName: userName,
            tc: tc,
            phoneNumber: phoneNumber,
            userEmail: userEmail,
            gender: gender,
            educationStatus: educationStatus,
            iban: iban,
            startingWorking: startingWorking,
            task: task,
            sigortaNo: sigortaNo,
            salary: salary,
            unit: unit,
            openingBalance: openingBalance,
            balanceType: balanceType,
            promise: promise
        },
        success: function(response) {
            console.log(response);
            if(response == 1){
                location.reload();
            }
        },
        error: function(error) {
            console.error(error);
        }
    });
}

//kısıtlama ile ilgili fonksiyonlar bitiş...
//var toplusil 
var topluGuncelleButtons = document.querySelectorAll('.topluGuncelle');

topluGuncelleButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        var rows = document.querySelectorAll('#example tbody tr.git-ac:not(.none)');
        rows.forEach(function(row) {
            var userID = row.getAttribute('data-userid');
            var fullName = row.querySelector('td:nth-child(2)').textContent.trim();
            var phoneNumber = row.querySelector('td:nth-child(3)').textContent.trim();
            var userEmail = row.querySelector('td:nth-child(4)').textContent.trim();
            var task =  row.querySelector('td:nth-child(5)').textContent.trim();
          $.ajax({
                url: 'Controller/Employeed/employedUpdate.php',
                type: 'POST',
                data: {
                    userID: userID,
                    fullName: fullName,
                    phoneNumber: phoneNumber,
                    userEmail: userEmail,
                    task: task
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    console.error('Gönderim hatası:', error);
                }
            });
        });
    });
});
// Toplu silme işlemi için butonları seç
var topluSilButton = document.getElementById('silButton');
topluSilButton.addEventListener('click', function() {
    var silButton = document.getElementById('silButton');
    var checkboxes = document.querySelectorAll('#example tbody input[type="checkbox"]:checked');

    checkboxes.forEach(function(checkbox) {
        var row = checkbox.closest('tr');
        var userID = row.getAttribute('data-userid');
        $.ajax({
            url: 'Controller/Employeed/arsiveSend.php',
            type: 'POST',
            data: {
                userID: userID
            },
            success: function(response) {
                console.log(response);
                location.reload();
            },
            error: function(error) {
                console.error('Silme hatası:', error);
            }
        });
    });
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


var checkEdit = true;
// Checkbox durumuna göre düzenleme fonksiyonlarını etkinleştirme veya devre dışı bırakma
document.getElementById("editToggle").addEventListener("change", function() {
    if (this.checked) {
        openEdit();
        disableDemoFunction();
        checkEdit = false;
        // Checkbox işaretlendiğinde 2. ve 3. sütunlara "color-new" class'ını ekle
        var trElements = document.querySelectorAll('.git-ac');
        $('#guncelleButton').css('display', 'inline-block');
        trElements.forEach(function(trElement) {
            var tdElements = trElement.querySelectorAll('td:nth-child(2), td:nth-child(3)');
            tdElements.forEach(function(tdElement) {
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
        trElements.forEach(function(trElement) {
            var tdElements = trElement.querySelectorAll('td:nth-child(2), td:nth-child(3)');
            tdElements.forEach(function(tdElement) {
                tdElement.classList.remove('color-new');
            });
        });
    }
});
var initiallyVisibleRows = "";
document.addEventListener("DOMContentLoaded", function() {
    initiallyVisibleRows = document.querySelectorAll('.git-ac:not([style*="display: none"])');
});

function openEdit() {
    initiallyVisibleRows.forEach(function(row) {
        var editableCells = row.querySelectorAll('td[contenteditable="false"]');
        editableCells.forEach(function(cell) {
            cell.setAttribute('contenteditable', 'true');
        });
    });
}


function closeEdit() {
    var editableCells = document.querySelectorAll('td[contenteditable="true"]');
    editableCells.forEach(function(cell) {
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

tableTdElements.forEach(function(element) {
    element.addEventListener('click', function() {

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
            success: function(response) {

                if (response && checkEdit) {
                    window.location.href = "index.php?parametre=custom";
                }
            },
            error: function(xhr, status, error) {
                var errorMessage = xhr.status + ': ' + xhr.statusText;
                alert('Hata alındı: ' + errorMessage);
            }
        });
    });
});
</script>