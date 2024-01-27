<?php
$idapartman =$_SESSION["apartID"];


$sql = "SELECT * FROM tbl_users WHERE apartman_id = " . $idapartman. " AND rol = 3";

$stmt = $conn->prepare($sql);
$stmt->execute();

// Sonuç kümesinin satır sayısını kontrol etme
$UserList = $stmt->fetchAll(PDO::FETCH_ASSOC);



try {
    $sql = "SELECT * FROM tbl_daireler where apartman_id=$idapartman";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Sonuç kümesinin satır sayısını kontrol etme
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        echo '
        <div class="table-responsive-vertical shadow-z-1">
            <table id="table" class="table table-hover table-mc-light-blue">
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

        ';

        foreach ($result as $row) {

            echo '

            <tbody>
                
                <tr id='.$row["daire_id"].'>

                    <td  data-title="ID"> <input type="checkbox"/></td>

                    <td  data-title="Blok Adı">' . $row["blok_adi"] . '</td>

                    <td  data-title="Kapı No">' . $row["daire_sayisi"] . '</td>
                    
                    <td  data-title="Kiracı"><button type="button" class="table-a" onclick="openPopup('.$row["daire_id"].',0)">Kiracı ekle + </button></td>
                    
                    <td  data-title="Kat Maliki"><button type="button" class="table-a" onclick="openPopup('.$row["daire_id"].',1)">Kat Maliki ekle + </button></td>

                    <td data-title="Bakiye">00,0 $</td>

                </tr>';
        }

    echo '      </tbody>
            </table>
        </div>
            ';
    } else {
        echo "0 results";
    }
} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
?>


<!-- Popup kiracı ve kat maliki eklemek için-->
<div id="popup2" class="form-popup">

    <form id="userForm" class="login-form1">

        <h4 class="form-signin-heading" id="pop-head"></h4>

        <hr class="horizontal dark mt-0 w-100">

        <div class="row">

            <div class="col-md-6 col">
                <input class="input" type="text" list="Users" id="userInput" oninput="getUserID()" />
                <datalist id="Users">
                    <?php 
                        foreach($UserList as $user){
                            echo '<option data-user-id="' . $user['userID'] . '">' . $user['userName'] . '</option>';
                        }
                    ?>
                </datalist>
            </div>

        </div>
        
        <div class="row">

            <div class="col-md-6 col">
            <input class="input" type="date" value="<?php echo date('Y-m-d'); ?>" id="dateInput" />

                
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


<script>
closePopup();

function openPopup(daire_id, tur) {
    // Belirli bir ID'ye sahip <tr> elementini seç
    var trElement = document.getElementById(daire_id);

    // <td> elemanlarını seç
    var tdElements = trElement.getElementsByTagName('td');

    // İlgili <td> elemanlarının içeriğini al
    var blokName = tdElements[1].innerText; // A
    var No = tdElements[2].innerText; // 1

    var head = " " + blokName + " Blok - No: " + No;
    if (tur == 0) {
        head += " (Kiracı)";
    } else if (tur == 1) {
        head += " (Kat Maliki)";
    }

    $('#pop-head').html(head);



    $('#popup2').show();
    $('#popup2').css('display', 'flex');
}

function closePopup() {
    $('#popup2').hide();
}

new DataTable('#table', {
    initComplete: function() {
        this.api()
            .columns()
            .every(function() {
                let column = this;
                let title = column.footer().textContent;


                let input = document.createElement('input');
                input.placeholder = title;
                column.footer().replaceChildren(input);


                input.addEventListener('keyup', () => {
                    if (column.search() !== this.value) {
                        column.search(input.value).draw();
                    }
                });
            });
    }
});



document.getElementById('userInput').addEventListener('input', function() {
    var selectedValue = this.value;
    console.log(selectedValue);
});
</script>



<script>
function getUserID() {
    var userInput = document.getElementById("userInput");
    var selectedOption = getSelectedOption(userInput);

    if (selectedOption) {
        var selectedUserID = selectedOption.getAttribute("data-user-id");
        console.log("Seçilen Kullanıcının ID'si: " + selectedUserID);
        // Burada istediğiniz işlemleri yapabilirsiniz
    }
}

function getSelectedOption(inputElement) {
    var value = inputElement.value.toLowerCase();
    var options = inputElement.list.options;

    for (var i = 0; i < options.length; i++) {
        if (options[i].value.toLowerCase() === value) {
            return options[i];
        }
    }

    return null;
}
</script>