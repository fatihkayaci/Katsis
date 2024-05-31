   <?php
  $sql = '
  SELECT d.*, b.blok_adi
  FROM tbl_daireler d
  JOIN tbl_blok b ON d.blok_adi = b.blok_id
  WHERE d.apartman_id = :apartman_id
';

// Hazırlanan ifadeyi oluştur
$stmt = $conn->prepare($sql);

// Parametreyi bağla ve sorguyu çalıştır
$stmt->execute(['apartman_id' => $idapartman]);

// Sonuçları çek
$daireler = $stmt->fetchAll();
   
   ?> 
    <input type="hidden" id="hiddenApartman" value=<?php echo $idapartman?> />

    <div class="cener-table">
    <div class="input-group-div">
        <div class="input-group1"></div>
        <div class="input-group1">
            <button class="btnAddindex btn-custom-outline bcoc1" onclick="okuma()">Okuma Ekle</button>
            <button class="saveindesbtn btn-custom-outline bcoc1" onclick="indexSave()">Kaydet</button>
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
                <tr data-userid="" data-d="" id="someId_<?php echo $t ?>" class="git-ac">
                    <td class="table_tt table_td"><?php echo $daire["blok_adi"] ?></td>
                    <td class="table_tt table_td"><?php echo $daire["daire_sayisi"] ?></td>
                    <td class="table_tt table_td aktarTd"><input class="sayac-input" id="ilkindex-<?php echo $t ?>" type="number" value="0" onclick="selectInput(this)"></td>
                    <td class="table_tt table_td aktarTd1"><p>kWH</p></td>
                    <td class="table_tt table_td aktarTd"><input class="sayac-input" id="sonindex-<?php echo $t ?>" type="number" value="0" onclick="selectInput(this)"></td>
                    <td class="table_tt table_td" id="tuketim-<?php echo $t ?>">0</td>
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
        <button class="export-btn excel-btn" id="exportButton"><i class="fa-solid fa-file-excel"></i> Excel'e Aktar</button>
        <div class="input-group1">
            <ul class="pagination"></ul>
        </div>
    </div>
</div>




<!-- =========== iNDEX DEĞERLERİNİN KAYDI AJAX ============= -->

<script>
function okuma(){
    const elements = document.querySelectorAll('.sayac-input');
    const btn = document.querySelector('.btnAddindex');
    const btnSave = document.querySelector('.saveindesbtn');
    const btnAktar = document.querySelector('.aktar-btn');
    btn.setAttribute("onclick", "iptal()");
    btn.style.backgroundColor = "red";
    btn.textContent = "İptal";
    btnSave.style.display = "block";
    btnAktar.style.display = "inline";

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



function iptal(){
    const elements = document.querySelectorAll('.sayac-input');
    const btn = document.querySelector('.btnAddindex');
    const btnSave = document.querySelector('.saveindesbtn');
    const btnAktar = document.querySelector('.aktar-btn');
    btn.setAttribute("onclick", "okuma()");
    btn.style.backgroundColor = "#277CE0";
    btn.textContent = "Okuma Ekle";
    btnSave.style.display = "none";
    btnAktar.style.display = "none";
// Her bir elemanın classList'ine "active" sınıfını ekle
elements.forEach(element => {
  element.classList.remove('active');
});
location.reload();
}

function aktar() {
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












function indexSave(){
    var apartman_id = document.getElementById("hiddenApartman").value;


    
    var apartman_id = document.getElementById("hiddenApartman").value;

$.ajax({
    url: 'Controller/Meters/indexSave.php',
    type: 'POST',
    data: { apartman_id: apartman_id }, 
    success: function(response) {
        alert(response);
    },
    error: function(xhr, status, error) {
        console.error("Error: " + error); 
    }
});


}




</script>
<script>
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