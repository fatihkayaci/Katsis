<?php

$idapartman =$_SESSION["apartID"];
try {
    $sql = "SELECT * FROM tbl_daireler where apartman_id=$idapartman";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Sonuç kümesinin satır sayısını kontrol etme
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        echo '<table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th><input type="checkbox"/></th>
                        <th>Blok Adı</th>
                        <th>Kapı No</th>
                        <th>Kiracı</th>
                        <th>Kat Maliki</th>
                        <th>Bakiye</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($result as $row) {
            echo '<tr id='.$row["daire_id"].'>
                    <td> <input type="checkbox"/></td>
                    <td>' . $row["blok_adi"] . '</td>
                    <td>' . $row["daire_sayisi"] . '</td>
                    
                    <td><button type="button" class="btn btn-primary btn-sm btn1" onclick="openPopup('.$row["daire_id"].',0)">Kiracı ekle + </button></td>
                    <td><button type="button" class="btn btn-primary btn-sm btn1" onclick="openPopup('.$row["daire_id"].',1)">Kat Maliki ekle + </button></td>



                    <td></td>

                </tr>';
        }

        echo '</tbody>
            </table>';
    } else {
        echo "0 results";
    }
} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
?>


  <!-- Popup Form -->
    <div id="popup" class="form-popup">

        <form id="userForm" class="login-form1">
        
        <h2 class="form-signin-heading">Kiracı Ekle</h2>

        <hr class="horizontal dark mt-0 w-100">

        <div class="row">
            <div class="col-md-6 col">
                <select class="input" id="durum">
                    <option value="katmaliki">kat Maliki</option>
                    <option value="kiracı">kiracı</option>
                </select>
            </div>
            <div class="col-md-6 col">
                <input  class="input" type="text" list="cars" />
                <datalist id="cars">
                  <option>Volvo</option>
                  <option>Saab</option>
                  <option>Mercedes</option>
                  <option>Audi</option>
                </datalist>
            </div>
        </div>

        <hr class="horizontal dark w-100">
           
        <div class="row row-btns">
                <button type="button" class="btn btnx btn-secondary btn-size" onclick="closePopup()">Kapat</button>       
                <button type="button" class="btn btnx btn-primary btn-size" id="saveButton">Kaydet</button>
        </div>
        
        </form>

    </div>








<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>


<script>
     function openPopup(daire_id, tur) {
        // Belirli bir ID'ye sahip <tr> elementini seç
        var trElement = document.getElementById(daire_id);

        // <td> elemanlarını seç
        var tdElements = trElement.getElementsByTagName('td');

        // İlgili <td> elemanlarının içeriğini al
        var valueA = tdElements[1].innerText; // A
        var value1 = tdElements[2].innerText; // 1

        // Değerleri konsola yazdır (isteğe bağlı)
        console.log('Value of A:', valueA);
        console.log('Value of 1:', value1);
        console.log('tur :', tur);

            $('#popup').show();
            $('#popup').css('display', 'flex');
        }

        function closePopup() {
            $('#popup').hide();
        }

   new DataTable('#example', {
    initComplete: function () {
        this.api()
            .columns()
            .every(function () {
                let column = this;
                let title = column.footer().textContent;

                // Create input element
                let input = document.createElement('input');
                input.placeholder = title;
                column.footer().replaceChildren(input);

                // Event listener for user input
                input.addEventListener('keyup', () => {
                    if (column.search() !== this.value) {
                        column.search(input.value).draw();
                    }
                });
            });
    }
       });
</script>





<script type="text/javascript">
$.fn.extend({
 alterCheck:function(tablo){
  if($(""+tablo+" input[type='checkbox']:first").is(":checked")){
   return this.each(function(){

	this.checked=true;
    
   });
  }else{
   return this.each(function(){
    this.checked=false;
   });
  }		
 }	
});

$("#example input[type='checkbox']:first").click(function(){
 $("#example input[type='checkbox']").alterCheck('#example');
});
</script>
