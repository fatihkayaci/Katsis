<!-- Popup Form -->
<div id="popup">

    <form class="login-form mainpopup" id="userForm">

        <h2 class="form-signin-heading mb-3">Kişi Ekle</h2>

        <hr class="horizontal dark mt-0 w-100">

        <div class="row mt-3">
            <div class="col-md-6 col-btn">

                <input type="text" class="input" name="userName" id="userName" required></input>
                <label for="anketSoru">İsim Soyİsim:</label>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-btn group">
                <input class="input" type="text" name="unvan" required>
                <label for="unvan">Unvan:</label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-btn group">
                <input class="input" type="text" name="phoneNumber" required>
                <label for="phoneNumber">Telefon Numarası:</label>
            </div>
        </div>

        <hr class="horizontal dark mt-0 w-100">

        <div class="row row-btn">
            <button type="button" class="btn-custom-close" onclick="closePopup()">Kapat</button>
            <button type="button" class="btn-custom userClr" id="saveButton">Kaydet</button>
        </div>
    </form>
</div>
<?php
try {
    $sql1 = "SELECT * FROM tbl_phone_directory WHERE apartmanID = ". $_SESSION["apartID"] . "
    ORDER BY phoneID ASC";
    
    $stmt = $conn->prepare($sql1);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($result) {
       ?>

<div class="cener-table">

    <div class="input-group-div">

        <div class="input-group1">
            <button class="addAnket btn-custom-outline bcoc1">Kişi Ekle</button>
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
                <input type="text" class="search-input mainSrch" id="searchValue" onkeyup="filtrele()" placeholder="Arama...">
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
                <th onclick="sortTable(1)">User Name<i id="icon-table1" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(2)">Unvan<i id="icon-table2" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(3)">Telefon Numarası<i id="icon-table3" class="fa-solid fa-sort-down"></i></th>
            </tr>
        </thead>
        <tbody>

            <?php
            $i = 0;
            foreach ($result as $row) {
                $i++;
            ?>
            <tr data-userid="<?php echo $row["phoneID"]; ?>"
                class="git-ac">
                <td data-title="Seç" class="check-style">
                    <!-- Checkbox id'sine $i değerini ekliyoruz -->
                    <input id="check-<?php echo $row["phoneID"] . '-' . $i; ?>" class="check1" type="checkbox"
                        onclick="toggleCheckbox(<?php echo $row['phoneID']; ?>, <?php echo $i; ?>)" />
                    <label for="check-<?php echo $row["phoneID"] . '-' . $i; ?>" class="check">
                        <svg width="18px" height="18px" viewBox="0 0 18 18">
                            <path
                                d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z">
                            </path>
                            <polyline points="1 9 7 14 15 4"></polyline>
                        </svg>
                    </label>
                </td>
                <td data-title="User Name" class="table_tt" contenteditable="false">
                <input class="edit-input" id="adSoyad" type="text" value="<?php echo $row["userName"]; ?>"></td>
                <td data-title="Unvan" class="table_tt" contenteditable="false">
                <input class="edit-input" id="adSoyad" type="text" value="<?php echo $row["unvan"]; ?>"></td>
                <td data-title="Phone Number" class="table_tt phoneNumber" contenteditable="false">
                <input class="edit-input" id="adSoyad" type="text" value="<?php echo $row["phoneNumber"]; ?>"></td>

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
    } else {
?>

<div class="cener-table">

<div class="input-group1">
            <button class="addAnket btn-custom-outline bcoc1">Anket Ekle</button>
        </div>
    <div class="input-group-div">

        <div class="input-group1">
        </div>

        <div class="input-group1">
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
                    <input id="check-" class="check1" type="checkbox" />
                    <label for="check-" class="check">
                        <svg width="18px" height="18px" viewBox="0 0 18 18">
                            <path
                                d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z">
                            </path>
                            <polyline points="1 9 7 14 15 4"></polyline>
                        </svg>
                    </label>
                </th>
                <th onclick="sortTable(1)">User Name<i id="icon-table1" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(2)">Unvan<i id="icon-table2" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(3)">Telefon Numarası<i id="icon-table3" class="fa-solid fa-sort-down"></i></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td colspan="5">Telefon Numarası Bulunamamaktadır.</td>
            </tr>
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
<script>
      $(document).ready(function() {
        $('#saveButton').click(function() {
            var formData = {
                userName: $('input[name="userName"]').val(), // Textarea için doğru seçici
                unvan: $('input[name="unvan"]').val(), // Textarea için doğru seçici
                phoneNumber: $('input[name="phoneNumber"]').val(), // "promise" adında bir input olduğu varsayılıyor
            };
            // console.log("username = "+ formData.userName);
            // console.log("unvan = "+ formData.unvan);
            // console.log("phoneNumber = "+ formData.phoneNumber);            
            $.ajax({
                url: 'Controller/Phone/phoneDirectionSave.php',
                type: 'POST',
                data: {
                    userName: formData.userName,
                    unvan: formData.unvan,
                    phoneNumber: formData.phoneNumber
                },
                success: function(response) {
                    alert(response);
                },
                error: function(error) {
                    console.error("AJAX hatası: ", error);
                }
            });
        });
        });
        
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
            let skipRow = false;

            cols.forEach((col, colIndex) => {
                if (colIndex === 3 && col.innerText.trim() === "Birden Fazla Daire") {
                    skipRow = true; // Bu satırı atla
                }
                if (colIndex !== 0 && !skipRow) { // İlk sütunu ve "Birden Fazla Daire" içeren satırları atla
                    rowData.push(col.innerText.trim());
                }
            });

            if (!skipRow) {
                data.push(rowData);
            }
        });

        let wb = XLSX.utils.book_new();
        let ws = XLSX.utils.aoa_to_sheet(data);

        // Hücre stillerini tanımlama
        const headerCellStyle = {
            font: { bold: true, color: { rgb: "FFFFFF" } }, // Beyaz yazı
            fill: { fgColor: { rgb: "4F81BD" } }, // Mavi arka plan
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
                if (!ws[cellRef]) continue; // Hücre boşsa geç
                if (rowNum === 0) { // Başlık satırlarına stil uygula
                    ws[cellRef].s = headerCellStyle;
                } else { // Veri satırlarına stil uygula
                    ws[cellRef].s = dataCellStyle;
                }
            }
        }

        // Sütun genişliklerini ayarlama
        ws['!cols'] = [
            { wpx: 150 }, // Ad Soyad
            { wpx: 150 }, // Telefon Numarası
            { wpx: 150 }, // Blok / Daire
            { wpx: 100 }  // Durum
        ];

        XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
        XLSX.writeFile(wb, "kullaniciArsivTablosu.xlsx");
    });
    </script>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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

<script>
function sortTable(columnIndex) {
    const table = document.getElementById("example");
    const rows = Array.from(table.rows).slice(1);
    const groups = {};

    // Grupları ayır ve grupları objeye yerleştir
    rows.forEach(row => {
        const groupId = row.getAttribute('data-groupid');
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



var topluGuncelleButtons = document.querySelectorAll('.topluGuncelle');

    topluGuncelleButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var rows = document.querySelectorAll('#example tbody tr.git-ac:not(.none)');
            rows.forEach(function (row) {
                var phoneID = row.getAttribute('data-userid');
                var userName = row.querySelector('td:nth-child(2) input').value.trim();
                var unvan = row.querySelector('td:nth-child(3) input').value.trim();
                var phoneNumber = row.querySelector('td:nth-child(4) input').value.trim();
                console.log("phoneID = "+phoneID);
                console.log("userName = "+userName);
                console.log("unvan = "+unvan);
                console.log("phoneNumber = "+phoneNumber);
                $.ajax({
                    url: 'Controller/Surveys/surveysUpdate.php',
                    type: 'POST',
                    data: {
                        surveysID: surveysID,
                        surveysQuestion: surveysQuestion,
                        lastDate: lastDate,
                        vote: vote
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
//burası her data-userid değeri değiştiğinde altına çizgi koyar //
var trElements = document.querySelectorAll('tr.git-ac');
for (var i = 0; i < trElements.length; i++) {
    if (trElements[i].dataset.userid !== trElements[i + 1]?.dataset.userid) {
        trElements[i].style.borderBottom = '2px solid #ebebeb';
    }
}
// Toplu silme işlemi için butonları seç
var topluSilButton = document.getElementById('silButton');

// Silme işlemi butonuna tıklanınca bu fonksiyon çalışacak
topluSilButton.addEventListener('click', function() {
    var silButton = document.getElementById('silButton');
    var checkboxes = document.querySelectorAll('#example tbody input[type="checkbox"]:checked');

    checkboxes.forEach(function(checkbox) {
        var row = checkbox.closest('tr');
        var surveysID = row.getAttribute('data-userid');
        $.ajax({
            url: 'Controller/Surveys/surveysDelete.php',
            type: 'POST',
            data: {
                surveysID: surveysID
            },
            success: function(deleteResponse) {
                location.reload();
            },
            error: function(deleteError) {
                console.error('Silme hatası:', deleteError);
            }
        });
    });
    silButton.style.display = 'none';
});


var checkEdit = true;


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
</script>

<script>
    $('.addAnket').click(function () {
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
    function openVotersPopup(button){
        const row = button.closest('tr');
        const selectedSurveyID = row.getAttribute('data-userid');
        $('#topluPopup').show().css('display', 'flex').delay(100).queue(function(next) {
            $('body').css('overflow', 'hidden');
            $('#topluPopup').css('opacity', '1');
            $('#userForm2').css('opacity', '1');
            $('#userForm2').css('transform', 'translateY(0)');
            next();
        });
        $.ajax({
            url: 'Controller/Surveys/getVoters.php', // PHP dosyasının yolu
            type: 'POST',
            data: {
                surveysID: selectedSurveyID
            },
            success: function(response) {
                try {
                    const data = JSON.parse(response);
                    const votersList = $('#votersList');
                    votersList.empty(); // Önceki verileri temizle

                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    data.forEach(function(voter) {
            const row = `
                <tr>
                    <td>${voter.blok_adi} / ${voter.daire_sayisi}</td>
                    <td>${voter.userName}</td>
                </tr>
            `;
            votersList.append(row);
        });
                } catch (e) {
                    console.error('Veri işleme hatası:', e);
                    console.error('Gelen yanıt:', response);
                }
            },
            error: function(error) {
                console.error('Hata:', error);
            }
        });
    }

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
</script>

<script src="assets/js/mycode/dropdown.js"></script>
<script>
    
    dropDownn('kisiler', 'kisilerDP', 'kisilerSearch');
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
tarihSec('datepickerson', 7);

    </script>