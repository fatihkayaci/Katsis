<?php
$idapartman =$_SESSION["apartID"];


$sql = "SELECT * FROM tbl_users WHERE apartman_id = " . $idapartman. " AND rol = 3";



$stmt = $conn->prepare($sql);
$stmt->execute();

// Sonuç kümesinin satır sayısını kontrol etme
$UserList = $stmt->fetchAll(PDO::FETCH_ASSOC);
$listt=[];
foreach($UserList as $list){
    $listt[$list['userID']] = $list['userName'];
}

try {
    $sql = "SELECT * FROM tbl_daireler where apartman_id=$idapartman";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Sonuç kümesinin satır sayısını kontrol etme
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        echo '
        <div class="table-responsive-vertical shadow-z-1 cener-table">
        
        <div class="input-group-div">

            <div class="input-group1">
              <button class="btn-custom-outline">Buton</button>
              <button class="btn-custom-outline">Buton</button>
            </div>

            <div class="input-group">
              <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
              <input type="text" class="form-control" placeholder="Arama...">
            </div>
        </div>

            <table id="table" class="table table-hover table-mc-light-blue">
                <thead>
                    <tr>
                        <th><input type="checkbox"/></th>
                        <th>Blok Adı</th>
                        <th>Kapı No</th>
                        <th>Kiracı</th>
                        <th></th>
                        <th>Kat Maliki</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

        ';

        foreach ($result as $row) {

            echo '

            <tbody>
                
                <tr id='.$row["daire_id"].'>

                    <td data-title="Seç"> <input type="checkbox"/></td>

                    <td data-title="Blok Adı">' . $row["blok_adi"] . '</td>

                    <td data-title="Kapı No">' . $row["daire_sayisi"] . '</td>';
                    
                   if($row["kiraciID"]==null) {
                  echo ' <td data-title="0"><button type="button" class="table-a" onclick="openPopup('.$row["daire_id"].',0)">Kiracı ekle + </button></td>';

                   }else{
                    echo ' <td data-title="0">'.$listt[$row["kiraciID"]].' </td>  '; 
                   }
                   
                   echo ' <td data-title="Bakiye">00,0 $</td> ';

                   if($row["katMalikiID"]==null) {
                    echo '<td data-title="1"><button type="button" class="table-a" onclick="openPopup('.$row["daire_id"].',1)">Kat Maliki ekle + </button></td>
                    ';
  
                    }else{
                     echo ' <td data-title="1">'.$listt[$row["katMalikiID"]].' </td>  '; 
                    }



                  echo '  <td data-title="Bakiye">00,0 $</td>

                        <td data-title="Seçenekler">
                            <li class="nav-item dropdown pe-2 d-flex settings">
                                  <a href="javascript:;" class="nav-link text-body nav-link font-weight-bold mb-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                  </a>
                              <ul class="dropdown-menu dropdown-menu-end1 ayar-1 px-1 margin-10" aria-labelledby="dropdownMenuButton">
                                <li class="mb-2">
                                  <a class="dropdown-item border-radius-md" href="javascript:;">
                                    <div class="d-flex">
                                      <div class="my-auto">
                                        <i class="fa-solid fa-pen i-color me-3"></i>
                                      </div>
                                      <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                          <span class="font-weight-bold">Düzenle</span>
                                        </h6>
                                      </div>
                                    </div>
                                  </a>
                                </li>
                                <li class="mb-1">
                                  <a class="dropdown-item border-radius-md" href="../logout">
                                    <div class="d-flex">
                                      <div class="my-auto">
                                        <i class="fa-solid fa-trash i-color me-3"></i>
                                      </div>
                                      <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-0">
                                          <span class="font-weight-bold">Sil</span>
                                        </h6>
                                      </div>
                                    </div>
                                  </a>
                                </li>
                              </ul>
                            </li>
                        </td>
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

    <form id="userForm" class="login-form">

        <h4 class="form-signin-heading" id="pop-head"></h4>
        
        <input type="hidden" id="hiddenDaireID" />
        <input type="hidden" id="turDaire" />

        <div class="row">
            <div class="col-md-12 col-btn">
                <input class="input" type="text" list="Users" id="userInput" oninput="getUserID()" />
                <datalist id="Users">
                    <?php 
                        foreach($UserList as $user){
                            echo '<option data-user-id="' . $user['userID'] . '">' . $user['userName'] . '</option>';
                        }
                    ?>
                </datalist>
                <input class="input" type="date" value="<?php echo date('Y-m-d'); ?>" id="dateInput" />
            </div>

        </div>

        <hr class="horizontal dark w-100">

        <div class="row row-btns">
            <button type="button" class="btn-custom" id="saveButton" onclick="save()">Kaydet</button>
            <button type="button" class="btn-custom-close" onclick="closePopup()">Kapat</button>
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

    document.getElementById("hiddenDaireID").value = daire_id;
    document.getElementById("turDaire").value = tur;


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


    $('#popup2').show().css('display', 'flex').delay(100).queue(function(next) {
        $('#popup2').css('opacity', '1');
        $('#userForm').css('opacity', '1');
        $('#userForm').css('transform', 'translateY(0)');
        next();
    });
}

function closePopup() {
    document.getElementById("userInput").value = "";
    $('#userInput').css('border-color', '#000000');
    $('#userInput').focus(function() {
        $(this).css('border-color', '#3BB4D7');
    });
 
    $('#userForm').css('opacity', '0').css('transform', 'translateY(-180px)').delay(100).queue(function(next) {
        $('#popup2').css('opacity', '0').delay(300).queue(function(nextInner) {
            $(this).hide().css('display', 'none');
            nextInner();
        });
        next();
    });
}


let selectedValue;

document.getElementById('userInput').addEventListener('input', function() {
    selectedValue = this.value;
});
</script>



<script>
var selectedUserID;

function getUserID() {
    var userInput = document.getElementById("userInput");
    var selectedOption = getSelectedOption(userInput);

    if (selectedOption) {
        selectedUserID = selectedOption.getAttribute("data-user-id");
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



function save() {
    var userr = document.getElementById('userInput').value;
    var turr = document.getElementById("turDaire").value;
    var kTarih = document.getElementById("dateInput").value;
    var daireID = document.getElementById("hiddenDaireID").value;

    if (selectedUserID === undefined || userr === null || userr === "") {
        $('#userInput').css('border-color', 'red');
    } else {
        $.ajax({

            url: 'Controller/user_assignment.php',
            type: 'POST',
            data: {
                userID1: selectedUserID,
                kTarih: kTarih,
                daireID: daireID,
                turr: turr,

            },
            success: function(response) {
                closePopup();
                var trElement = document.getElementById(daireID);

                // <td> elemanlarını seç
                var tdElements = trElement.getElementsByTagName('td');

                if(turr == 0){
                    tdElements[3].innerText ="";
                    tdElements[3].innerText =response;
                }else if(turr == 1){
                    tdElements[4].innerText ="";
                    tdElements[4].innerText =response;
                }


               
            },
            error: function(error) {
                console.error(error);
            }

        });
    }




}
</script>

<script type="text/javascript">
    $.fn.extend({
        alterCheck: function(tablo) {
            if ($("" + tablo + " input[type='checkbox']:first").is(":checked")) {
                return this.each(function() {
                    this.checked = true;
                });
            } else {
                return this.each(function() {
                    this.checked = false;
                });
            }
        }

    });
    $("#table input[type='checkbox']:first").click(function() {
        $("#table input[type='checkbox']").alterCheck('#table');
    });
</script>