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

<script type="text/javascript">

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