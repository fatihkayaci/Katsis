
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<div class="form-popup">

    <div class="login-form-start" id="userFormStart">

        <h2 class="form-signin-heading">Apartman Kayıt</h2>
            
        <div class="row">
            <div class="col-md-6 col">
                <input type="text" class="form-controlxy input" id="apartman_adi" name="apartman_adi" required="">
                <label for="apartman_adi">Apartman Adı</label>
            </div>
            <div class="col-md-6 col margint">
                <input type="number" class="form-controlxy input" id="blokSay" name="blokSay" value="1" max="20" min="1" required="">
                <label for="blokSay">blok sayısı</label>                
            </div>
        </div>

        <hr class="horizontal dark mt-4 w-100">
        
        <h2 class="form-signin-heading1">Oluşturulan Bloklar</h2>

        <p id="numberalert"></p>

        <div class="row daire-area" id="table-container">
              
        </div>

        <hr class="horizontal dark mt-4 w-100">

        <div class="row">
            <div class="col-md-12 col-btn">
                <button id="kaydetbtn" class="btn-custom send-form" onclick="kaydet()">Kaydet</button>
            </div>
        </div>

    </div>

</div>





<script>
function kaydet() {

    var tem = 1;
    var tem1 = 1;
    var tem2 = 1;
    var tem3 = 1;
    var BlokArray = [];
    var BloknameArray = [];
    var apartman_adi = $('#apartman_adi').val();
    var blokSay = $('#blokSay').val();

    /* x  */


    var vall1 = document.getElementById('numberalert');

    if (vall1.innerHTML == null || vall1.innerHTML == "" || vall1.innerHTML == " ") {
        tem1 = 1;
        for (var i = 1; i <= blokSay; i++) {
            var vall = document.getElementById('row2' + i);


            if (vall.innerHTML == null || vall.innerHTML == "" || vall.innerHTML == " ") {
                tem = 1;

            } else {
                tem = 0;
                break;
            }
        }

        for (var i = 1; i <= blokSay; i++) {
            var elements = document.getElementsByName('inputText' + i);

            for (var j = 0; j < elements.length; j++) {
                var value = elements[j].value.trim(); // Boşlukları temizle
                BloknameArray.push(value);
                if (value === null || value === "") {
                    tem3 = 0;
                    break;
                }
            }
        }


    } else {
        tem1 = 0;

    }


    for (var i = 1; i <= blokSay; i++) {
        var daireSayisiInput = document.getElementById('row' + i);
        BlokArray.push(daireSayisiInput.value);
    }

    if (apartman_adi == "") {
        tem2 = 0;
    } else {
        tem2 = 1;
    }



    if ((tem + tem1 + tem2 + tem3) == 4) {
        $.ajax({
            url: 'Controller/popupController.php',
            type: 'POST',
            data: {
                apartman_adi: apartman_adi,
                blokSay: blokSay,
                BlokArray: BlokArray,
                BloknameArray: BloknameArray
            },
            success: function(response) {
                alert(response);
                $('.form-popup').hide();
                
            },
            error: function(xhr, status, error) {
                var errorMessage = xhr.status + ': ' + xhr.statusText + '\n' + error;
                alert(errorMessage);
            }
        });

    } else {
        alert("hatalı bilgiler. Kontrol ediniz.")
    }








}
</script>










<script>

      $('.form-popup').show().css('display', 'flex').delay(100).queue(function(next) {
          $('.form-popup').css('opacity', '1');
          $('#userFormStart').css('opacity', '1');
          $('#userFormStart').css('transform', 'translateY(0)');
          next();
      });

// HTML sayfasındaki input alanını seç
var apartmanadi = document.getElementById('apartman_adi');
var inputElement = document.getElementById('blokSay');
var numberalert = document.getElementById('numberalert');
var numberalert2 = document.getElementById('numberalert2');
var tableContainer = document.getElementById('table-container'); // oluşacak tabloyu çağırıyoruz

var enteredNumber = inputElement.value;
tableCreate(enteredNumber);
rowListin(enteredNumber);

var apartmanadi = document.getElementById('apartman_adi'); // apartmanadi'nin doğru bir şekilde alındığından emin olun
inputElement.addEventListener("blur", function() {
    listenNumber(inputElement);
});

inputElement.addEventListener('input', function() {
    var enteredValue = apartmanadi.value.trim();
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

});

function tableCreate(rowCount) {
    tableContainer.innerHTML = ''; // Temizleme işlemi, her çağrıda tabloyu sıfırlar.

    // Tablo oluşturma
    var table = document.createElement('table');

    // Başlık satırı ekleme
    var headerRow = table.insertRow(0);
    var blockHeader = headerRow.insertCell(0);
    blockHeader.innerHTML = '<p>Blok</p>';
    blockHeader.setAttribute("align", "center");

    var apartmentHeader = headerRow.insertCell(1);
    apartmentHeader.innerHTML = '<p>Daire Sayısı</p>';
    apartmentHeader.setAttribute("align", "center");

    // Satırları oluşturma
    for (var i = 1; i <= rowCount; i++) {
        var row = table.insertRow(i);
        
        var input = document.createElement("input");
        input.className = 'form-group form-group input1';
        input.type = "text";
        input.maxLength = 5;
        input.name = "inputText" + i; // Set a unique name for each input if needed
        input.id = 'row3' + i;
        
        var blockCell = row.insertCell(0);
        blockCell.appendChild(input);
        blockCell.setAttribute("align", "center");

        var apartmentCell = row.insertCell(1);
        var inputElement = document.createElement('input');
        inputElement.max = 1000;
        inputElement.min = 1;
        inputElement.className = 'form-group form-group input1';
        inputElement.name = 'daireSayisi';
        inputElement.id = 'row' + i;
        inputElement.value = 1;
        inputElement.required = true;
        
        apartmentCell.appendChild(inputElement);
        apartmentCell.setAttribute("align", "center");

        var descreption = row.insertCell(2);
        var descreptionElement = document.createElement('p');
        inputElement.type = 'text';
        descreptionElement.className = 'form-controlxy' + 'form-group form-control1';
        descreptionElement.name = 'descreption';
        descreptionElement.id = 'row2' + i;
        descreption.appendChild(descreptionElement);
        descreption.setAttribute("align", "center");
    }

    tableContainer.appendChild(table);
}


function rowListin(enteredNumber) {


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




                var temp = 'row2' + index;

                var descreptionElement2 = document.getElementById(temp);

                var girilenSayi2 = this.value;

                if (girilenSayi2 > 1000) {

                    descreptionElement2.innerHTML =
                        "Daire sayısı 1000'den fazla ise bizimle iletişime geçiniz.";

                } else if (girilenSayi2 == "") {
                    descreptionElement2.innerHTML = "";

                } else if (girilenSayi2 <= 0) {
                    descreptionElement2.innerHTML = "Daire sayısı 1'den küçük olamaz.";

                } else if (girilenSayi2 != null || girilenSayi2 != "" || girilenSayi2 != " ") {
                    descreptionElement2.innerHTML = "";

                }
            });
        }

    }
}

function listenNumber(number1) {
    var number = number1.value;
    if (number == null || number == "" || number == " ") {
        number1.value = 1;
        tableCreate(1);
    }
}
</script>