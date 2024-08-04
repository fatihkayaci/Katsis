<?php
try {
    $sql2 = "SELECT * 
    FROM tbl_users
    WHERE apartman_id = " . $_SESSION["apartID"] . " AND arsive = 0 AND rol = 6
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

            <button class="adduser btn-custom-outline empClr">Kullanıcı Ekle</button>
            <button class="toplu btn-custom-outline empClr">Toplu İşlemler</button>


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
                <input type="text" class="search-input empSrch" id="searchValue" onkeyup="filtrele()" placeholder="Arama...">
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
                <th onclick="sortTable(4)">Email<i id="icon-table4" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(5)">Görevi<i id="icon-table5" class="fa-solid fa-sort-down"></i></th>
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
                    <input class="edit-input" id="adSoyad" type="text" value="<?php echo $row["userName"]; ?>">
                </td>

                <td data-title="tc" class="table_tt table_td" contenteditable="false">
                    <input class="edit-input" id="tcNo" type="text" value="<?php echo $row["tc"]; ?>">
                </td>

                <td data-title="Telefon Numarası" class="table_tt table_td phoneNumberTable" contenteditable="false">
                    <input class="edit-input" id="numara" type="text" value="<?php echo $row["phoneNumber"]; ?>">
                </td>

                <td data-title="Email" class="table_tt table_td email" contenteditable="false">
                    <input class="edit-input" id="userEmail" type="text" value="<?php echo $row["userEmail"]; ?>">
                </td> 

                <td data-title="Task" class="table_tt table_td Task" contenteditable="false">
                    <input class="edit-input" id="task" type="text" value="<?php echo $row["task"]; ?>">
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

    <form class="login-form empInpClr" id="userForm">

        <h2 class="form-signin-heading">personel Ekleme</h2>

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

            <div class="col-md-6 col margint mt-0">
                <div class="select-div">
                    <div class="dropdown-nereden">
                        <div class="group">
                            <input class="search-selectx input" data-user-id="" type="text" id="userInput"
                                required="" />
                            <label class="selectx-label" for="userInput">Cinsiyet :</label>
                        </div>

                        <div class="dropdown-content-nereden searchInput-btn" id="userInputDP">
                            <div class="dropdown-content-inside-nereden empPopup">
                                <input type="hidden" id="searchInput-userInput" placeholder="Ara...">

                                <button data-user-id="Erkek" name="gender">Erkek</button>
                                <button data-user-id="Kadin" name="gender">Kadın</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-6 col margint mt-0">
                <div class="select-div">
                    <div class="dropdown-nereden">
                        <div class="group">
                            <input class="search-selectx input" data-user-id="" type="text" id="educationStatus"
                                required="" />
                            <label class="selectx-label" for="educationStatus">Öğrenim Durumu :</label>
                        </div>

                        <div class="dropdown-content-nereden searchInput-btn" id="educationStatusDP">
                            <div class="dropdown-content-inside-nereden empPopup">
                                <input type="hidden" id="searchInput-educationStatus" placeholder="Ara...">

                                <button  data-user-id="ilkokul" name="educationStatus">ilkokul</button>
                                <button  data-user-id="ortaokul" name="educationStatus">ortaokul</button>
                                <button  data-user-id="lise" name="educationStatus">lise</button>
                                <button  data-user-id="üniversite" name="educationStatus"> üniversite</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col margint">
    <input class="input" type="text" id="iban" name="iban" maxlength="50" oninput="formatIBAN(this)" required="" />
    <label for="iban">Iban</label>
</div>
            
        </div>

        <div class="row">
            <div class="col-md-6 col margint">
                <input class="input" data-user-id="" id="datepickerSecim" name="startingWorking" type="text" required="">
                <label for="startingWorking">İşe Giriş Tarihi</label>
            </div>
            <!-- burayı beraber konuşmamız gerekiyor. -->
            <div class="col-md-6 col margint">
                <input class="input" type="text" name="task" required="">
                <label for="task">Görevi</label>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col margint">
                <input class="input" type="text" name="sigortaNo" required="">
                <label for="sigortaNo">Sigorta No</label>
            </div>
            <div class="col-md-6 col margint">
                <input class="input" type="text" name="salary" required="">
                <label for="salary">Maaş</label>
            </div>
            
        </div>
        <!-- buraya bak yusuf bunlara css atılacak -->
        <div class="row">
            <div class="col-md-6 check-label margint">
                <div class="yeni-check empchc">
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
                <div class="col-md-6 mt-4 col margint">
                    <input class="input" type="text" name="openingBalance" required="">
                    <label for="openingBalance">Açılış Bakiyesi</label>
                </div>

                <div class="col-md-6 mt-4 col margint">
                    <div class="select-div mt-0">
                        <div class="dropdown-nereden">
                            <div class="group">
                                <input class="search-selectx input" data-user-id="" type="text" id="userInput-bakiye"
                                    required="" />
                                <label class="selectx-label" for="userInput-bakiye">Durum :</label>
                            </div>

                            <div class="dropdown-content-nereden searchInput-btn" id="userInput-bakiyeDP">
                                <div class="dropdown-content-inside-nereden empPopup">
                                    <input type="hidden" id="searchInput-userInput-bakiye" placeholder="Ara...">

                                    <button data-user-id="borc">Borç</button>
                                    <button data-user-id="alacak">Alacak</button>
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

        <h2 class="form-signin-heading">oluşturma şeklini seçiniz!</h2>

        <div class="row">
            <div class="col-md-12 col-btn mb-0">
                <a class="ahref btn-custom-daire empClr w-100" href="index?parametre=TopluPersonel">Toplu Personel Ekleme</a>
                <a class="ahref btn-custom-daire empClr w-100" href="Controller/Employeed/excelCreate.php" id="excelDownload" download="PersonelEkle.xlsx">Excel İndir</a>
                <p class="text-left">Excel İle Kullanıcı Ekleme:</p>
                <div class="upload-box empupl">
                    <input type="file" id="excel_file" accept=".xlsx" hidden>
                    <label for="excel_file" class="file_label empeUpl">Dosya Seçin</label>
                    <!-- name of file chosen -->
                    <span id="file-chosen"></span>

                    <button id="upload_btn" class="empClr">Gönder</button>
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
     window.onload = function() {
        var tcInput = document.getElementsByName('tc')[0];
        var phoneInput = document.getElementsByName('phoneNumber')[0];

        // TC için 11 karakter sınırlaması ve sadece rakam girişine izin verme
        tcInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 11);
        });

        // Telefon numarası için 10 karakter sınırlaması ve sadece rakam girişine izin verme
        phoneInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 10);
        });

        var userPopup = document.getElementById('popup');
        var topluPopup = document.getElementById('topluPopup');
        // ESC tuşuna basıldığında popup'ı kapat
        window.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                if(userPopup.style.display === 'flex'){
                    closePopup();
                }else if(topluPopup.style.display === 'flex'){
                    closeToplu();
                }
            }
        });
    };
</script>
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
                userEmail: user.userEmail, // Blok ve daire sayısını birleştirme
                task: user.task
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
            ws['D1'].v = 'Email';
            ws['E1'].v = 'Görevi';

            // Sütun genişliklerini ayarlama
            ws['!cols'] = [
                { wpx: 150 }, // Ad Soyad
                { wpx: 100 }, // TC
                { wpx: 120 }, // Telefon Numarası
                { wpx: 150 }, // Blok / Daire
                { wpx: 100 }  // Durum
            ];

            XLSX.writeFile(wb, 'Personel.xlsx');
        });
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
                    location.reload();
                },
                error: function(xhr, status, error){
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
<script>
  function formatIBAN(input) {
    let iban = input.value.replace(/\D/g, ''); // Sadece rakamları al
    iban = 'TR' + iban; // TR öne ekle

    let formattedIBAN = 'TR'; // İlk iki karakter sabit

    // IBAN uzunluğunu kontrol et ve formatla
    if (iban.length > 2) {
        for (let i = 2; i < iban.length; i++) {
            if (i === 4 || (i > 4 && (i - 4) % 4 === 0)) {
                formattedIBAN += ' '; // 4. karakterden itibaren her 4 karakterde bir boşluk
            }
            formattedIBAN += iban[i];
        }
    }

    // Son iki karakteri kontrol et ve son haliyle set et
    input.value = formattedIBAN.slice(0, 32) + iban.slice(32);
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

<script src="assets/js/mycode/dropdown.js"></script>
<script>
dropDownn('userInput', 'userInputDP', 'searchInput-userInput');
dropDownn('educationStatus', 'educationStatusDP', 'searchInput-educationStatus');
dropDownn('userInput-bakiye', 'userInput-bakiyeDP', 'searchInput-userInput-bakiye');
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

$(document).ready(function() {
    $('#saveButton').click(function() {
        // Form verilerini topla
        var formData = {
            userName: $('input[name="userName"]').val(),
            tc: $('input[name="tc"]').val(),
            phoneNumber: $('input[name="phoneNumber"]').val(),
            userEmail: $('input[name="userEmail"]').val(),
            gender: $('#userInput').data('user-id'),
            educationStatus: $('#educationStatus').data('user-id'),
            iban: $('input[name="iban"]').val(),
            startingWorking: $('input[name="startingWorking"]').val(),
            task: $('input[name="task"]').val(),
            sigortaNo: $('input[name="sigortaNo"]').val(),
            salary: $('input[name="salary"]').val(),
            openingBalance: $('input[name="openingBalance"]').val(),
            balanceStatus: $('#userInput-bakiye').data('user-id'),
            promise: $('input[name="promise"]').val()
        };

        $.ajax({
            type: "POST",
            url: 'Controller/Employeed/employedSave.php',  // Bu URL'yi sunucu tarafında işleme koyacağınız URL ile değiştirin
            data: formData,
            success: function(response) {
                // Başarılı olursa
                console.log(response);
                alert("Form başarıyla gönderildi!");
                location.reload();
            },
            error: function(error) {
                // Hata olursa
                console.log(error);
                alert("Form gönderilirken bir hata oluştu.");
            }
        });
    });

    // Dropdown menülerde seçimi yönetmek için event handler ekleyelim
    $('#userInputDP button').click(function() {
        var gender = $(this).data('user-id');
        $('#userInput').data('user-id', gender).val($(this).text());
    });

    $('#educationStatusDP button').click(function() {
        var educationStatus = $(this).data('user-id');
        $('#educationStatus').data('user-id', educationStatus).val($(this).text());
    });

    $('#userInput-bakiyeDP button').click(function() {
        var balanceStatus = $(this).data('user-id');
        $('#userInput-bakiye').data('user-id', balanceStatus).val($(this).text());
    });
});

//kısıtlama ile ilgili fonksiyonlar bitiş...
//var toplusil 
var topluGuncelleButtons = document.querySelectorAll('.topluGuncelle');

topluGuncelleButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        var rows = document.querySelectorAll('#example tbody tr.git-ac:not(.none)');
        var successCount = 0; // Başarılı işlemleri saymak için sayaç
        var totalRows = rows.length; // Toplam satır sayısı
        rows.forEach(function(row) {
            var userID = row.getAttribute('data-userid');
            var userName = row.querySelector('td:nth-child(2) input').value.trim();
            var tc = row.querySelector('td:nth-child(3) input').value.trim();
            var phoneNumber = row.querySelector('td:nth-child(4) input').value.trim();
            var userEmail = row.querySelector('td:nth-child(5) input').value.trim();
            var task = row.querySelector('td:nth-child(6) input').value.trim();
            
            console.log("userID = " + userID + " userName = " + userName + " tc = " + tc + " phoneNumber = " + phoneNumber + " userEmail = " + userEmail + " task = " + task);
            
            $.ajax({
                url: 'Controller/Employeed/employedUpdate.php',
                type: 'POST',
                data: {
                    userID: userID,
                    userName: userName,
                    tc: tc,
                    phoneNumber: phoneNumber,
                    userEmail: userEmail,
                    task: task
                },
                success: function(response) {
                    successCount++;
                    if (successCount === totalRows) {
                        alert(response);
                        location.reload();
                    }
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
    var successCount = 0; // Başarılı işlemleri saymak için sayaç
    var totalCheckboxes = checkboxes.length; // Toplam checkbox sayısı

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
                successCount++;
                if (successCount === totalCheckboxes) {
                    alert(response);
                    location.reload();
                }
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

<!-- Excel Icin Dosya Secme Script i -->

<script>
    const actualBtn = document.getElementById('excel_file');

    const fileChosen = document.getElementById('file-chosen');

    actualBtn.addEventListener('change', function(){
      fileChosen.textContent = this.files[0].name
    })
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
tarihSec('datepickerSecim', 0);
tarihSec('datepickerAcilis', 0);

    </script>