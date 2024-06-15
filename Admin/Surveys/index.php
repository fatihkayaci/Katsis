<!-- Popup Form -->
<div id="popup">

    <form class="login-form mainpopup" id="userForm">

        <h2 class="form-signin-heading mb-3">Anket Ekleme</h2>

        <hr class="horizontal dark mt-0 w-100">

        <div class="row mt-3">
            <div class="col-md-6 col-btn">
                <textarea class="input" name="anketSoru" id="anketSoru" required></textarea>
                <label for="anketSoru">Anket Sorusu :</label>
            </div>
        </div>

        <div class="row secekE" id="secenekContainer">
            <div class="col-md-6 col-btn group">
                <input class="input trash-k" type="text" name="1secenek" required>
                <label for="1secenek">1. Seçenek :</label>
                <button class="trashcan"><i class="fa-solid fa-trash-can"></i></button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-btn">
                <button class="btn-custom w-100 bcoc1" id="secenekEkle"><i class="fa-solid fa-plus"></i> Seçenek Ekle</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col">
                <input class="input" data-user-id="" id="datepickerson" name="promise" type="text" required="">
                <label for="datepickerson">Son Cevaplama Tarihi</label>
            </div>
            <div class="col-md-6 col">
                <div class="select-div m-0">
                    <div class="dropdown-nereden">
                        <div class="group">
                            <input class="search-selectx input" data-user-id="" type="text" id="kisiler"
                                required="" />
                            <label class="selectx-label" for="kisiler">Kişiler: </label>
                        </div>

                        <div class="dropdown-content-nereden searchInput-btn" id="kisilerDP">
                            <div class="dropdown-content-inside-nereden mainpopupx">
                                <input type="hidden" id="kisilerSearch" placeholder="Ara...">
                                <button data-odeme-durumu="tumkisiler" name="tumkisiler">Tüm Kişiler</button>
                                <button data-odeme-durumu="katmaliki" name="katmaliki">Kat Malikleri</button>
                                <button data-odeme-durumu="kiraci" name="kiraci">Kiracılar</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        

        <hr class="horizontal dark mt-0 w-100">

        <div class="row row-btn">
            <button type="button" class="btn-custom-close" onclick="closePopup()">Kapat</button>
            <button type="button" class="btn-custom userClr" id="saveButton">Kaydet</button>
        </div>


    </form>
</div>

<!-- Oy POPUP -->
<div id="topluPopup">

    <form class="login-form-toplu" id="userForm2" action="">

        <h2 class="form-signin-heading">Oy Kullanan Kişiler</h2>
        
        <hr class="horizontal mt-0 dark w-100">

        <table class="users-table table-blok">
                <tr class="users-table-info">
                    <th>Blok / Daire </th>
                    <th>Ad Soyad </th>
                </tr>
                <tr id="mainTr" style="display:none;">
                    <tr class="git-ac" id="">
                        <td>a-1</td>
                        <td>Ad Soayd</td>
                    </tr>
                </tr>

            </table>

            <hr class="horizontal dark w-100">

            <div class="row row-btn">
                <button type="button" class="btn-custom-close w-100 me-0" onclick="closeToplu()">Kapat</button>
            </div>

    </form>
</div>

<?php
try {
    
    $sql2 = "SELECT * FROM tbl_arsive 
    ORDER BY fullName ASC";
    
    $stmt = $conn->prepare($sql2);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//contenteditable="true"
    if ($result) {
       ?>

<div class="cener-table">

    <div class="input-group-div">

        <div class="input-group1">
            <button class="addAnket btn-custom-outline bcoc1">Anket Ekle</button>
        </div>

        <div class="input-group1">
            
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
                <th onclick="sortTable(1)">Anket Başlığı <i id="icon-table1" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(2)">Son Tarihi <i id="icon-table2" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(3)">Kullanılan Oy <i id="icon-table3" class="fa-solid fa-sort-down"></i></th>
                <th style="text-align: center;" onclick="sortTable(4)">Oylama Durumu <i id="icon-table4" class="fa-solid fa-sort-down"></i></th>
                <th style="text-align: center;" onclick="sortTable(5)">Oy Kullananlar <i id="icon-table5" class="fa-solid fa-sort-down"></i></th>
            </tr>
        </thead>
        <tbody>

            <?php
            $i = 0;
            foreach ($result as $row) {
                $i++;
            ?>
            <tr data-userid="<?php echo $row["userID"]; ?>" id="<?php echo $row["grupID"]; ?>"
                class="git-ac">
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
                <td data-title="Ad Soyad" class="table_tt" contenteditable="false">

                    <?php echo $row["fullName"]; ?></td>

                    <td data-title="TC" class="table_tt" contenteditable="false">

                    <?php echo $row["TC"]; ?></td>

                <td data-title="Telefon Numarası" class="table_tt phoneNumber" contenteditable="false">

                    <?php echo $row["phoneNumber"]; ?></td>

                <td style="text-align: center; width: 100;" data-title="Durum" class="table_tt">
                    <div class="main-durum <?php
                                if ($row["status"] == "kiraci") {
                                    echo "kiraci";
                                } elseif ($row["status"] == "katMaliki") {
                                    echo "kat-maliki";
                                } else {
                                    echo "belirtilmemis";
                                }
                                ?> ">
                        <?php echo $row["status"]; ?>
                    </div>
                </td>

                <td style="text-align: center;" data-title="oylar" class="table_tt">
                    <button type="button" class="fatura_btn oylar_btn" id="oylar"><i class="fa-regular fa-clipboard"></i></button>
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
    } else {
?>

<div class="cener-table">

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
                <th onclick="sortTable(1)">Anket Başlığı <i id="icon-table1" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(2)">Son Tarihi <i id="icon-table2" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(3)">Kullanılan Oy <i id="icon-table3" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(4)">Oylama Durumu <i id="icon-table4" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(5)">Oy Kullananlar <i id="icon-table5" class="fa-solid fa-sort-down"></i></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td colspan="5">Anket Bulunamamaktadır</td>
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
        var userID = row.getAttribute('data-userid');
        $.ajax({
            url: 'Controller/deleteArsiv.php',
            type: 'POST',
            data: {
                userID: userID
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

    $('#oylar').click(function () {
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
        const secenekContainer = document.getElementById("secenekContainer");
        const secenekEkleButton = document.getElementById("secenekEkle");
        let secenekCount = 1;  // Başlangıçta 1 seçenek var

        secenekEkleButton.addEventListener("click", function() {
            secenekCount++;
            const newSecenek = document.createElement("div");
            newSecenek.className = "col-md-6 col-btn group";
            newSecenek.innerHTML = `
                <input class="input trash-k" type="text" name="${secenekCount}secenek" required>
                <label for="${secenekCount}secenek">${secenekCount}. Seçenek :</label>
                <button class="trashcan"><i class="fa-solid fa-trash-can"></i></button>
            `;
            secenekContainer.appendChild(newSecenek);

            updateTrashCanButtons();
        });

        function updateTrashCanButtons() {
            const trashCanButtons = document.querySelectorAll(".trashcan");
            trashCanButtons.forEach(button => {
                button.removeEventListener("click", handleTrashCanClick);
                button.addEventListener("click", handleTrashCanClick);
            });
        }

        function handleTrashCanClick(event) {
            const groups = secenekContainer.querySelectorAll(".group");
            if (groups.length > 1) {  // En az 1 seçenek kalmalı
                const lastGroup = groups[groups.length - 1];
                secenekContainer.removeChild(lastGroup);
                secenekCount--;
            }
        }

        updateTrashCanButtons();  // Sayfa yüklendiğinde mevcut butonlara event ekle
    });

    </script>