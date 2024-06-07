<?php
require_once "Controller/class.func.php";

try {
    if(isset($_GET['tur'])) {
        $tur_php=$_GET['tur'];
    }else{
        $tur_php="elektrik";
    }
    // SQL sorgusu için parametre kullanımı
    $sql = "
      SELECT d.*, b.blok_adi, s.ilk_index, s.son_index, s.tuketim, s.okuma_tarih
      FROM tbl_daireler d
      JOIN tbl_blok b ON d.blok_adi = b.blok_id
      LEFT JOIN tbl_sayac_$tur_php s ON d.daire_id = s.daire_id
      WHERE d.apartman_id = :apartman_id 
    ";

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare($sql);
    $stmt->execute(['apartman_id' => $idapartman]);

    // Fetch all the results
    $daireler = $stmt->fetchAll();
} catch (PDOException $e) {
    // Hata varsa yakalayıp işleyebiliriz
    echo "Hata: " . $e->getMessage();
}
?>



<input type="hidden" id="hiddenApartman" value="<?php echo $idapartman ?>" />
<input type="hidden" id="btnprm" value="<?php echo $tur_php ?>" />

<div class="cener-table">
    <div class="input-group-div">
        <div class="input-group1 w-50">
            <div class="sayac-btn-slide">
                <button id="elektrik" class=" btn-custom-outline  sayaczero " onclick="sayacTuru('elektrik')">Elektrik</button>
                <button id="su" class=" btn-custom-outline  sayaczero" onclick="sayacTuru('su')">Su</button>
                <button id="sicaksu" class=" btn-custom-outline  sayaczero" onclick="sayacTuru('sicaksu')">Sıcak Su</button>
                <button id="kalorimetre" class=" btn-custom-outline  sayaczero" onclick="sayacTuru('kalorimetre')">Kalorimetre</button>
                <button id="payolcer" class=" btn-custom-outline  sayaczero" onclick="sayacTuru('payolcer')">Pay Ölçer</button>
            </div>
        </div>
        <div class="input-group1">
          <button class="btnAddindex btn-custom-outline sayacClr" onclick="okuma()">Sayaç Oku</button>
          <button class="saveindesbtn btn-custom-outline sayacClr" onclick="indexSave('<?php echo $tur_php; ?>')">Kaydet</button>
        </div>
  </div>

  <hr class="horizontal dark mb-1 w-100">

  <div class="table-overflow">
    <table id="example" class="users-table center-txt">
      <thead>
        <tr class="users-table-info">
          <th>No</th>
          <th>Daire</th>
          <th>İlk Endeks</th>
          <th><button class="aktar-btn" onclick="aktar()"><i class="fa-solid fa-left-long"></i></button></th>
          <th>Son Endeks</th>
          <th>Tüketim</th>
        </tr>
      </thead>
      <tbody>
        <?php $t = 0; foreach($daireler as $daire ){ ?>
        <tr data-userid="<?php echo $daire["daire_id"] ?>" data-d="" id="someId_<?php echo $t ?>" class="git-ac">
          <td class="table_tt table_td" id="blokAdi-<?php echo $t ?>" ><?php echo $daire["blok_adi"] ?></td>
          <td class="table_tt table_td" id="dairesayisi-<?php echo $t ?>"><?php echo $daire["daire_sayisi"] ?></td>
          <td class="table_tt table_td aktarTd">
            <input class="sayac-input" id="ilkindex-<?php echo $t ?>" type="number" value="<?php echo $daire["ilk_index"] != null ? $daire["ilk_index"] : "0";
 ?>" onclick="selectInput(this)">
          </td>
          <td class="table_tt table_td aktarTd1">
            <p><?php 
            if($tur_php == "su" || $tur_php == "sicaksu"){
                echo "m³";
            }else{
                echo "kWH";
            }  
                
                ?></p>
          </td>
          <td class="table_tt table_td aktarTd">
            <input class="sayac-input" id="sonindex-<?php echo $t ?>" type="number" value="<?php echo $daire["son_index"] != null ? $daire["son_index"] : "0";
 ?>" onclick="selectInput(this)">
          </td>
          <td class="table_tt table_td" id="tuketim-<?php echo $t ?>"><?php echo $daire["tuketim"] != null ? $daire["tuketim"] : "0";
 ?></td>
        </tr>
        <?php $t++; } ?>
      </tbody>
    </table>
  </div>

       <hr class="horizontal dark mb-1 w-100">

       <div class="input-group-div">
           <div class="input-group1">
               <select id="rowsPerPageSelect">
                   <option value="10">10</option>
                   <option value="20">20</option>
                   <option value="50">50</option>
                   <option value="100">100</option>
               </select>
               <p class="adet-txt">Adet Veri Gösteriliyor</p>
           </div>
           <div class="input-group1">
    <p class="adet-txt" style="color: black;"><?php echo formatDatetime($daireler[0]["okuma_tarih"]);?> Tarihinde Sayaçlar Okundu.</p>
</div>

           <button class="export-btn excel-btn" id="exportButton"><i class="fa-solid fa-file-excel"></i> Excel'e
               Aktar</button>
           <div class="input-group1">
               <ul class="pagination"></ul>
           </div>
       </div>
   </div>




   <!-- =========== iNDEX DEĞERLERİNİN KAYDI AJAX ============= -->

<script>

document.addEventListener('DOMContentLoaded', function() {
    var btnprm = document.getElementById('btnprm').value;
    if(btnprm ==null || btnprm ==""){
        btnprm="elektrik";
    }
    var btn = document.getElementById(btnprm);
    btn.classList.add("sayacClr");
});



function sayacTuru(veri){
   
window.location.href = "index?parametre=meters&tur=" + veri;

}


function okuma() {
   
    const btn = document.querySelector('.btnAddindex');
    const btnSave = document.querySelector('.saveindesbtn');
    const btnAktar = document.querySelector('.aktar-btn');
    btn.setAttribute("onclick", "iptal()");
    btn.style.backgroundColor = "red";
    btn.textContent = "İptal";
    btnSave.style.display = "block";
    btnAktar.style.display = "inline";

    const elements = document.querySelectorAll('.sayac-input');
    // Tüm .sayac-input öğelerine "active" sınıfını ekle
    elements.forEach(element => {
        element.classList.add('active');
    });

    // Tüm tablo satırlarına "active" sınıfını ekle
    const allRows = document.querySelectorAll('.users-table tbody tr');
    allRows.forEach(row => {
        row.classList.add('active');
    });
}



function iptal() {
    const elements = document.querySelectorAll('.sayac-input');
    const btn = document.querySelector('.btnAddindex');
    const btnSave = document.querySelector('.saveindesbtn');
    const btnAktar = document.querySelector('.aktar-btn');
    btn.setAttribute("onclick", "okuma()");
    btn.style.backgroundColor = "#277CE0";
    btn.textContent = "Sayaç Oku";
    btnSave.style.display = "none";
    btnAktar.style.display = "none";
    // Her bir elemanın classList'ine "active" sınıfını ekle
    elements.forEach(element => {
        element.classList.remove('active');
    });
    location.reload();
}

function aktar() {

    var confirmAction = confirm("Son endeks değerini ilk endek değerine atayacaksınız, emin misiniz?");
    if (confirmAction) {
        var rows = document.querySelectorAll('.git-ac'); // Tablodaki her satırı seç

        rows.forEach(function(row, index) { // Her bir satır için işlem yap
           
            var sonindexInput = document.getElementById('sonindex-' + index);
            var ilkindexInput = document.getElementById('ilkindex-' + index);
            var sonindex = parseFloat(sonindexInput.value); // sonindex değerini al



            ilkindexInput.value = sonindex; // ilkindex alanına yaz

            // Tüketim hesabı yap
            var tuketim = document.getElementById('tuketim-' + index);
            var ilkIndexValue = parseFloat(ilkindexInput.value);
            if (sonindex >= ilkIndexValue) {
                tuketim.textContent = (sonindex - ilkIndexValue);
            } else {
                tuketim.textContent = "0";
            }
        });

    }

}



function selectInput(input) {
    input.select();
}

// Tıklanan input alanını seç
const inputs = document.querySelectorAll('.sayac-input');
inputs.forEach(input => {
    input.addEventListener('click', function() {
        selectInput(this);
    });
});

// Yeni bir değer girildiğinde işlem yap
inputs.forEach(input => {
    input.addEventListener('input', function() {
        const index = this.id.split('-')[1]; // ID'den index değerini al
        const sonIndexInput = document.getElementById('sonindex-' + index);
        const sonIndex = parseFloat(sonIndexInput.value);
        const ilkIndex = parseFloat(document.getElementById('ilkindex-' + index).value);
        const tuketim = document.getElementById('tuketim-' + index);


        // İlk index değeri büyükse tüketim hesabı yapılır, aksi takdirde tüketim sıfır olarak ayarlanır.
        tuketim.textContent = (sonIndex - ilkIndex);
    });
});












function indexSave(temp) {
    alert(temp);
    var apartman_id = document.getElementById("hiddenApartman").value;
    const rows = document.querySelectorAll('.git-ac'); // Tablodaki tüm satırları seçiyoruz
    let formData = new FormData();
    let negativeValues = [];

    // Apartman ID'yi form verilerine ekleyin
    formData.append('temp', temp);
    formData.append('apartman_id', apartman_id);

    rows.forEach(row => {
        const rowId = row.id.split('_')[1]; // Satır ID'sinden index değerini alıyoruz
        const daireId = row.dataset.userid; // data-userid değerini alıyoruz
   

        const blokAdi = document.getElementById(`blokAdi-${rowId}`).textContent;
    const dairesayisi = document.getElementById(`dairesayisi-${rowId}`).textContent;
        const ilkIndex = document.getElementById(`ilkindex-${rowId}`).value;
        const sonIndex = document.getElementById(`sonindex-${rowId}`).value;
        const tuketimElement = document.getElementById(`tuketim-${rowId}`);
        const tuketim = parseFloat(tuketimElement.innerText);

        // Değerleri form verilerine ekliyoruz
        formData.append(`daireler[${rowId}][daireId]`, daireId);
        formData.append(`daireler[${rowId}][ilkIndex]`, parseFloat(ilkIndex));
        formData.append(`daireler[${rowId}][sonIndex]`, parseFloat(sonIndex));
        formData.append(`daireler[${rowId}][tuketim]`, tuketim);

        // Tüketim değeri negatifse input çevresine kırmızı border yap
        if (tuketim < 0) {
            document.getElementById(`ilkindex-${rowId}`).style.border = '2px solid red';
            document.getElementById(`sonindex-${rowId}`).style.border = '2px solid red';
            
            negativeValues.push("\n"+blokAdi + " BLOK NO: " + dairesayisi );

        } else {
            document.getElementById(`ilkindex-${rowId}`).style.border = '';
            document.getElementById(`sonindex-${rowId}`).style.border = '';
            tuketimElement.style.border = '';
        }
    });

    // Negatif değerler varsa alert çıkar ve işlemi durdur
    if (negativeValues.length > 0) {
        alert("Son Okuma Değeri İlk Okuma Değerinden Küçük Olamaz! \nŞu Dairedeki Verileri Kontrol Ediniz: " + negativeValues.join(' '));
        return;
    }

    $.ajax({
        url: 'Controller/Meters/indexSave.php',
        type: 'POST',
        data: formData,
        processData: false, // FormData kullanırken gereklidir
        contentType: false, // FormData kullanırken gereklidir
        success: function(response) {
            alert(response);
            const btn = document.querySelector('.btnAddindex');
    const btnSave = document.querySelector('.saveindesbtn');
    const btnAktar = document.querySelector('.aktar-btn');
    btn.setAttribute("onclick", "okuma()");
    btn.style.backgroundColor = "#277CE0";
    btn.textContent = "Okuma Ekle";
    btnSave.style.display = "none";
    btnAktar.style.display = "none";
            const elements = document.querySelectorAll('.sayac-input');
    // Tüm .sayac-input öğelerine "active" sınıfını ekle
    elements.forEach(element => {
        element.classList.remove('active');
    });

    // Tüm tablo satırlarına "active" sınıfını ekle
    const allRows = document.querySelectorAll('.users-table tbody tr');
    allRows.forEach(row => {
        row.classList.remove('active');
    });
        },
        error: function(xhr, status, error) {
            console.error("Error: " + error);
        }
    });
}

   </script>



   <script>
    //Tablonun gruplandırılması 10,20 vs.
document.addEventListener('DOMContentLoaded', function() {
    const rowsPerPageSelect = document.getElementById('rowsPerPageSelect');
    const table = document.getElementById('example');
    const tbody = table.querySelector('tbody');
    let rows = Array.from(tbody.querySelectorAll('tr'));
    let currentPage = 1;
    let rowsPerPage = parseInt(rowsPerPageSelect.value);

    function displayPage(page) {
        let start = (page - 1) * rowsPerPage;
        let end = start + rowsPerPage;
        for (let i = 0; i < rows.length; i++) {
            if (i >= start && i < end) {
                rows[i].removeAttribute('hidden');
            } else {
                rows[i].setAttribute('hidden', 'true');
            }
        }
        currentPage = page;

        updatePagination();
    }


    function updatePagination() {
        const pagination = document.querySelector('.pagination');
        pagination.innerHTML = '';

        let totalPages = Math.ceil(rows.length / rowsPerPage);
        for (let i = 1; i <= totalPages; i++) {
            let pageItem = document.createElement('a');
            pageItem.textContent = i;
            pageItem.href = "#";
            if (i === currentPage) {
                pageItem.classList.add('current-number');
            }
            pageItem.addEventListener('click', function(event) {
                event.preventDefault();
                displayPage(i);
            });
            pagination.appendChild(pageItem);
        }
    }

    rowsPerPageSelect.addEventListener('change', function() {
        rowsPerPage = parseInt(rowsPerPageSelect.value);
        displayPage(1); // Always reset to page 1 when changing rows per page
    });

    displayPage(currentPage);
});


   </script>

   




   </body>

   </html>