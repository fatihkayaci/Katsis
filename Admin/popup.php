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
                    <input type="text" class="form-control" id="apartman_adi" name="apartman_adi" required>
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
            <button id="kaydetbtn" class="btn send-form" onclick="kaydet()">Kaydet</button>
        </form>
    </div>
</div>





<script>
function kaydet() {
    // Prevent the default form submission and page refresh
    event.preventDefault();

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
            alert(response);
        },
        error: function(xhr, status, error) {
            var errorMessage = xhr.status + ': ' + xhr.statusText + '\n' + error;
            alert("sd" + errorMessage);
        }
    });
}
</script>










<script>
$('.form-popup').show();
disablebtn(true);
// HTML sayfasındaki input alanını seç
var apartmanadi = document.getElementById('apartman_adi');
var inputElement = document.getElementById('blokSay');
var numberalert = document.getElementById('numberalert');
var numberalert2 = document.getElementById('numberalert2');
var tableContainer = document.getElementById('table-container'); // oluşacak tabloyu çağırıyoruz
var oncekideger = 1;
var enteredNumber = inputElement.value;

tableCreate(enteredNumber);
rowListin(enteredNumber);

var apartmanadi = document.getElementById('apartman_adi'); // apartmanadi'nin doğru bir şekilde alındığından emin olun

apartmanadi.addEventListener('input', function() {
    checkInputValue();
});

// Silme işlemi de dahil olacak şekilde kontrol fonksiyonu
function checkInputValue() {
    var enteredValue = apartmanadi.value.trim(); // Boşlukları temizleyerek değeri al
    var enteredNumber = inputElement.value;

    if (enteredValue === "") {
        disablebtn(true);
    } else {
        disablebtn(false);
    }
    if (enteredNumber == null || enteredNumber == "" || enteredNumber == " ") {
        disablebtn(true);
    }
}

// Sayfa yüklendiğinde de kontrol yapmak için
document.addEventListener('DOMContentLoaded', function() {
    checkInputValue();
});
inputElement.addEventListener("blur",function(){
    listenNumber(inputElement);
});
// Input alanındaki değeri değiştikçe bu fonksiyonu çağır
inputElement.addEventListener('input', function() {

    var enteredNumber = inputElement.value;
    if (enteredNumber > 20) {
        numberalert.innerHTML = "20'den fazla blok bulunuyorsa iletişime geçiniz";
        enteredNumber.innerHTML = 20;
        tableContainer.innerHTML = '';
        disablebtn(true);
    } else if (enteredNumber == "") {
        numberalert.innerHTML = "";
        disablebtn(true);
    } else if (enteredNumber <= 0) {
        numberalert.innerHTML = "En az 1 blok ekleyiniz.";
        tableContainer.innerHTML = '';
        disablebtn(true);
    } else {
        numberalert.innerHTML = "";
        tableCreate(enteredNumber);
        rowListin(enteredNumber);
        disablebtn(false);
    }
    // Alınan değeri konsola yazdır
    enteredApartman = apartmanadi.value;
    if (enteredApartman == null || enteredApartman == "" || enteredApartman == " ") {
        if (enteredNumber != oncekideger) {
            disablebtn(true);
            oncekideger = enteredNumber;
        }
    }

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


        var apartmentCell = row.insertCell(1); // Satırın ikinci hücresine erişim sağla
        var inputElement = document.createElement('input'); // input öğesi oluştur
        inputElement.max = 1000;
        inputElement.min = 1;
        inputElement.className = 'form-group form-group col-md-2'; // class adını belirle, boşluğu unutma
        inputElement.name = 'daireSayisi'; // inputun adını belirle
        inputElement.id = 'row' + i; // inputun benzersiz kimliğini belirle
        inputElement.value = 1; // başlangıç değerini belirle
        inputElement.required = true; // zorunlu olup olmadığını belirle,
        inputElement.addEventListener('change', function() {
            var apartmentadivalue = apartmanadi.value;
            if(apartmentadivalue == null || apartmentadivalue == "" || apartmentadivalue == " "){
                disablebtn(true);
            }
        });
        apartmentCell.appendChild(inputElement); // hücreye input öğesini ekle
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
        inputElement.setAttribute('type', 'number');
        
        if (inputElement) {
            inputElement.addEventListener('blur', function() {
                    var girilenSayi2 = this.value;
                    listenNumber(this);
                });
            inputElement.addEventListener('input', function() {
                
                enteredApartman = apartmanadi.value;
                if (enteredApartman == null || enteredApartman == "" || enteredApartman == " " ||
                    enteredNumber == null || enteredNumber == "" || enteredNumber == " ") {
                    disablebtn(true);
                }


                var temp = 'row2' + index;
                console.log("temp " + temp);
                var descreptionElement2 = document.getElementById(temp);

                var girilenSayi2 = this.value;
                
                if (girilenSayi2 > 1000) {

                    descreptionElement2.innerHTML =
                        "Daire sayısı 1000'den fazla olması durumunda bizimle iletişime geçebilirsiniz.";
                    disablebtn(true);
                } else if (girilenSayi2 == "") {
                    descreptionElement2.innerHTML = "";
                    disablebtn(true);
                } else if (girilenSayi2 <= 0) {
                    descreptionElement2.innerHTML = "Daire sayısı 1'den küçük olamaz.";
                    disablebtn(true);
                } else if(girilenSayi2 != null || girilenSayi2 != ""  || girilenSayi2 != " "){
                    descreptionElement2.innerHTML = "";
                    disablebtn(false);
                }
            });
        }
       
    }
}
function listenNumber(number1){
    var number = number1.value;
    if(number == null || number == "" || number == " "){
        number1.value = 1;
    }
}
function disablebtn(activite) {
    var kaydetbtn = document.getElementById("kaydetbtn");
    kaydetbtn.disabled = activite;
    if (activite) {
        kaydetbtn.style.backgroundColor = "red";
    } else {
        kaydetbtn.style.backgroundColor = "green";
    }
}
</script>