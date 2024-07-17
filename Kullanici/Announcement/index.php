<?php
require_once "Controller/class.func.php";
?>
<?php
try {
    $sql1 = "SELECT * FROM tbl_announcement WHERE ". $_SESSION["apartID"];
    
    $stmt = $conn->prepare($sql1);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($result) {
       ?>

<div class="cener-table">

    <div class="input-group-div">


        <div class="input-group1">
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
                <th onclick="sortTable(1)">Duyuru Başlığı<i id="icon-table1" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(2)">duyuru içeriği<i id="icon-table2" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(3)">Son Tarih<i id="icon-table3" class="fa-solid fa-sort-down"></i></th>
            </tr>
        </thead>
        <tbody>

            <?php
            $i = 0;
            foreach ($result as $row) {
                
                $i++;
                
                $currentDate = date('Y-m-d');
                // lastDate'i çek ve datetime formatına çevir
                
                $lastDate = $row["lastDate"];
                $lastDateTime = new DateTime($lastDate);
                $currentDateTime = new DateTime($currentDate);

                // Tarih karşılaştırması yap
                if ($currentDateTime > $lastDateTime) {
                    $oylamaDurumu = "Bitti";
                } else {
                    $oylamaDurumu = "Devam Ediyor";
                }
            ?>
            <tr data-userid="<?php echo $row["announcementID"]; ?>" class="git-ac">
                <td data-title="Duyuru Basligi" class="table_tt table_td" contenteditable="false">
                <input class="edit-input" id="announcementTitle" type="text" value="<?php echo $row["announcementTitle"]; ?>"></td>
                
                <td data-title="Anket icerigi" class="table_tt table_td" contenteditable="false">
                <input class="edit-input" id="announcementContent" type="text" value="<?php echo $row["announcementContent"]; ?>"></td>

                <td data-title="lastDate" class="table_tt table_td" contenteditable="false">
                <input class="edit-input" id="lastDate" type="text" value="<?php echo tarihDonustur($row["lastDate"]); ?>"></td>
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
    <div class="input-group-div">

        <div class="input-group1">
        </div>

        <div class="input-group1">
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
                <th onclick="sortTable(1)">Duyuru Başlığı<i id="icon-table1" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(2)">duyuru içeriği<i id="icon-table2" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(3)">Son Tarih<i id="icon-table3" class="fa-solid fa-sort-down"></i></th>
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
<script>

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