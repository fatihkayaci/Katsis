<?php
    $optionsBlok = '';
    $optionsDurum = '';
try {
    //burada yeni eklendi css eklenmesi lazım.
    $sql = "SELECT d.blok_adi, d.daire_sayisi, b.blok_adi
        FROM tbl_daireler d
        INNER JOIN tbl_blok b ON d.blok_adi = b.blok_id
        WHERE d.apartman_id = " . $_SESSION["apartID"];

    $result = $conn->query($sql);

    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $optionsBlok .= '<option name="optionsBlok" value="' . $row['blok_adi']." Blok - Daire ".$row['daire_sayisi'] . '">' .$row['blok_adi']." Blok - Daire ". $row['daire_sayisi'] . '</option>';
        }
    }
    $sql2 = "SELECT u.*, b.blok_adi AS blok_adi, d.daire_sayisi
    FROM tbl_users u
    LEFT JOIN tbl_daireler d ON u.userID = d.kiraciID OR u.userID = d.katMalikiID
    LEFT JOIN tbl_blok b ON d.blok_adi = b.blok_id
    WHERE rol=3 AND u.apartman_id = " .  $_SESSION["apartID"] . "
    ORDER BY u.userID ASC";


    
    $stmt = $conn->prepare($sql2);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//contenteditable="true"
    if ($result) {
       ?>

<div class="table-responsive-vertical cener-table">

    <div class="input-group-div">

        <div class="input-group1">
            
            <button class="adduser btn-custom-outline bcoc1">Kullanıcı Ekle</button>
            <button class="toplu btn-custom-outline bcoc2">Toplu İşlemler</button>

            <!-- bunu sil (düzenleme alanı) -->
            <button id="openEdit" onclick="openEdit ()">AÇ</button>
            <button id="closeEdit" onclick="closeEdit()">KAPAT</button>

            <!-- Düzenlemeye bunu yap -->
            <label class="switch">
              <input type="checkbox">
              <span class="slider round"></span>
            </label>

        </div>

        <div class="input-group1">
            <button class="topluGuncelle btn-custom-outline bcoc3" id="guncelleButton"
                style="display: none;">Güncelle</button>
            <button class="topluSil btn-custom-outline bcoc4" id="silButton" style="display: none;">Sil</button>
        

            <div class="search-box">
                <i class="fas fa-search search-icon" aria-hidden="true"></i>
                <input type="text" class="search-input" placeholder="Arama...">
            </div>
        </div>

    </div>

    <table id="example" class="users-table">
        <thead>
            <tr class="users-table-info">
                <th><input id="mainCheckbox" type="checkbox" onclick="toggleAll(this)" /></th>
                <th>Ad Soyad</th>
                <th>Telefon Numarası</th>
                <th>Blok Adı</th>
                <th>Kapı Numarası</th>
                <th>Durum</th>
            </tr>
        </thead>
        <tbody>

            <?php
                foreach ($result as $row) {
                ?>
            <tr data-userid="<?php echo $row["userID"]; ?>" id="tr-<?php echo $row["userID"]; ?>" class="git-ac">
                <td data-title="Seç"> <input id="check-<?php echo $row["userID"]; ?>" class="check1" type="checkbox" onclick="toggleMainCheckbox(<?php echo $row['userID']; ?>)" /></td>
                <td data-title="Ad Soyad" contenteditable="false"><?php echo $row["userName"]; ?></td>
                <td data-title="Telefon Numarası" contenteditable="false"><?php echo $row["phoneNumber"]; ?></td>
                <td data-title="Blok Adi"><?php echo $row["blok_adi"]; ?></td>
                <td data-title="Kapi Numarasi"><?php echo $row["daire_sayisi"]; ?></td>
                <td data-title="Durum"><?php echo $row["durum"]; ?></td>
            </tr>
            <?php
                }
                ?>

        </tbody>
    </table>
</div>
<?php
    } else {
?>

<div class="table-responsive-vertical cener-table">

    <div class="input-group-div">

        <div class="input-group1">
            <button class="adduser btn-custom-outline bcoc1">Kullanıcı Ekle</button>
            <button class="toplu btn-custom-outline bcoc2">Toplu İşlemler</button>
        </div>

        <div class="search-box">
            <i class="fas fa-search search-icon" aria-hidden="true"></i>
            <input type="text" class="search-input" placeholder="Arama...">
        </div>

    </div>

    <table id="example" class="users-table">
        <thead>
            <tr class="users-table-info">
                
            </tr>
        </thead>
        <tbody>
            <tr class="git-ac">
                <td>Kullanıcı Bulunmamaktadır</td>
            </tr>
        </tbody>
    </table>
</div>

<?php
    }
} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
?>

<!-- Popup Form -->
<div id="popup">

    <form class="login-form" id="userForm">

        <h2 class="form-signin-heading">Kullanıcı Ekleme</h2>

        <div class="row mb-1">
            <div class="col-md-6 col">
                <input class="input" type="text" name="userName" required="">
                <label for="userName">Ad Soyad :</label>
            </div>

            <div class="col-md-6 col">
                <input class="input" type="text" name="tc" required="" require>
                <label for="tc">T.C. Kimlik No :</label>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col">
                <input class="input tel" type="number" name="phoneNumber" required="">
                <label for="phoneNumber">Telefon Numarası :</label>
            </div>

            <div class="col-md-6 col">
                <input class="input" type="text" name="userEmail" required="">
                <label for="userEmail">E-Posta :</label>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col margint">
                <input class="input" type="text" name="plate" required="">
                <label for="plate">Araç Plakası</label>
            </div>

            <div class="col-md-6 col">
                <select class="input" id="gender" required="">
                    <option style="display: none;" value="" selected disabled></option>
                    <option value="Erkek">Erkek</option>
                    <option value="Kadın">Kadın</option>
                </select>
                <label for="gender">Cinsiyet :</label>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col">
                <input class="input" type="text" name="apartman_id" value=<?php echo $_SESSION["apartID"]; ?> hidden>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-btn">
                <button type="button" class="daireEkle btn-custom-daire">Daire Ekle</button>
            </div>
        </div>
        <div class="indexAdd">
        </div>

        <hr class="horizontal dark mt-0 w-100">

        <div class="row row-btn">
            <button type="button" class="btn-custom-close" onclick="closePopup()">Kapat</button>
            <button type="button" class="btn-custom"  onclick="saveUser()" id="saveButton">Kaydet</button>
        </div>


    </form>
</div>
<!--buraya toplu hesap eklenmesi için popup eklendi içeriğinin düzenlenmesi lazım-->
<div id="topluPopup">

    <form class="login-form-toplu" id="userForm2" action="">

        <h2 class="form-signin-heading">oluşturma şeklini seçiniz!</h2>

        <div class="row">
            <div class="col-md-12 col-btn mb-0">
                <a class="ahref btn-custom-daire w-100" href="index?parametre=TopluHesap">Toplu Hesap</a>
                <button class="btn-custom-daire w-100" type="button">Excel İle Dışarıdan Aktar</button>
                <!--bakılacak excel-->
            </div>
        </div>

        <hr class="horizontal dark w-100">

        <div class="row">
            <div class="col-md-12 col-btn">
                <button type="button" class="btn-custom-close w-100" onclick="closeToplu()">Kapat</button>
            </div>
        </div>

    </form>
</div>
<!--buraya daire için popup eklendi içeriğinin düzenlenmesi lazım-->
<div id="dairePopup">
    <form class="login-form-daire" id="userForm1" action="">

        <h2 class="form-signin-heading">Daire Ekleme</h2>

        <div class="row w-90">
            <div class="col-btn">
                <select class="input" id="optionsBlok" name="options" required="">
                    <?php echo $optionsBlok; ?>
                </select>
                <label for="options">Daire:</label>
            </div>
            <div class="col-btn">
                <select class="input" id="durum">
                    <option value="katmaliki">kat Maliki</option>
                    <option value="kiracı">kiracı</option>
                </select>
                <label for="durum">Durum :</label>
            </div>
        </div>

        <div class="row row-btn">
            <button type="button" class="btn-custom-close" onclick="closeDaire()">Kapat</button>
            <button type="button" class="btn-custom" id="ekle" onclick="newDaire()">Ekle</button>
        </div>

    </form>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


<script type="text/javascript">
var selectedValuesArray = [];
var selectedDurumArray = [];
var sayac = 0;


function newDaire() {
    // Seçilen değeri al

    var optionsElement = document.getElementById("optionsBlok");
    var selectedValue = optionsElement.value;

    var optionsDurum = document.getElementById("durum");
    var selectedDurum = optionsDurum.value;

    selectedValuesArray.push(selectedValue);
    selectedDurumArray.push(selectedDurum);

    // Yeni bir ana div oluştur
    var newContainer = document.createElement('div');
    newContainer.className = 'daire-container';

    // Yeni <div> elementini oluştur
    var newDaire = document.createElement('div');
    newDaire.className = 'daire';
    newDaire.innerHTML = selectedValue;

    //durum için div oluşturuldu.
    var newDurum = document.createElement('div');
    newDurum.className = 'durum';
    newDurum.innerHTML = selectedDurum;

    //durum için div oluşturuldu.
    var sil = document.createElement('button');
    sil.className = 'sil';
    sil.id = "demo" + sayac;
    sil.innerHTML = 'Delete';
    sil.addEventListener('click', function() {
        newContainer.remove(); // newContainer'ı sil
        var index = parseInt(this.id.replace('demo', ''), 10);
        selectedValuesArray.splice(index, 1); // selectedValuesArray'den ilgili elemanı sil
        selectedDurumArray.splice(index, 1); // selectedDurumArray'den ilgili elemanı sil
        sayac--;
    });

    // Yeni div'leri ana div içerisine ekle
    newContainer.appendChild(newDaire);
    newContainer.appendChild(newDurum);
    newContainer.appendChild(sil); // sil butonunu ekleyin

    // Oluşturulan ana div'i belirli bir alana ekleyin (indexAdd)
    var indexAddElement = document.querySelector('.indexAdd');
    indexAddElement.appendChild(newContainer);

    closeDaire();

    sayac++;
}


function toggleAll(masterCheckbox) {


    var checkboxes = document.getElementsByClassName('check1');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = masterCheckbox.checked;
    }
    if (masterCheckbox.checked) {
        $('#guncelleButton').css('display', 'inline-block');
        $('#silButton').css('display', 'inline-block');

        $('.git-ac').addClass('git-ac-color');
    } else if (!masterCheckbox.checked) {
        $('#guncelleButton').css('display', 'none');
        $('#silButton').css('display', 'none');
        $('.git-ac').removeClass('git-ac-color');
    }



}

// Herhangi bir alt checkbox işaret kaldırıldığında, "Hepsini Seç" kutusunu kaldırır
var checkboxes = document.getElementsByClassName('check1');
for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].addEventListener('change', function() {
        var allChecked = true;
        for (var j = 0; j < checkboxes.length; j++) {
            if (!checkboxes[j].checked) {
                allChecked = false;
                break;
            }
        }
        document.getElementById('mainCheckbox').checked = allChecked;
    });
}




function toggleMainCheckbox(id) {

    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    var guncelleButton = document.getElementById('guncelleButton');
    var silButton = document.getElementById('silButton');
    var enAzBirSecili = false;


    checkboxes.forEach(function(checkbox) {
        if ( checkbox.checked) {
            enAzBirSecili = true;
        }
    });
   
    if (enAzBirSecili) {
        guncelleButton.style.display = 'inline-block';
        silButton.style.display = 'inline-block';
    } else {
        guncelleButton.style.display = 'none';
        silButton.style.display = 'none';
    }


    
    var checkbox2 = document.getElementById('check-' + id);

    if (checkbox2.checked) {
        $('#tr-' + id).addClass('git-ac-color');
    } else {
        $('#tr-' + id).removeClass('git-ac-color');
    }

  


}

$('.adduser').click(function() {
    $('#popup').show().css('display', 'flex').delay(100).queue(function(next) {
        $('body').css('overflow', 'hidden');
        $('#popup').css('opacity', '1');
        $('#userForm').css('opacity', '1');
        $('#userForm').css('transform', 'translateY(0)');
        next();
    });
});

function closePopup() {
    $('#userForm').css('opacity', '0').css('transform', 'translateY(-180px)').delay(100).queue(function(next) {
        $('#popup').css('opacity', '0').delay(300).queue(function(nextInner) {
            $(this).hide().css('display', 'none');
            nextInner();
            $('body').css('overflow', 'auto');
        });
        next();
    });
}

$('.toplu').click(function() {
    $('#topluPopup').show().css('display', 'flex').delay(100).queue(function(next) {
        $('body').css('overflow', 'hidden');
        $('#topluPopup').css('opacity', '1');
        $('#userForm2').css('opacity', '1');
        $('#userForm2').css('transform', 'translateY(0)');
        next();
    });
});

function closeToplu() {
    $('#userForm2').css('opacity', '0').css('transform', 'translateY(-180px)').delay(100).queue(function(next) {
        $('#topluPopup').css('opacity', '0').delay(300).queue(function(nextInner) {
            $(this).hide().css('display', 'none');
            nextInner();
            $('body').css('overflow', 'auto');
        });
        next();
    });
}

$('.daireEkle').click(function() {
    $('#dairePopup').show().css('display', 'flex').delay(100).queue(function(next) {
        $('body').css('overflow', 'hidden');
        $('#dairePopup').css('opacity', '1');
        $('#userForm1').css('opacity', '1');
        $('#userForm1').css('transform', 'translateY(0)');
        next();
    });
});

function closeDaire() {
    $('#userForm1').css('opacity', '0').css('transform', 'translateY(-180px)').delay(100).queue(function(next) {
        $('#dairePopup').css('opacity', '0').delay(300).queue(function(nextInner) {
            $(this).hide().css('display', 'none');
            nextInner();
            $('body').css('overflow', 'auto');
        });
        next();
    });
}
//burası her data-userid değeri değiştiğinde altına çizgi koyar //
var trElements = document.querySelectorAll('tr.git-ac');
for (var i = 0; i < trElements.length; i++) {
    if (trElements[i].dataset.userid !== trElements[i + 1]?.dataset.userid) {
        trElements[i].style.borderBottom = '2px solid #ebebeb';
    }
}

//kısıtlama ile ilgili fonksiyonlar başlangıç...
function validateFullName(userName) {
    const regex = /^[A-Za-zÇçĞğİıÖöŞşÜü\s]+$/;
    return regex.test(userName);
    event.preventDefault(); // Formun gönderimini engelle
}

function kisitlamalar(userName) {
    if (userName.length < 3) {
        alert('Full Name en az 3 karakter olmalıdır.');
        return;
    }
    if (userName.length > 100) {
        alert('Full Name 100den fazla karakter olamaz.');
        return;
    }
    if (!validateFullName(userName)) {
        alert('Lütfen yalnızca harf karakterleri içeren geçerli bir tam ad girin.');
        return;
    }
    return true;
}

//kısıtlama ile ilgili fonksiyonlar bitiş...
//var toplusil
var topluGuncelleButtons = document.querySelectorAll('.topluGuncelle');

topluGuncelleButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        var rows = document.querySelectorAll('#example tbody tr'); // Tüm satırları bul
        rows.forEach(function(row) {
            var userID = row.getAttribute('data-userid');
            var userName = row.querySelector('td:nth-child(2)').textContent;
            var phoneNumber = row.querySelector('td:nth-child(3)').textContent;

            var checkbox = row.querySelector('input[type="checkbox"]');
            if (checkbox.checked) {
                if (kisitlamalar(userName)) {
                    $.ajax({
                        url: 'Controller/update_user.php',
                        type: 'POST',
                        data: {
                            userID: userID,
                            userName: userName,
                            phoneNumber: phoneNumber
                        },
                        success: function(response) {
                            if (response == 1) {
                                location.reload();
                            }
                        },
                        error: function(error) {
                            console.error('Gönderim hatası:', error);
                        }
                    });
                }
            }
        });
    });
});
// Toplu silme işlemi için butonları seç
var topluSilButton = document.getElementById('silButton');

// Silme işlemi butonuna tıklanınca bu fonksiyon çalışacak
topluSilButton.addEventListener('click', function() {
    var guncelleButton = document.getElementById('guncelleButton');
    var silButton = document.getElementById('silButton');
    var checkboxes = document.querySelectorAll('#example tbody input[type="checkbox"]:checked');

    checkboxes.forEach(function(checkbox) {
        var row = checkbox.closest('tr');
        var userID = row.getAttribute('data-userid');
        var blok_adi = row.querySelector('td[data-title="Blok Adi"]').textContent;
        var daire_sayisi = row.querySelector('td[data-title="Kapi Numarasi"]').textContent;
        var durum = row.querySelector('td[data-title="Durum"]').textContent;
        alert(blok_adi + " " + daire_sayisi + " " + durum);
        // Sunucuya silme isteği gönder
        $.ajax({
            url: 'Controller/demo4.php',
            type: 'POST',
            data: {
                userID: userID,
                blok_adi: blok_adi,
                daire_sayisi: daire_sayisi,
                durum: durum
            },
            success: function(response) {
                alert(response);
                if (response == 1) {
                    row.remove();
                }
            },
            error: function(error) {
                console.error('Silme hatası:', error);
            }
        });
    });
    guncelleButton.style.display = 'none';
    silButton.style.display = 'none';
});
//bakılacak
//var saveButton = document.getElementById('saveButton');
function saveUser(){
    var userName = $('input[name="userName"]').val();
    var tc = $('input[name="tc"]').val();
    var phoneNumber = $('input[name="phoneNumber"]').val();
    var userEmail = $('input[name="userEmail"]').val();
    var plate = $('input[name="plate"]').val();
    var gender = $('select#gender').val();
    var apartman_id = $('input[name="apartman_id"]').val();
    var optionsBlok = $('select#optionsBlok').val();
    var blokArray = [];
    var durumArray = [];
    console.log(userName + "," + tc + "," + phoneNumber + "," + userEmail + "," + plate + "," + gender);

    for (var i = 0; i < selectedDurumArray.length; i++) {
        var durumParcalari = selectedDurumArray[i].split(',');

        for (var j = 0; j < durumParcalari.length; j++) {
            durumArray.push(durumParcalari[j]);
        }
    }

    console.log("durum Array = " + JSON.stringify(durumArray));

    for (var i = 0; i < selectedValuesArray.length; i++) {
        var element = selectedValuesArray[i];
        var match = element.match(/\d+/);
        var letterPart = element.charAt(0);
        var numberPart = match ? match[0] : null;

        /*console.log("element = " + element + ", letterpart = " + letterPart + ", numberpart = " +
            numberPart);*/

        var blokElement = {
            letter: letterPart,
            number: numberPart
        };

        blokArray.push(blokElement);
    }

    console.log("blok Array = " + JSON.stringify(blokArray));

    if (kisitlamalar(userName /* tc, phoneNumber, userEmail, plate*/ )) {
        $.ajax({
            url: 'Controller/save_user.php',
            type: 'POST',
            data: {
                userName: userName,
                tc: tc,
                phoneNumber: phoneNumber,
                durumArray: JSON.stringify(durumArray),
                userEmail: userEmail,
                plate: plate,
                gender: gender,
                apartman_id: apartman_id
            },
            success: function(response) {
                alert(response);
                if (response == 1) {
                    $.ajax({
                        url: 'Controller/demo.php',
                        type: 'POST',
                        data: {
                            blokArray: JSON.stringify(blokArray), // Diziyi JSON dizesine dönüştür
                            durumArray: JSON.stringify(durumArray)
                        },
                        success: function(secondResponse) {
                            alert(secondResponse);
                            if (secondResponse == 1) {
                                location.reload();
                            }
                        },
                        error: function(secondError) {
                            console.error(secondError);
                        }
                    });
                }
            },
            error: function(error) {
                console.error(error);
            }
        });
    } else {
        return;
    }
};


var updateButtons = document.querySelectorAll('.updateButton');

updateButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        var row = this.closest('tr'); // Güncellenen satırı bul
        var userID = row.getAttribute('data-userid');
        var userName = row.querySelector('td:nth-child(2)').textContent;
        var phoneNumber = row.querySelector('td:nth-child(3)').textContent;
        var userEmail = row.querySelector('td:nth-child(5)').textContent;
        var plate = row.querySelector('td:nth-child(6)').textContent;
        var gender = row.querySelector('td:nth-child(7) select').value;
        alert(userName + "," + phoneNumber + "," + userEmail + "," + userID + "," + plate +
            "," + gender);
        if (kisitlamalar(userName /*, tc, phoneNumber, userEmail, plate*/ )) {
            $.ajax({
                url: 'Controller/update_user.php',
                type: 'POST',
                data: {
                    userID: userID,
                    userName: userName,
                    phoneNumber: phoneNumber,
                    userEmail: userEmail,
                    plate: plate,
                    gender: gender
                },
                success: function(response) {
                    alert(response);
                    if (response == 1) {
                        alert("güncellendi");
                        //location.reload();
                    }
                },
                error: function(error) {
                    console.error('Gönderim hatası:', error);
                }
            });
        } else {
            return;
        }
    });
});
var deleteButtons = document.querySelectorAll('.deleteButton');

deleteButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        var row = this.closest('tr'); // Güncellenen satırı bul
        var userName = row.querySelector('td:nth-child(1)').textContent;
        var tc = row.querySelector('td:nth-child(2)').textContent;
        var phoneNumber = row.querySelector('td:nth-child(3)').textContent;
        var userEmail = row.querySelector('td:nth-child(4)').textContent;
        var userPass = row.querySelector('td:nth-child(5)').textContent;
        var plate = row.querySelector('td:nth-child(6)').textContent;
        var gender = row.querySelector('td:nth-child(7)').textContent;
        var userID = row.getAttribute('data-userid');
        $.ajax({
            url: 'Controller/delete_user.php',
            type: 'POST',
            data: {
                userID: userID,
                userName: userName,
                tc: tc,
                phoneNumber: phoneNumber,
                userEmail: userEmail,
                userPass: userPass,
                plate: plate,
                gender: gender
            },
            success: function(response) {
                if (response == 1) {
                    //alert("güncellendi"+response);
                    location.reload();
                }
            },
            error: function(error) {
                console.error(error);
            }
        });
    });
});

function openEdit() {
    var editableCells = document.querySelectorAll('td[contenteditable="false"]');
    editableCells.forEach(function(cell) {
        var isEditable = cell.getAttribute('contenteditable');
        if (isEditable === "true") {
            cell.setAttribute('contenteditable', 'false');
        } else {
            cell.setAttribute('contenteditable', 'true');
        }
    });
}

function closeEdit() {
    var editableCells = document.querySelectorAll('td[contenteditable="true"]');
    editableCells.forEach(function(cell) {
        var isEditable = cell.getAttribute('contenteditable');
        if (isEditable === "true") {
            cell.setAttribute('contenteditable', 'false');
        } else {
            cell.setAttribute('contenteditable', 'true');
        }
    });
    demofunction();
}
//isim düzeltilecek
function demofunction() {
    var rows = document.querySelectorAll('.git-ac');
    rows.forEach(function(row) {
        row.addEventListener('click', function(event) {
            // Checkbox içinde bir tıklama olup olmadığını kontrol et
            var isCheckboxClicked = event.target.tagName === 'INPUT' && event.target
                .getAttribute(
                    'type') === 'checkbox';

            // Eğer checkbox'a tıklanmışsa işlemi durdur
            if (isCheckboxClicked) {
                event.stopPropagation();
                return;
            }

            // Checkbox dışında bir yere tıklandıysa userID'yi al ve yönlendir
            var userID = row.getAttribute('data-userid');
            // userID'yi URL'ye ekleyerek sayfayı yeniden yönlendir
            window.location.href = 'index.php?parametre=custom&userID=' + encodeURIComponent(
                userID);
        });
    });
}
</script>