<?php
$idapartman =$_SESSION["apartID"];

?>
<input type="hidden" id="hiddenDaireID2" value=<?php echo $idapartman?> />

<?php
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
$sql = "SELECT * FROM tbl_blok WHERE apartman_idd = " . $idapartman;
$stmt = $conn->prepare($sql);
$stmt->execute();

$blokList=[];
$blokList = $stmt->fetchAll(PDO::FETCH_ASSOC);

}catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}


try {
    $sql = "SELECT * FROM tbl_daireler where apartman_id=$idapartman";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Sonuç kümesinin satır sayısını kontrol etme
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
    ?>

<div class="table-responsive-vertical cener-table">

    <div class="input-group-div">

        <div class="input-group1">
            <button class="btn-custom-outline" onclick="openPopupBlok()">Bloklar</button>
            <button class="btn-custom-outline" onclick="openPopupDaire()">Daire Ekle</button>

        </div>

        <div class="search-box">
            <i class="fas fa-search search-icon" aria-hidden="true"></i>
            <input type="text" class="search-input" placeholder="Arama...">
        </div>
    </div>

    <table id="table" class="table table-hover">
        <thead>
            <tr>
                <th><input type="checkbox" /></th>
                <th>Blok Adı</th>
                <th>Kapı No</th>
                <th>Kiracı</th>
                <th></th>
                <th>Kat Maliki</th>
                <th></th>
                <th></th>
            </tr>
        </thead>

        <?php

        foreach ($result as $row) {

        ?>

        <tbody>

            <tr id=<?php echo $row["daire_id"]; ?>>

                <td data-title="Seç"> <input type="checkbox" /></td>

                <td data-title="Blok Adı"><?php echo $row["blok_adi"]; ?></td>

                <td data-title="Kapı No"><?php echo $row["daire_sayisi"]; ?></td>

                <?php
                   if($row["kiraciID"]==null) {
                  echo ' <td data-title="0"><button type="button" class="table-a" onclick="openPopup('.$row["daire_id"].',0)">Kiracı ekle + </button></td>';

                   }else{
                    echo ' <td data-title="0">'.$listt[$row["kiraciID"]].' </td>  '; 
                   }
                   
                   echo ' <td data-title="Bakiye">00,0 ₺</td> ';

                   if($row["katMalikiID"]==null) {
                    echo '<td data-title="1"><button type="button" class="table-a" onclick="openPopup('.$row["daire_id"].',1)">Kat Maliki ekle + </button></td>
                    ';
  
                    }else{
                     echo ' <td data-title="1">'.$listt[$row["katMalikiID"]].' </td>  '; 
                    }

                ?>

                <td data-title="Bakiye">00,0 ₺</td>

                <td data-title="Seçenekler">
                    <li class="nav-item dropdown pe-1 d-flex settings">
                        <a href="javascript:;" class="nav-link text-body nav-link font-weight-bold mb-0"
                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end1 ayar-1 px-1 margin-10"
                            aria-labelledby="dropdownMenuButton">
                            <li class="mb-1">
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
                            <li class="mb-0">
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
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
<?php
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

        <h2 class="form-signin-heading" id="pop-head"></h2>

        <input type="hidden" id="hiddenDaireID" />
        <input type="hidden" id="turDaire" />

        <div class="row">
            <div class="col-md-12 col-btn">
                <input class="input" type="text" list="Users" id="userInput" required="" oninput="getUserID()" />
                <datalist id="Users">
                    <?php 
                        foreach($UserList as $user){
                            echo '<option data-user-id="' . $user['userID'] . '">' . $user['userName'] . '</option>';
                        }
                    ?>
                </datalist>
                <label for="userInput">Kullanıcılar :</label>
            </div>
            <div class="col-md-12 col-btn">
                <input class="input" type="date" value="<?php echo date('Y-m-d'); ?>" id="dateInput" required=""/>
                <label id="label_tarih" for="dateInput">1</label>
            </div>

        </div>

        <hr class="horizontal dark w-100">

        <div class="row row-btn">
            <button type="button" class="btn-custom-close" onclick="closePopup()">Kapat</button>
            <button type="button" class="btn-custom" id="saveButton" onclick="save()">Kaydet</button>
        </div>

    </form>

</div>


<!-- Popup daire eklemek için-->
<div id="popupDaireEkle" class="form-popup">

    <form id="userFormDaire" class="login-form">

        <h2 class="form-signin-heading">Daire Ekle</h2>

        <input type="hidden" id="hiddenDaireID" />
        <input type="hidden" id="turDaire" />

        <div class="row">
            <div class="col-md-6 col-btn">
                <input class="input" type="text"  id="userInput"  required="" />
                <label for="userInput">No :    *</label>
            </div>

            <div class="col-md-6 col">
                <input class="input" type="text"  id="userInput" required="" />
                <label for="userInput">Kat :</label>
            </div>
            <div class="col-md-6 col">
                <input class="input" type="text"  id="userInput"  required="" />
                <label for="userInput">Blok :    *</label>
            </div>
            <div class="col-md-6 col">
                <input class="input" type="text"  id="userInput" required="" />
                <label for="userInput">Daire Grubu :</label>
            </div>
            <div class="col-md-6 col">
                <input class="input" type="text"  id="userInput" required=""/>
                <label for="userInput">Brüt m² :</label>
            </div>
            <div class="col-md-6 col">
                <input class="input" type="text"  id="userInput"  required=""/>
                <label for="userInput">Net m² :</label>
            </div>
            <div class="col-md-6 col">
                <input class="input" type="text"  id="userInput" required="" />
                <label for="userInput">Arsa Payı :</label>
            </div>
            
        </div>

        <hr class="horizontal dark w-100">

        <div class="row row-btn">
            <button type="button" class="btn-custom-close" onclick="closePopupDaire()">Kapat</button>
            <button type="submit" class="btn-custom" id="saveButton" >Kaydet</button>
        </div>

    </form>

</div>



<!-- Popup blok eklemek için-->
<div id="popupBlokEkle" class="form-popup">

    <form id="userFormBlok" class="login-form">

        <h2 class="form-signin-heading">Bloklar</h2>

        <div class="row">

            <div class="col-blok w-70">
                <input class="input min-w mb-0" type="text" id="blokInput" maxLength="5" required=""/>
                <label for="blokInput">Blok Ekle :</label>
            </div>

            <div class="col-blok w-30">
                <button type="button" class="btn-custom-daire ekle-btn blok-btn" id="saveButton" onclick="saveBlok()">Ekle</button>
            </div>
        </div>

        <hr class="horizontal mt-0 dark w-100">

        <table class="table-blok">
            <tr>
                <th>Blok Adı </th>
                <th>Daire Sayısı </th>
                <th>Sil</th>
                <th>Düzenle</th>
            </tr>
            <tr id="mainTr">
                <?php  foreach ($blokList as $s ){
                        echo '
                        <tr id="blk-'.$s["blok_id"].'">
                            <td>'.$s["blok_adi"].'</td>
                            <td>'.$s["daire_sayisi"].'</td>
                            <td>  
                                <span class="blok-ico" onclick="deleteBlok('.$s["blok_id"].')"><i class="fa-solid fa-trash"></i></span>
                            </td> 
                            <td>
                                <span class="blok-ico" onclick="editBlok('.$s["blok_id"].')"      ><i class="fa-solid fa-pen"></i></span> 
                            </td>
                        </tr>
                        ';

                  }  ?>

            </tr>

        </table>

        <hr class="horizontal dark w-100">

        <div class="row row-btn">
                <button type="button" class="btn-custom-close w-100 me-0" onclick="closePopupBlok()">Kapat</button>
        </div>

    </form>

</div>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>


<script>
closePopup();

function openPopup(daire_id, tur) {
    // Belirli bir ID'ye sahip <tr> elementini seç
    var trElement = document.getElementById(daire_id);
    var label_tarih = document.getElementById("label_tarih");


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
        $('#label_tarih').html("Taşınma Tarihi :");
    } else if (tur == 1) {
        head += " (Kat Maliki)";
        $('#label_tarih').html("Satın Alma Tarihi :");
    }

    $('#pop-head').html(head);


    $('#popup2').show().css('display', 'flex').delay(100).queue(function(next) {
        $('body').css('overflow', 'hidden');
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
            $('body').css('overflow', 'auto');
        });
        next();
    });
}


function openPopupDaire() {
    $('body').css('overflow', 'hidden');

    $('#popupDaireEkle').show().css('display', 'flex').delay(100).queue(function(next) {
        $('#popupDaireEkle').css('opacity', '1');
        $('#userFormDaire').css('opacity', '1');
        $('#userFormDaire').css('transform', 'translateY(0)');
        next();
    });
}

function openPopupBlok() {
    $('body').css('overflow', 'hidden');

    $('#popupBlokEkle').show().css('display', 'flex').delay(100).queue(function(next) {
        $('#popupBlokEkle').css('opacity', '1');
        $('#userFormBlok').css('opacity', '1');
        $('#userFormBlok').css('transform', 'translateY(0)');
        next();
    });
}
$('#blokInput').focus(function() {
    $(this).css('border-color', '#3BB4D7');
});

function closePopupBlok() {
    $('#blokInput').css('border-color', '#000000');

    $('#userFormBlok').css('opacity', '0').css('transform', 'translateY(-180px)').delay(100).queue(function(next) {
        $('#popupBlokEkle').css('opacity', '0').delay(300).queue(function(nextInner) {
            $(this).hide().css('display', 'none');
            nextInner();
            $('body').css('overflow', 'auto');
        });
        next();
    });
}

function closePopupDaire() {

    $('#userFormDaire').css('opacity', '0').css('transform', 'translateY(-180px)').delay(100).queue(function(next) {
        $('#popupDaireEkle').css('opacity', '0').delay(300).queue(function(nextInner) {
            $(this).hide().css('display', 'none');
            nextInner();
            $('body').css('overflow', 'auto');
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

                if (turr == 0) {
                    tdElements[3].innerText = "";
                    tdElements[3].innerText = response;
                } else if (turr == 1) {
                    tdElements[5].innerText = "";
                    tdElements[5].innerText = response;
                }



            },
            error: function(error) {
                console.error(error);
            }

        });
    }

}


function saveBlok() {
    var blokInput = document.getElementById('blokInput').value;
    var t = document.getElementById('hiddenDaireID2').value;
    blokInput = blokInput.replace(/\s/g, "");
    if (blokInput == null || blokInput === "") {
        $('#blokInput').css('border-color', 'red');
    } else {
        $.ajax({

            url: 'Controller/blok_add.php',
            type: 'POST',
            dataType: 'json',
            data: {
                blokValue: blokInput,
                id: t,
            },
            success: function(response) {

                if (response.status == 1) {


                    var mainTr = document.getElementById("mainTr");
                    var td1 = document.createElement("td");
                    var td2 = document.createElement("td");
                    var td3 = document.createElement("td");
                    var td4 = document.createElement("td");

                    // Burada her bir td elementinin içeriğini doldurabilirsiniz, örneğin:
                    td1.textContent = blokInput;

                    td2.textContent = "0";
                    // td3'e bir buton ekleyelim

                    td3.innerHTML = "<span class='blok-ico' onclick=\"deleteBlok('" + response.blok_id +
                        "')\" ><i class='fa-solid fa-trash'></i></span>";


                    // td4'e bir buton ekleyelim


                    td4.innerHTML = "<span  class='blok-ico' onclick=\"editBlok('" + response.blok_id +
                        "')\" ><i class='fa-solid fa-pen'></i></span>";


                    // Yeni td elemanlarını tr içine ekleyin
                    var newTr = document.createElement("tr");
                    newTr.setAttribute("id", "blk-" + response.blok_id);
                    newTr.appendChild(td1);
                    newTr.appendChild(td2);
                    newTr.appendChild(td3);
                    newTr.appendChild(td4);

                    // Tabloya yeni tr'yi en sona ekle
                    mainTr.parentNode.appendChild(newTr);
                    document.getElementById('blokInput').value = "";




                }

            },
            error: function(error) {
                alert("hata: Müşteri temsilciniz ile iletişime geçiniz.");
            }

        });
    }
}

function deleteBlok(id) {
    if (confirm("Bloğu silmek istediğinizden emin misiniz?")) {

        $.ajax({

            url: 'Controller/blok_delete.php',
            type: 'POST',
            dataType: 'json',
            data: {

                id: id,
            },
            success: function(response) {
                if (response.sts == 1) {
                    var trr = document.getElementById('blk-' + id);
                    trr.remove();
                }
                alert(response.msg);

            },
            error: function(error) {
                alert(error);
            }

        });
    }

}


function editBlok(id) {
    $('#blk-' + id).css('background-color', '#445784');


    $('#blk-' + id).find('td:eq(2) span').css('display', 'none');
    var trashIcon = $('<i class="fa-solid fa-xmark"></i>');
    var newSpan = $('<span>').addClass('blok-ico').append(trashIcon);
    $('#blk-' + id).find('td:eq(2)').append(newSpan);


    $('#blk-' + id).find('td:eq(3) span').css('display', 'none');
    var trashIcon = $('<i class="fa-solid fa-check"></i>');
    var newSpan1 = $('<span>').addClass('blok-ico').append(trashIcon);
    $('#blk-' + id).find('td:eq(3)').append(newSpan1);


    var temp = $('#blk-' + id).find('td:eq(0)').text();

    $('#blk-' + id).find('td:eq(0)').attr('contenteditable', true);
    $('#blk-' + id).find('td:eq(0)').on('input', function() {
        if (this.textContent.length > 5) {
            this.textContent = this.textContent.slice(0, 5);
        }
    });




    newSpan.click(function() {
        reeditBlok(id);
        $('#blk-' + id).find('td:eq(0)').text(temp);
    });

    newSpan1.click(function() {
        var temp1 = $('#blk-' + id).find('td:eq(0)').text();
        $.ajax({

            url: 'Controller/blok_update.php',
            type: 'POST',
            dataType: 'json',
            data: {

                id: id,
                temp1:temp1,
            },
            success: function(response) {
               

            },
            error: function(error) {
                 
            }

        });


        reeditBlok(id);

    });

}


function reeditBlok(id) {
    $('#blk-' + id).find('td:eq(3) span:eq(1)').remove();
    $('#blk-' + id).find('td:eq(2) span:eq(1)').remove();

    $('#blk-' + id).find('td:eq(3) span:eq(0)').css('display', 'block');
    $('#blk-' + id).find('td:eq(2) span:eq(0)').css('display', 'block');

    $('#blk-' + id).css('background-color', '#f8f9fa');
    $('#blk-' + id).find('td:eq(0)').attr('contenteditable', false);
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