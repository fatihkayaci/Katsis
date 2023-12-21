<div class="form-popup">

    <div class="container form-wrapper">

        <form>
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 class="form-title">Pop-up</h1>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="apartman_adi">Apartman Adı</label>
                    <input type="text" class="form-control" id="apartman_adi"  name="apartman_adi" required>
                </div>
                <div class="form-group col-md-2">
                    <label for="blokSay">blok sayısı</label>
                    <input type="number" class="form-control" id="blokSay" name="blokSay" value="1" max="20" min="1"
                        required>
                    <p id="numberalert"></p>
                </div>
            </div>
            <div class="row" id="table-container">
            </div>
            <button class="btn send-form" onclick="kaydet()">Kaydet</button>
        </form>
    </div>
</div>





<script>
function kaydet() {
    // Prevent the default form submission and page refresh
    event.preventDefault();
alert("vjb");
    var apartman_adi = $('#apartman_adi').val();
    var blokSay = $('#blokSay').val();

    $.ajax({
        url: 'Controller/popupController.php',
        type: 'POST',
        data: {
            apartman_adi: apartman_adi,
            blokSay: blokSay
        },
        success: function(response) {
           alert("wd"+response);
        },
        error: function(xhr, status, error) {
    var errorMessage = xhr.status + ': ' + xhr.statusText + '\n' + error;
    alert("sd"+errorMessage);
}
    });
}

</script>














<script>
$('.form-popup').show();

// HTML sayfasındaki input alanını seç
var inputElement = document.getElementById('blokSay');
var numberalert = document.getElementById('numberalert');
var numberalert2 = document.getElementById('numberalert2');
var tableContainer = document.getElementById('table-container'); // oluşacak tabloyu çağırıyoruz
var enteredNumber = inputElement.value;

tableCreate(enteredNumber);
rowListin(enteredNumber);
// Input alanındaki değeri değiştikçe bu fonksiyonu çağır
inputElement.addEventListener('input', function() {

    var enteredNumber = inputElement.value;
    if (enteredNumber > 20) {
        numberalert.innerHTML = "20'den fazla blok bulunuyorsa iletişime geçiniz";
        enteredNumber.innerHTML = 20;
        tableContainer.innerHTML = '';
    } else if (enteredNumber == "") {
        numberalert.innerHTML = "";
    } else if (enteredNumber <= 0) {
        numberalert.innerHTML = "En az 1 blok ekleyiniz.";
        tableContainer.innerHTML = '';
    } else {
        numberalert.innerHTML = "";
        tableCreate(enteredNumber);
        rowListin(enteredNumber);
    }
    // Alınan değeri konsola yazdır
    console.log('Girilen Sayı: ' + enteredNumber);
});


function tableCreate(rowCount) {

    tableContainer.innerHTML = ''; // Temizleme işlemi, her çağrıda tabloyu sıfırlar.

    // Tablo oluşturma
    var table = document.createElement('table');
    table.setAttribute('border', '1');

    // Başlık satırı ekleme
    var headerRow = table.insertRow(0);
    var blockHeader = headerRow.insertCell(0);
    blockHeader.innerHTML = '<b>Blok</b>';

    var apartmentHeader = headerRow.insertCell(1);
    apartmentHeader.innerHTML = '<b>Daire Sayısı</b>';

    // Satırları oluşturma
    for (var i = 1; i <= rowCount; i++) {
        var row = table.insertRow(i);
        var blockCell = row.insertCell(0);
        blockCell.innerHTML = i;


        var apartmentCell = row.insertCell(1);
        var inputElement = document.createElement('input');
        inputElement.type = 'number';


        inputElement.className = 'form-control' + 'form-group col-md-2';
        inputElement.name = 'daireSayisi';
        inputElement.id = 'row' + i;
        inputElement.required = true;
        apartmentCell.appendChild(inputElement);



        var descreption = row.insertCell(2);
        var descreptionElement = document.createElement('p');
        inputElement.type = 'text';


        descreptionElement.className = 'form-control' + 'form-group col-md-2';
        descreptionElement.name = 'descreption';
        descreptionElement.id = 'row2' + i;
        descreption.appendChild(descreptionElement);
    }

    tableContainer.appendChild(table);

}

function rowListin(enteredNumber) {
    console.log("entered number" + enteredNumber);

    for (var i = 1; i <= enteredNumber; i++) {
        addEventListenerToRow(i);
    }

    function addEventListenerToRow(index) {
        var inputElement = document.getElementById('row' + index);

        if (inputElement) {
            inputElement.addEventListener('input', function() {
                var temp = 'row2' + index;
                console.log("temp " + temp);
                var descreptionElement2 = document.getElementById(temp);

                var girilenSayi2 = this.value;

                if (girilenSayi2 > 1000) {
                    descreptionElement2.innerHTML =
                        "Daire sayısı 1000'den fazla olması durumunda bizimle iletişime geçebilirsiniz.";
                } else if (girilenSayi2 == "") {
                    descreptionElement2.innerHTML = "";
                } else if (girilenSayi2 <= 0) {
                    descreptionElement2.innerHTML = "Daire sayısı 1'den küçük olamaz.";
                } else {
                    descreptionElement2.innerHTML = "";
                }
            });
        }
    }
}
</script>