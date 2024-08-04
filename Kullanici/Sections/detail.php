 <input type="hidden" id="hiddenDaireID2" value=<?php echo  $_SESSION["apartID"]?> />
    <?php
   
try {
   
    //$sql = "SELECT * FROM tbl_users WHERE apartman_id = " .$_SESSION["apartID"]."AND userID=".$userID ;
    $sql = "SELECT tbl_daireler.*, tbl_blok.blok_adi, tbl_grup.grup_adi,
    kiraci.userName AS kiraci_adi, kiraci.userID AS kiraci_id,
    katMaliki.userID AS kat_maliki_id, katMaliki.userName AS kat_maliki_adi
FROM tbl_daireler 
LEFT JOIN tbl_blok ON tbl_daireler.blok_adi = tbl_blok.blok_id
LEFT JOIN tbl_users AS kiraci ON tbl_daireler.kiraciID = kiraci.userID
LEFT JOIN tbl_users AS katMaliki ON tbl_daireler.katMalikiID = katMaliki.userID
LEFT JOIN tbl_grup ON tbl_daireler.dGrubu = tbl_grup.grup_id
WHERE tbl_daireler.apartman_id = " . $_SESSION["apartID"] . " 
AND tbl_daireler.daire_id = " . $_SESSION['daireSayfa'];



    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    // Sonuç kümesinin satır sayısını kontrol etme
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $row= $result;
  
        



            $sql = "SELECT * FROM tbl_users WHERE apartman_id = :apartman_id AND rol = 3";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':apartman_id', $_SESSION["apartID"], PDO::PARAM_INT);
            $stmt->execute();
            $UserList = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            
    ?>

<div class="review-area">



    <div class="profile-area">

        <div class="bilgi-info pt-3">                

            <div class="bilgi-p b-new">
            	<h6>Daire Bilgileri</h6>
            </div>


            <div class="bilgi-p b-new">
                <p>Daire :</p>
                <p id="daireInfo"><?php  echo  $row['blok_adi'] ." Blok / No: ".$row['daire_sayisi'] ;    ?></p>
            </div>

            <div class="bilgi-p b-new">
                <p>Kat Maliki :</p>
                <?php 
                    if(isset($row["kat_maliki_adi"]) && ($row["kat_maliki_adi"] !== null && $row["kat_maliki_adi"] !== 0)) {
                        echo '<p class="userss daire-link hover-link" onclick=userGo('.$row["kat_maliki_id"].','.$row["daire_id"].')>' . $row["kat_maliki_adi"] . '<i class="fa-solid fa-link"></i></p>';
                    } else {
                        echo '<button type="button" class="table-a tca2" onclick="openPopup('.$row["daire_id"].',1)">Kat Maliki Ekle + </button>';
                    }
                ?>
            </div>

            <div class="bilgi-p b-new">
                <p>Kiracı :</p>
                <?php 
                    if(isset($row["kiraci_adi"]) && ($row["kiraci_adi"] !== null && $row["kiraci_adi"] !== 0)) {
                        echo '<p class="userss daire-link hover-link" onclick=userGo('.$row["kiraci_id"].','.$row["daire_id"].')>' . $row["kiraci_adi"] . '<i class="fa-solid fa-link"></i></p>';
                    } else {
                        echo '<button type="button" class="table-a tca1" onclick="openPopup('.$row["daire_id"].',0)">Kiracı Ekle + </button>';
                    }
                ?>
            </div>

            <div class="bilgi-p b-new">
                <p>Daire Grubu :</p>
                <p><?= !empty($row["grup_adi"]) ? $row["grup_adi"] : "-" ?></p>
            </div>

            <div class="bilgi-p b-new">
                <p>Kat :</p>
                <p><?= !empty($row["kat"]) ? $row["kat"] : "-" ?></p>
            </div>

            <div class="bilgi-p b-new">
                <p>Brüt m² :</p>
                <p><?= !empty($row["brut"]) ? $row["brut"] : "-" ?></p>
            </div>

            <div class="bilgi-p b-new">
                <p>Net m² :</p>
                <p><?= !empty($row["net"]) ? $row["net"] : "-" ?></p>
            </div>

            <div class="bilgi-p b-new">
                <p>Arsa Payı :</p>
                <p><?= !empty($row["pay"]) ? $row["pay"] : "-" ?></p>
            </div>

        </div>

    </div>

    <div class="borc-info">
        
        <div class="borc-area overflow-borc">
            <div class="account-settings">

                <div class="input-group-div fixed-borc">
                    <div class="input-group1">
                        <button class="btn-custom-outline bcoc1"
                            onclick=" popupOpenControl('popupBorcEkle','borcEkleForm')">Borç</button>
                        <button class="btn-custom-outline bcoc1">Tahsilat</button>
                    </div>
                    <div class="input-group1">
                        <button class="btn-custom-outline bcoc3">Düzenle</button>
                    </div>
                </div>

                <input type="hidden" id="topborc" value="" />
                    <div class="borc-box">
                        <div class="bakiye-header">
                            <p class="tarih">BAKİYE : </p>
                            <p class="borc">
                                123 <img class="tl-img"
                                    src="../Admin\assets\img\tl.png" alt="">
                            </p>
                        </div>
                        <a href="" class="bakiye-area">
                            <p class="tarih">
                                23.09.2024
                            </p>
                            <p class="aciklama">
                            aciklama
                            <p class="aciklama">
                            aciklama
                            </p>
                            <p class="borc">
                                124tl <img class="tl-img"
                                    src="../Admin\assets\img\tl.png" alt="">
                            </p>
                        </a>

                        <a href="" class="bakiye-area">
                            <p class="tarih">
                                23.09.2024
                            </p>
                            <p class="aciklama">
                            aciklama
                            <p class="aciklama">
                            aciklama
                            </p>
                            <p class="borc">
                                124tl <img class="tl-img"
                                    src="../Admin\assets\img\tl.png" alt="">
                            </p>
                        </a>

                        <a href="" class="bakiye-area">
                            <p class="tarih">
                                23.09.2024
                            </p>
                            <p class="aciklama">
                            aciklama
                            <p class="aciklama">
                            aciklama
                            </p>
                            <p class="borc">
                                124tl <img class="tl-img"
                                    src="../Admin\assets\img\tl.png" alt="">
                            </p>
                        </a>

                        <a href="" class="bakiye-area">
                            <p class="tarih">
                                23.09.2024
                            </p>
                            <p class="aciklama">
                            aciklama
                            <p class="aciklama">
                            aciklama
                            </p>
                            <p class="borc">
                                124tl <img class="tl-img"
                                    src="../Admin\assets\img\tl.png" alt="">
                            </p>
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>
    
</div>
  



<!-- Popup kiracı ve kat maliki eklemek için-->
<div id="popup2" class="form-popup">

    <form id="userForm" class="login-form">

        <h2 class="form-signin-heading" id="pop-head"></h2>

        <input type="hidden" id="hiddenDaireID" />
        <input type="hidden" id="turDaire" />

        <div class="row">
            <div class="col-md-12 col-btn">
                <div class="select-div">
                <div class="dropdown-nereden">
                        <div class="group">
                            <input class="search-selectx input" data-user-id="" type="text" list="Users" id="userInput"
                                required="" />
                            <label class="selectx-label" for="userInput">Kullanıcılar :</label>
                        </div>

                        <div class="dropdown-content-nereden searchInput-btn" id="userInputDP">
                            <div class="dropdown-content-inside-nereden">
                                <input type="text" id="searchInput3" placeholder="Ara...">

                                <?php 
                            foreach($UserList as $user){
                             echo '                                        
                                <button  data-user-id="' . $user['userID'] . '">' . $user['userName'] . '</button>';
                            }
                        ?>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-12 col-btn">
                <input class="input" type="date" value="<?php echo date('Y-m-d'); ?>" id="dateInput" required="" />
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






    <?php
    
    
} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
?>

    <body>

      
<script type="text/javascript">
const inputField = document.querySelector('.search-selectx');
const dropdown = document.querySelector('.value-listx');
const dropdownArray = [...document.querySelectorAll('.li-select')];
console.log(typeof dropdownArray)
dropdown.classList.add('open');
inputField.focus();
let valueArray = [];
dropdownArray.forEach(item => {
    valueArray.push(item.textContent);
});
var selectedUserID;
const closeDropdown = () => {
    dropdown.classList.remove('open');
}

inputField.addEventListener('input', () => {
    dropdown.classList.add('open');
    let inputValue = inputField.value.toLowerCase();
    let valueSubstring;
    if (inputValue.length > 0) {
        for (let j = 0; j < valueArray.length; j++) {
            if (!(inputValue.substring(0, inputValue.length) === valueArray[j].substring(0, inputValue.length)
                    .toLowerCase())) {
                dropdownArray[j].classList.add('closed'); /* yeni ibaresi gelicek */
            } else {
                dropdownArray[j].classList.remove('closed');
            }
        }
    } else {
        for (let i = 0; i < dropdownArray.length; i++) {
            dropdownArray[i].classList.remove('closed');
        }
    }
});

dropdownArray.forEach(item => {
    item.addEventListener('click', (evt) => {
        selectedUserID = evt.target.dataset.userId;
        inputField.value = item.textContent;
        dropdownArray.forEach(dropdown => {
            dropdown.classList.add('closed');
        });
    });
})

inputField.addEventListener('focus', () => {
    dropdown.classList.add('open');
    dropdownArray.forEach(dropdown => {
        dropdown.classList.remove('closed');
    });
});

inputField.addEventListener('blur', () => {
    dropdown.classList.remove('open');
});

document.addEventListener('click', (evt) => {
    const isDropdown = dropdown.contains(evt.target);
    const isInput = inputField.contains(evt.target);
    if (!isDropdown && !isInput) {
        dropdown.classList.remove('open');
    }
});



       function openPopup(daire_id, tur) {
    // Belirli bir ID'ye sahip <tr> elementini seç
    var trElement = document.getElementById(daire_id);
    var label_tarih = document.getElementById("label_tarih");
    var daireInfo = document.getElementById("daireInfo").innerHTML;

    


    document.getElementById("hiddenDaireID").value = daire_id;
    document.getElementById("turDaire").value = tur;


    var head = daireInfo;
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
let selectedValue;

document.getElementById('userInput').addEventListener('input', function() {
    selectedValue = this.value;
});
function save() {
    var userr = document.getElementById('userInput').value;
    var turr = document.getElementById("turDaire").value;
    var kTarih = document.getElementById("dateInput").value;
    var daireID = document.getElementById("hiddenDaireID").value;
    var apartId = document.getElementById('hiddenDaireID2').value;
    if (userr === null || userr === "") {
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
    userr:userr,
    apartId:apartId,


},
success: function(response) {
    closePopup();
   location.reload();


},
error: function(error) {
    console.error(error);
}

});
    }

}




function userGo(id,dId){

    
    var d="user";
        $.ajax({
            url: 'Controller/create_session.php',
            type: 'POST',
            data: {

                id: id,
                d:d,
                dId:dId,

            },
            success: function(response) {
               
                    if(response){
                        window.location.href = "index.php?parametre=custom";
                        localStorage.setItem('selectedLink', 'Accounts');
                    }
                    
                

            },
            error: function(xhr, status, error) {
                var errorMessage = xhr.status + ': ' + xhr.statusText;
                alert('Hata alındı: ' + errorMessage);
            }
        });
}
    




        </script>
        <script src="assets/js/mycode/dropdown.js"></script>
<script>
dropDownn('userInput', 'userInputDP', 'searchInput3');
</script>
