
<div class="form-popup">

<div class="container form-wrapper">
				
				<form id="my-form" novalidate="novalidate">
					<div class="row">
						<div class="col-md-12 text-center">
							<h1 class="form-title">Pop-up</h1>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							<label for="name">Apartman Adı</label>
							<input type="text" class="form-control" id="name" name="name"  required>
						</div>
						<div class="form-group col-md-2">
							<label for="blokSay">blok sayısı</label>
							<input type="number" class="form-control" id="blokSay" name="blokSay" value="1" max="20" min="1" required>
							<p id="numberalert"></p>
						</div>
					</div>
					<div class="row" id ="table-container">
					</div>
			<!--		<div class="form-check">
						<label>
						<input type="checkbox" name="formcheck" checked="" class="checkfz" required=""> Submit<br>
						</label>
					</div>  -->
					<button type="submit" class="btn send-form">Send</button>
				</form>
			</div>
		</div>


        <script>

$('.form-popup').show();

    // HTML sayfasındaki input alanını seç
    var inputElement = document.getElementById('blokSay');
	var numberalert = document.getElementById('numberalert');
	var tableContainer = document.getElementById('table-container'); // oluşacak tabloyu çağırıyoruz
	var enteredNumber = inputElement.value;
	tableCreate(enteredNumber);
    // Input alanındaki değeri değiştikçe bu fonksiyonu çağır
    inputElement.addEventListener('input', function() {
        // Input alanındaki değeri al
        tableCreate(enteredNumber);
		var enteredNumber = inputElement.value;
		if(enteredNumber > 20){
			numberalert.innerHTML="20'den fazla blok bulunuyorsa iletişime geçiniz";
			enteredNumber.innerHTML=20;
			tableContainer.innerHTML = ''; 
		}else if(enteredNumber == ""){
			numberalert.innerHTML="";
		}
		else if(enteredNumber <= 0){
			numberalert.innerHTML="En az 1 blok ekleyiniz.";
			tableContainer.innerHTML = ''; 
		}
		else{
			numberalert.innerHTML="";
			tableCreate(enteredNumber);
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
            inputElement.className = 'form-control';
            inputElement.name = 'daireSayisi';
            inputElement.required = true;
            apartmentCell.appendChild(inputElement);
        }

        tableContainer.appendChild(table);
		
	}
</script>