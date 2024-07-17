<?php
try {
    $sql = "SELECT * FROM tbl_surveys WHERE apartmanID = " . $_SESSION["apartID"];
    // Check the session variable and modify the query accordingly
    
    if ($_SESSION["durum"] == "Kiracı") {
        $sql .= " AND (voters = 3 OR voters = 1)";
    } elseif ($_SESSION["durum"] == "Kat Maliki") {
        $sql .= " AND (voters = 2 OR voters = 1)";
    }else{
        $sql .= " AND voters = 1";
    }
    // Add the ORDER BY clause
    $sql .= " ORDER BY surveysID ASC";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($result) {
       ?>
<div class="table-overflow">
    <table id="example" class="users-table">
        <thead>
            <tr class="users-table-info">
                <th onclick="sortTable(1)">Anket Başlığı <i id="icon-table1" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(2)">Son Tarihi <i id="icon-table2" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(3)">Kullanılan Oy <i id="icon-table3" class="fa-solid fa-sort-down"></i></th>
                <th style="text-align: center;" onclick="sortTable(4)">Oy<i id="icon-table5"
                        class="fa-solid fa-sort-down"></i></th>
                <!-- <th style="text-align: center;" onclick="sortTable(4)">Oylama Durumu <i id="icon-table4" class="fa-solid fa-sort-down"></i></th> -->
            </tr>
        </thead>
        <tbody>

            <?php
            $i = 0;
            foreach ($result as $row) {
                $i++;
            ?>
            <tr data-userid="<?php echo $row["surveysID"]; ?>" class="git-ac">
                <td data-title="Anket Basligi" class="table_tt" contenteditable="false">

                    <?php echo $row["surveysQuestion"]; ?></td>

                <td data-title="TC" class="table_tt" contenteditable="false">

                    <?php echo $row["lastDate"]; ?></td>

                <td data-title="vote" class="table_tt phoneNumber" contenteditable="false">

                    <?php echo  "doldurulacak" ?></td>
                <td style="text-align: center;" data-title="oylar" class="table_tt">
                    <button type="button" class="fatura_btn oylar_btn" onclick="openOyPopup(this)" id="oylar"><i class="fa-regular fa-clipboard"></i></button>
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
    <div class="table-overflow">
        <table id="example" class="users-table">
            <thead>
                <tr class="users-table-info">
                    <th onclick="sortTable(1)">Anket Başlığı <i id="icon-table1" class="fa-solid fa-sort-down"></i></th>
                    <th onclick="sortTable(2)">Son Tarihi <i id="icon-table2" class="fa-solid fa-sort-down"></i></th>
                    <th onclick="sortTable(3)">Kullanılan Oy <i id="icon-table3" class="fa-solid fa-sort-down"></i></th>
                    <th onclick="sortTable(4)">Oylama Durumu <i id="icon-table4" class="fa-solid fa-sort-down"></i></th>
                    <th onclick="sortTable(5)">Oy Kullananlar <i id="icon-table5" class="fa-solid fa-sort-down"></i>
                    </th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="5">Anket Bulunamamaktadır.</td>
            </tr>
        </tbody>
        </table>
        <button style="display: none;" class="export-btn excel-btn" id="exportButton"><i class="fa-solid fa-file-excel"></i> Excel'e Aktar</button>
    </div>

    <hr class="horizontal dark mb-0 w-100">

</div>

<?php
    }
} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
?>
<!-- Oy POPUP -->
<div id="topluPopup">

    <form class="login-form-toplu" id="userForm2" action="">

        <h2 class="form-signin-heading">Oy</h2>

        <hr class="horizontal mt-0 dark w-100">

        <table class="users-table table-blok">
            
        </table>

        <div class="row row-btn">
            <button type="button" class="btn-custom-close w-50 me-0" onclick="closeToplu()">Kapat</button>
            <button type="button" class="btn-custom-close w-50 me-0" onclick="oyIptal(this)">iptal</button>
        </div>
    </form>
</div>


<script>

let selectedSurveyID = null;

function openOyPopup(button) {
    const row = button.closest('tr');
    selectedSurveyID = row.getAttribute('data-userid');
    $('#topluPopup').show().css('display', 'flex').delay(100).queue(function(next) {
        $('body').css('overflow', 'hidden');
        $('#topluPopup').css('opacity', '1');
        $('#userForm2').css('opacity', '1');
        $('#userForm2').css('transform', 'translateY(0)');
        next();
    });
    $.ajax({
        url: 'Controller/Surveys/getSurveyOptions.php', // PHP dosyasının yolu
        type: 'POST',
        data: {
            surveysID: selectedSurveyID
        },
        success: function(response) {
             // Başarılı cevap geldiğinde işlemleri yap
        var options = JSON.parse(response);

        // table içine buttonları ekle
        var table = $('.table-blok');
        table.empty(); // Önce tabloyu temizle

        options.forEach(function(option) {
            var button = $('<button type="button" class="btn btn-primary">' + option.optionName + '</button>');
            button.click(function() {
                    // Butona tıklandığında yapılacak işlemler burada
                    $.ajax({
                        url: 'Controller/Surveys/createSurveyVote.php', // Güncelleme için PHP dosyasının yolu
                        type: 'POST',
                        data: {
                            surveysID: selectedSurveyID,
                            optionID: option.optionID  // Varsayalım ki optionID ile güncelleme yapacaksınız
                        },
                        success: function(updateResponse) {
                            console.log('Veritabanı güncellendi:', updateResponse);
                        },
                        error: function(updateError) {
                            console.error('Güncelleme Hatası:', updateError);
                        }
                    });
                });
            table.append($('<tr>').append($('<td>').append(button)));
        });
        },
        error: function(error) {
            console.error('Hata:', error);
        }
    });
}

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

function oyIptal(button){
    $.ajax({
        url: 'Controller/Surveys/deleteSurveysVote.php', // PHP dosyasının yolu
        type: 'POST',
        data: {
            surveysID: selectedSurveyID,
        },
        success: function(response) {
            console.log(response);
        },
        error: function(error) {
            console.error('Hata:', error);
        }
    });

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
            if (colIndex !== 0 && !
                skipRow) { // İlk sütunu ve "Birden Fazla Daire" içeren satırları atla
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
        font: {
            bold: true,
            color: {
                rgb: "FFFFFF"
            }
        }, // Beyaz yazı
        fill: {
            fgColor: {
                rgb: "4F81BD"
            }
        }, // Mavi arka plan
        alignment: {
            horizontal: "center",
            vertical: "center"
        }
    };

    const dataCellStyle = {
        alignment: {
            horizontal: "center",
            vertical: "center"
        }
    };

    // Stil uygulama
    let range = XLSX.utils.decode_range(ws['!ref']);
    for (let rowNum = range.s.r; rowNum <= range.e.r; rowNum++) {
        for (let colNum = range.s.c; colNum <= range.e.c; colNum++) {
            let cellAddress = {
                c: colNum,
                r: rowNum
            };
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
    ws['!cols'] = [{
            wpx: 150
        }, // Ad Soyad
        {
            wpx: 150
        }, // Telefon Numarası
        {
            wpx: 150
        }, // Blok / Daire
        {
            wpx: 100
        } // Durum
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
</script>