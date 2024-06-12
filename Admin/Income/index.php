<?php
require_once "Controller/class.func.php";
$idapartman =$_SESSION["apartID"];
try {
    $sql2 = "SELECT 
    tbl_maliye.*, 
    tbl_kategori.kategori_adi  
FROM 
    tbl_maliye
JOIN 
    tbl_kategori ON tbl_maliye.kategori_id = tbl_kategori.kategori_id;";
    

    $stmt = $conn->prepare($sql2);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
    $kategori_listesi = array();
    $sql2 = "SELECT * FROM tbl_kategori where apartman_id=" . $_SESSION["apartID"];
    $stmt2 = $conn->prepare($sql2);
    $stmt2->execute();
    $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result2 as $row2) {
        $kategori_listesi[$row2['kategori_id']] = $row2['kategori_adi'];
    }

    $sql = "
    SELECT 
    u1.userID AS katMalikiID, 
        
        u1.userName AS katMalikiName,
        u2.userID AS kiraciID,  
        u2.userName AS kiraciName, 
        b.blok_adi AS blokAdi,
        d.daire_sayisi AS dNO,
        d.daire_id,
        d.katMalikiID,
        d.KiraciID
    FROM tbl_daireler d
    LEFT JOIN tbl_users u1 ON d.katMalikiID = u1.userID
    LEFT JOIN tbl_users u2 ON d.KiraciID = u2.userID
    LEFT JOIN tbl_blok b ON d.blok_adi = b.blok_id  WHERE d.apartman_id=".$idapartman ;

    // Sorguyu hazırlama ve çalıştırma
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $daireler = $stmt->fetchAll(PDO::FETCH_ASSOC);

  

   

 

?>
<style>
.hidden {
    display: none;
}
</style>
<input type="hidden" id="apartmanId" value=<?php echo $_SESSION["apartID"] ?> />
<div class="cener-table">

    <div class="input-group-div">

        <div class="input-group1">

            <button class="adduser btn-custom-outline finansClr"
                onclick=" popupOpenControl('popupBorcEkle','borcEkleForm')">Borç Tanımla</button>
            <a href="index?parametre=topluborc" class="toplu btn-custom-outline a-btn finansClr">Toplu Borç Tanımla</a>

        </div>

        <div class="input-group1">
            <button class="topluGuncelle btn-custom-outline bcoc3" id="guncelleButton"
                style="display: none;">Güncelle</button>
            <button class="topluSil btn-custom-outline bcoc4" id="silButton" style="display: none;">Sil</button>


            <div class="search-box">
                <i class="fas fa-search search-icon" aria-hidden="true"></i>
                <input type="text" class="search-input finansSrch" id="searchValue" onkeyup="filtrele()" placeholder="Arama...">
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
                <th onclick="sortTable(1)">Kategori <i id="icon-table1" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(2)">Açıklama <i id="icon-table2" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(3)">Tanımlama Tarihi<i id="icon-table3" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(4)">Ödeme Durumu<i id="icon-table4" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(5)">Toplam Bakiye<i id="icon-table4" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(6)">Kalan Bakiye<i id="icon-table4" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(7)">Fatura<i id="icon-table4" class="fa-solid fa-sort-down"></i></th>
            </tr>
        </thead>
        <tbody>

            <?php
                    $i = 0;
                    foreach ($result as $row) {
                        $i++;
                        ?>
            <tr data-userid="<?php echo $row["maliye_id"]; ?>" id="tr-<?php echo $row["maliye_id"] . '-' . $i; ?>"
                class="git-ac">
                <td data-title="Seç" class="check-style">
                    <!-- Checkbox id'sine $i değerini ekliyoruz -->
                    <input id="check-<?php echo $row["maliye_id"] . '-' . $i; ?>" class="check1" type="checkbox"
                        onclick="toggleCheckbox(<?php echo $row['maliye_id']; ?>, <?php echo $i; ?>)" />
                    <label for="check-<?php echo $row["maliye_id"] . '-' . $i; ?>" class="check">
                        <svg width="18px" height="18px" viewBox="0 0 18 18">
                            <path
                                d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z">
                            </path>
                            <polyline points="1 9 7 14 15 4"></polyline>
                        </svg>
                    </label>
                </td>
                <td data-title="kategori" class="table_tt table_td <?php echo $row["maliye_turu"] == 2 ? 'green-class' : (ZamanControl(date("Y-m-d"), $row["odeme_tar"]) == 1 ? 'red-class' : '');
 ?>" contenteditable="false">
                    <?php echo $row["kategori_adi"]; ?>
                </td>

                <td data-title="Aciklama" class="table_tt table_td <?php echo $row["maliye_turu"] == 2 ? 'green-class' : (ZamanControl(date("Y-m-d"), $row["odeme_tar"]) == 1 ? 'red-class' : '');
 ?> phoneNumberTable" contenteditable="false">

                    <?php echo $row["aciklama"]; ?>
                </td>

                <td data-title="tanimlama_tar" class="table_tt table_td <?php echo $row["maliye_turu"] == 2 ? 'green-class' : (ZamanControl(date("Y-m-d"), $row["odeme_tar"]) == 1 ? 'red-class' : '');
 ?> email" contenteditable="false">
                    <?php echo tarihDonustur($row["tanımlama_tar"]) ; ?>
                </td>
                <td data-title="durum" class="table_tt table_td <?php echo $row["maliye_turu"] == 2 ? 'green-class' : (ZamanControl(date("Y-m-d"), $row["odeme_tar"]) == 1 ? 'red-class' : '');
 ?> Task" contenteditable="false">
                    <?php
                  if($row["maliye_turu"]==2){
                    echo "<p class='main-durum odendi'>Ödendi</p>";
                  }else{
                    echo ZamanFarki(date("Y-m-d"), $row["odeme_tar"]);
                  }
                  ?>
                </td>

                <td data-title="top_borc" class="table_tt table_td Task <?php echo $row["maliye_turu"] == 2 ? 'green-class' : (ZamanControl(date("Y-m-d"), $row["odeme_tar"]) == 1 ? 'red-class' : '');
 ?>" contenteditable="false">
                    <?php echo duzenleSayi($row["top_borc"]) ; ?>
                </td>

                <td data-title="kalan_borc" class="table_tt table_td  <?php echo $row["maliye_turu"] == 2 ? 'green-class' : (ZamanControl(date("Y-m-d"), $row["odeme_tar"]) == 1 ? 'red-class' : '');
 ?>" contenteditable="false">
                    <?php echo duzenleSayi($row["borc_miktar"]); ?>
                </td>
                <td data-title="fatura" class="table_tt table_td <?php echo $row["maliye_turu"] == 2 ? 'green-class' : (ZamanControl(date("Y-m-d"), $row["odeme_tar"]) == 1 ? 'red-class' : '');
 ?>" contenteditable="false">
                    <?php 
                  if($row["maliye_turu"] == 2){
                  
                  ?>

                    <a href="Controller/pdf/Income_pdf?temp=<?php echo $row["maliye_id"]; ?>" target="_blank">
                        <button class="fatura_btn"><i class="fa-solid fa-file-export"></i></button>
                    </a>
                    <?php 
                }
                  
                  ?>
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

<!-- Borç Ekleme Popup-->
<div id="popupBorcEkle" class="form-popup">

    <form id="borcEkleForm" class="login-form finansInpClr">

        <h2 class="form-signin-heading">Borç Ekle</h2>


        <div class="row">

            <div class="col-md-6 col-btn">
                <input class="input" type="text" id="aciklama" required="" />
                <label id="aciklamaLabel" for="aciklama">Açıklama *: </label>
            </div>

            <div class="col-md-12 col-btn">
                <input class="input" type="text" id="borcTutar" placeholder="0,00" step="0.01"
                    onclick="selectInput(this)" onkeypress="return onlyNumberKey(event)" />
                <label id="borcLabel" for="borcTutar">Borç Tutarı *:</label>
            </div>

            <div class="col-md-6 col">
                <input class="input" type="date" value="<?php echo date('Y-m-d'); ?>" id="dateInput" required="" />
                <label id="label_tarih" for="dateInput">Borç Tanımlama Tarihi :</label>
            </div>

            <div class="col-md-6 col">
                <input class="input" type="date" value="<?php echo date('Y-m-d', strtotime('+7 days')); ?>"
                    id="dateInput2" required="" />
                <label id="label_tarih2" for="dateInput2">Son Ödeme Tarihi :</label>
            </div>

            <div class="col-md-6 col-btn">

                <div class="select-div">

                    <div class="dropdown-nereden">
                        <div class="group">
                            <input class="search-selectx input" data-user-id="" type="text" list="Users" id="kategori"
                                name="options" required="" />
                            <label id="kategoriLabel" class="selectx-label" for="kategori">Kategoriler : *</label>
                        </div>

                        <div class="dropdown-content-nereden searchInput-btn" id="kategoriDP">
                            <div class="dropdown-content-inside-nereden finansPopup">
                                <input type="text" id="searchInput" placeholder="Ara...">

                                <?php 
                                    foreach($kategori_listesi as $kategori_id => $kategori_adi){
                                        echo '                                        
                                           <button  data-user-id="' . $kategori_id . '">' . $kategori_adi . '</button>';
                                    }
                                ?>
                            </div>

                        </div>

                    </div>




                </div>

            </div>


            <div class="col-md-6 col-btn">

                <div class="select-div">

                    <div class="dropdown-nereden">
                        <div class="group">
                            <input class="search-selectx input" data-user-id="" type="text" list="Users" id="kategori2"
                                name="options" required="" />
                            <label id="kategoriLabel" class="selectx-label" for="kategori">Kullanıcılar: *</label>
                        </div>

                        <div class="dropdown-content-nereden searchInput-btn" id="kategoriDP2">
                            <div class="dropdown-content-inside-nereden finansPopup">
                                <input type="text" id="searchInput2" placeholder="Ara...">

                                <?php 

foreach ($daireler as $daire) {
    if (!empty($daire['katMalikiName'])) {
        echo '<button  data-user-id="' . $daire['daire_id'] ."-". $daire['katMalikiID'] . '">' . $daire['katMalikiName'] . ' ' . $daire['blokAdi'] . ' ' . $daire['dNO'] . ' (Katmaliki)</button>';
    }
    if (!empty($daire['kiraciName'])) {
        echo '                                        
        <button  data-user-id="' . $daire['daire_id'] ."-". $daire['kiraciID'] . '">' . $daire['kiraciName'] . ' ' . $daire['blokAdi'] . ' ' . $daire['dNO'] . ' (Kiraci) </button>';
    }
}
                                   
                                ?>
                            </div>

                        </div>

                    </div>




                </div>

            </div>


        </div>

        <hr class="horizontal dark w-100">

        <div class="row row-btn">
            <button type="button" class="btn-custom-close"
                onclick="popupCloseControl('popupBorcEkle','borcEkleForm')">Kapat</button>
            <button type="button" class="btn-custom" id="saveButton" onclick="borcAdd()">Kaydet</button>
        </div>

    </form>

</div>
















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



//Fatura  yönlkendirme
function fatura() {
    $.ajax({
        url: 'Controller/pdf/gelir_pdf.php', // PHP dosyasının URL'si
        type: 'POST', // İsteğin türü (GET veya POST)
        success: function(response) {
            alert("Başarılı");
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Ayrıntılı hata mesajı
            alert('Bir hata oluştu: ' + textStatus + ' - ' + errorThrown);
            console.log('Hata detayları: ', jqXHR.responseText);
        }
    });


}





// -------------- popup controller ----------------
function popupCloseControl(popupName, popupForm) {

    $('#' + popupForm).css('opacity', '0').css('transform', 'translateY(-180px)').delay(100).queue(function(next) {
        $('#' + popupName).css('opacity', '0').delay(300).queue(function(nextInner) {
            $(this).hide().css('display', 'none');
            nextInner();
            $('body').css('overflow', 'auto');
        });
        next();
    });

}



function popupOpenControl(popupName, popupForm) {

    $('body').css('overflow', 'hidden');

    $('#' + popupName).show().css('display', 'flex').delay(100).queue(function(next) {
        $('#' + popupName).css('opacity', '1');
        $('#' + popupForm).css('opacity', '1');
        $('#' + popupForm).css('transform', 'translateY(0)');
        next();
    });
}


//-----------  AJAX İŞLEMLERİ BORÇ EKLE  ---------------


function borcAdd() {
    var temp = document.getElementById('kategori2').dataset.userId;
    var t = temp.split("-");
    var apartmanId = document.getElementById('apartmanId').value;
    var userId = t[1];
    var daireId = t[0];;
    var gelir_turu = 1;
    var aciklamaValue = document.getElementById('aciklama').value;
    var borcTutarValue = document.getElementById('borcTutar').value;
    var dateInputValue = document.getElementById('dateInput').value;
    var dateInput2Value = document.getElementById('dateInput2').value;
    var kategoriAd = document.getElementById('kategori').value;

    if (kategoriAd == "" || kategoriAd == null) {
        var kategoriValue = "";
    } else {
        var kategoriValue = document.getElementById('kategori').dataset.userId;
    }

    alert(kategoriValue);

    var a1 = true,
        a2 = true,
        a3 = true,
        a4 = true,
        a5 = true,
        a6 = true;


    if (aciklamaValue.trim() === '') {
        $('#aciklama').css('border-color', 'red');
        $('#aciklamaLabel').css('color', 'red');
        a1 = false;
    }

    if (borcTutarValue.trim() === '' || borcTutarValue <= 0) {
        $('#borcTutar').css('border-color', 'red');
        $('#borcLabel').css('color', 'red');
        a2 = false;
    }

    if (dateInputValue.trim() === '') {
        $('#dateInput').css('border-color', 'red');
        $('#label_tarih').css('color', 'red');
        a3 = false;
    }

    if (dateInput2Value.trim() === '') {
        $('#dateInput2').css('border-color', 'red');
        $('#label_tarih2').css('color', 'red');
        a4 = false;
    }


    if (kategoriValue.trim() === '') {
        $('#kategori').css('border-color', 'red');
        $('#kategoriLabel').css('color', 'red');
        a5 = false;
    }

    if (!a5 || !a4 || !a1 || !a3 || !a2) {
        alert("İlgili Alanlar Boş Olamaz");

    } else {

        $.ajax({
            url: 'Controller/maliye_kayit.php',
            type: 'POST',
            data: {
                daireId: daireId,
                userId: userId,
                apartmanId: apartmanId,
                gelir_turu: gelir_turu,
                aciklamaValue: aciklamaValue,
                borcTutarValue: borcTutarValue,
                dateInputValue: dateInputValue,
                dateInput2Value: dateInput2Value,
                kategoriValue: kategoriValue,

            },
            success: function(response) {
                if (response) {
                    document.getElementById('aciklama').value = "";
                    document.getElementById('borcTutar').value = "";
                    document.getElementById('kategori').value = "";
                    popupCloseControl('popupBorcEkle', 'borcEkleForm');
                    location.reload();
                }


            },
            error: function(xhr, status, error) {
                var errorMessage = xhr.status + ': ' + xhr.statusText;
                alert('Hata alındı: ' + errorMessage);
            }
        });




    }





}




function onlyNumberKey(evt) {
        // Prevents the default action of the key pressed
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;

        // Allows only digits, comma, and backspace keys
        if (charCode > 31 && (charCode != 44) && (charCode < 48 || charCode > 57))
            return false;

        // Ensures only one decimal point
        if (charCode == 44) {
            if (evt.target.value.indexOf(',') !== -1 || evt.target.value.indexOf('.') !== -1)
                return false;
        }

        // Limits to two decimal places after comma or dot
        if (evt.target.value.indexOf(',') !== -1 || evt.target.value.indexOf('.') !== -1) {
            var dotIndex = evt.target.value.indexOf(',') !== -1 ? evt.target.value.indexOf(',') : evt.target.value
                .indexOf('.');
            var afterDotLength = evt.target.value.length - dotIndex;
            if (afterDotLength > 2)
                return false;
        }

        return true;
    }
    function selectInput(input) {
        input.select();

    }
</script>
<script src="assets/js/mycode/dropdown.js"></script>
<script>
dropDownn('kategori', 'kategoriDP', 'searchInput');
dropDownn('kategori2', 'kategoriDP2', 'searchInput2');
</script>