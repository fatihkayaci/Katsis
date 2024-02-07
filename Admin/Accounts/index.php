<!--
    sonradan eklenecekler işlemler kısmı eklenecek.
    icra durumu
    bakiye.
    <td contenteditable="true">' .base64_decode($row["userPass"]) . '</td>
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcılar</title>
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css"> -->
</head>

<body>
<div class="table-responsive-vertical cener-table">
    <div class="input-group-div">

        <div class="input-group1">
        <button class="adduser btn-custom-outline">Kullanıcı Ekle</button>
        <button class="toplu btn-custom-outline">Toplu Kullanıcı Ekle Ve Düzelt</button>
        </div>

        <div class="input-group">
          <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
          <input type="text" class="form-control" placeholder="Arama...">
        </div>
    </div>
</div>   
    <?php
    $optionsBlok = '';
    $optionsDurum = '';
try {
    //burada yeni eklendi css eklenmesi lazım.
    $sql = "SELECT blok_adi, daire_sayisi FROM tbl_daireler WHERE apartman_id = " . $_SESSION["apartID"];
    $result = $conn->query($sql);

    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $optionsBlok .= '<option name="optionsBlok" value="' . $row['blok_adi']." Blok - Daire ".$row['daire_sayisi'] . '">' .$row['blok_adi']." Blok - Daire ". $row['daire_sayisi'] . '</option>';
        }
    }

    $sql = "SELECT * FROM tbl_users WHERE apartman_id = " . $_SESSION["apartID"] . " AND rol = 3";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    // Sonuç kümesinin satır sayısını kontrol etme
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        echo '
        
        <div class="table-responsive-vertical shadow-z-1 cener-table">

            <table id="example" class="table table-hover table-mc-light-blue">
                <thead>
                    <tr>
                        <th><input type="checkbox"/></th>
                        <th>Ad Soyad</th>
                        <th>Telefon Numarası</th>
                        <th>Durum</th>
                        <th>E-Posta</th>
                        <th>Araç Plakası</th>
                        <th>Cinsiyet</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>';

                foreach ($result as $row) {
                    echo '<tr data-userid="' . $row["userID"] . '">

                            <td data-title="Seç"> <input type="checkbox"/></td>

                            <td data-title="Ad Soyad" contenteditable="true">' . $row["userName"] . '</td>

                            <td data-title="Telefon Numarası" contenteditable="true">' . $row["phoneNumber"] . '</td>

                            <td data-title="Durum">'.$row["durum"] .'</td>

                            <td data-title="E-Posta" contenteditable="true">' . $row["userEmail"] . '</td>

                            <td data-title="Araç Plakası" contenteditable="true">' . $row["plate"] . '</td>

                            <td data-title="Cinsiyet" contenteditable="false">
                            <select class="input-select">
                                <option value="Erkek" ' . ($row["gender"] == "Erkek" ? 'selected' : '') . '>Erkek</option>
                                <option value="Kadın" ' . ($row["gender"] == "Kadın" ? 'selected' : '') . '>Kadın</option>
                            </select>
                            </td>

                            <td data-title="Seçenekler">
                                <li class="nav-item dropdown pe-2 d-flex settings">
                                      <a href="javascript:;" class="nav-link text-body nav-link font-weight-bold mb-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                      </a>
                                  <ul class="dropdown-menu dropdown-menu-end1 ayar-1 px-1 margin-10" aria-labelledby="dropdownMenuButton">
                                    <li class="mb-1">
                                      <a class="dropdown-item border-radius-md" href="index?parametre=custom">
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
                                      <button class="updateButton dropdown-item border-radius-md">
                                        <div class="d-flex">
                                          <div class="my-auto">
                                            <i class="fa-solid fa-floppy-disk i-color me-3"></i>
                                          </div>
                                          <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-normal mb-0">
                                              <span class="font-weight-bold">Güncelle</span>
                                            </h6>
                                          </div>
                                        </div>
                                      </button>
                                    </li>
                                    <li class="mb-1">
                                      <button class="deleteButton dropdown-item border-radius-md">
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
                                      </button>
                                    </li>
                                  </ul>
                                </li>
                            </td>

                        </tr>';
                    }
                

        echo '</tbody>
            </table>
        </div>';
    } else {
        echo "0 results";
    }
} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
?>

    <!-- Popup Form -->
    <div id="popup">

        <form class="login-form" id="userForm">

            <h2 class="form-signin-heading">Kullanıcı Ekleme</h2>

            <div class="row">
                <div class="col-md-6 col">
                    <label for="userName">Ad Soyad :</label>
                    <input class="input" type="text" name="userName" placeholder="İsminizi Giriniz." required><br>
                </div>

                <div class="col-md-6 col">
                    <label for="tc">T.C. Kimlik No :</label>
                    <input class="input" type="text" name="tc" placeholder="T.C. giriniz." required><br>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col">
                    <label for="phoneNumber">Telefon Numarası :</label>
                    <input class="input" type="text" name="phoneNumber" pattern="[0-9]{10}"
                        placeholder="e.g., 5551234567" required><br>
                </div>

                <div class="col-md-6 col">
                    <label for="userEmail">E-Posta (opsiyonel) :</label>
                    <input class="input" type="text" name="userEmail" placeholder="Email adresi"><br>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col margint">
                    <label for="plate">Araba Plakası (opsiyonel) :</label>
                    <input class="input" type="text" name="plate" placeholder="Araba plakası (opsiyonel)"><br>
                </div>

                <div class="col-md-6 col">
                    <label for="gender">Cinsiyet :</label>
                    <select class="input" id="gender">
                        <option value="Erkek">Erkek</option>
                        <option value="Kadın">Kadın</option>
                    </select>
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
                <!--<button type="button" class="Artı btn btn-primary">+</button>-->
            </div>
            <div class="indexAdd"></div>

            <hr class="horizontal dark mt-4 w-100">

            <div class="row">
                <div class="col-md-12 col-btn">
                    <button type="button" class="btn-custom" id="saveButton">Kaydet</button>
                    <button type="button" class="btn-custom-close" onclick="closePopup()">Kapat</button>
                </div>
            </div>


        </form>
    </div>
    <!--buraya toplu hesap eklenmesi için popup eklendi içeriğinin düzenlenmesi lazım-->
    <div id="topluPopup">

        <form class="login-form-toplu" id="userForm2" action="">

            <h2 class="form-signin-heading">oluşturma şeklini seçiniz!</h2>

            <div class="row">
                <div class="col-md-12 col-btn">
                    <a class="ahref btn-custom" href="index?parametre=TopluHesap">Toplu Hesap</a>
                    <button class="btn-custom" type="button">Excel İle Dışarıdan Aktar</button>
                    <!--bakılacak excel-->
                </div>
            </div>

            <hr class="horizontal dark w-100">

            <div class="row">
                <div class="col-md-12 col-btn">
                    <button  type="button" class="btn-custom-close" onclick="closeToplu()">Kapat</button>
                </div>
            </div>

        </form>
    </div>
    <!--buraya daire için popup eklendi içeriğinin düzenlenmesi lazım-->
    <div id="dairePopup">
        <form class="login-form-daire" id="userForm1" action="">

            <h2 class="form-signin-heading">Daire Ekleme</h2>

            <div class="row">
                <div class="col-md-12 col-btn">
                    <label for="options">Daire:</label>
                    <select class="input" id="optionsBlok" name="options">
                        <?php echo $optionsBlok; ?>
                    </select>

                    <label for="durum">Durum :</label>
                    <select class="input" id="durum">
                        <option value="katmaliki">kat Maliki</option>
                        <option value="kiracı">kiracı</option>
                    </select>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12 col-btn">
                    <button type="button" class="btn-custom" id="ekle" onclick="newDaire()">Ekle</button>
                    <button type="button" class="btn-custom-close" onclick="closeDaire()">Kapat</button>
                </div>
            </div>

        </form>
    </div>

    <body>
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script type="text/javascript">
        var selectedValuesArray = [];
        var selectedDurumArray = [];

        function newDaire() {
            // Seçilen değeri al
            var optionsElement = document.getElementById("optionsBlok");
            var selectedValue = optionsElement.value;

            var optionsDurum = document.getElementById("durum");
            var selectedDurum = optionsDurum.value;

            selectedValuesArray.push(selectedValue);
            selectedDurumArray.push(selectedDurum);
            // Yeni <p> elementini oluştur
            var newDaire = document.createElement('div');
            newDaire.className = 'daire';
            newDaire.innerHTML = selectedValue;

            //durum için div oluşturuldu.
            var newDurum = document.createElement('div');
            newDurum.className = 'durum';
            newDurum.innerHTML = selectedDurum;

            // Oluşturulan <p> elementini belirli bir alana ekleyin
            var indexAddElement = document.querySelector('.indexAdd');
            indexAddElement.appendChild(newDaire);
            indexAddElement.appendChild(newDurum);
            closeDaire();
        }

        $('.adduser').click(function() {
            $('#popup').show().css('display', 'flex').delay(100).queue(function(next) {
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
                });
                next();
            });
        }

        $('.toplu').click(function() {
            $('#topluPopup').show().css('display', 'flex').delay(100).queue(function(next) {
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
                });
                next();
            });
        }

        $('.daireEkle').click(function() {
            $('#dairePopup').show().css('display', 'flex').delay(100).queue(function(next) {
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
                });
                next();
            });
        }

        //kısıtlama ile ilgili fonksiyonlar başlangıç...
        function validateFullName(userName) {
            const regex = /^[A-Za-zÇçĞğİıÖöŞşÜü\s]+$/;
            return regex.test(userName);
            event.preventDefault(); // Formun gönderimini engelle
        }
        /*
                function validateEmail(userEmail) {
                    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return regex.test(userEmail);
                    event.preventDefault(); // Formun gönderimini engelle
                }

                function validateVehiclePlate(plate) {
                    //const regex = /^\d{2}\s[A-ZÇĞİÖŞÜ]{1,3}\s\d{2,3}\s?[A-ZÇĞİÖŞÜ]{0,1}\s?[0-9]{0,3}$/; BOŞLUKLU İSTERSEK.
                    const regex = /^\d{2}[A-ZÇĞİÖŞÜ]{1,3}\d{2,3}?[A-ZÇĞİÖŞÜ]{0,1}?[0-9]{0,3}$/;
                    return regex.test(plate);
                    event.preventDefault(); // Formun gönderimini engelle
                }
                //parola için kısıtlama
                function validatePassword(sifre) {
                    // Parola en az 8 karakterden oluşmalıdır.
                    if (sifre.length < 8) {
                        alert('Parola en az 8 karakterden oluşmalıdır.');
                        return false;
                    }

                    // Parola 50 karakterden fazla olmamalıdır.
                    if (sifre.length > 50) {
                        alert('Parola 50 karakterden fazla olamaz.');
                        return false;
                    }

                    // Parolada en az bir büyük harf, bir küçük harf, bir sayı ve bir özel karakter olmalıdır.
                    if (!/(?=.[a-zÇçĞğİıÖöŞşÜü])(?=.[A-ZÇçĞğİıÖöŞşÜü])(?=.*\d)[A-Za-zÇçĞğİıÖöŞşÜü\d]/.test(sifre)) {
                        alert('Parola güçlü değil. Lütfen en az bir büyük harf, bir küçük harf ve bir sayı içersin.');
                        return false;
                    }
                    // Tüm kısıtlamalar geçildiyse true döndür
                    return true;
                }*/

        function kisitlamalar(userName /*, tc, phoneNumber, userEmail, plate*/ ) {
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
            /*            //tc kısıtlamaları
                        if (tc.length !== 11) {
                            alert('TC numarı 11 haneli olmalıdır.');
                            return; // Fonksiyondan çık
                        }

                        //telefon kısıtlamaları
                        if (phoneNumber.length !== 10) {
                            alert('Telefon numarası 10 haneli olmalıdır.');
                            return;
                        }
                        //email kısıtlamaları
                        if (!validateEmail(userEmail)) {
                            alert('Lütfen geçerli bir e-posta adresi girin.');
                            return;
                        }
                        //araba plakası kısıtlamaları.
                        if (plate !== null && plate.trim() !== "") {
                            if (!validateVehiclePlate(plate)) {
                                alert('Lütfen geçerli bir araba plakası giriniz.');
                                return;
                            }
                        }*/
            return true;
        }
        //kısıtlama ile ilgili fonksiyonlar bitiş...
        var saveButton = document.getElementById('saveButton');

        saveButton.addEventListener('click', function() {
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

            for (var i = 0; i < selectedDurumArray.length; i++) {
                var durumParcalari = selectedDurumArray[i].split(',');

                for (var j = 0; j < durumParcalari.length; j++) {
                    durumArray.push(durumParcalari[j]);
                }
            }

            //console.log("durum Array = " + JSON.stringify(durumArray));

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
        });


        var updateButtons = document.querySelectorAll('.updateButton');

        updateButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var row = this.closest('tr'); // Güncellenen satırı bul
                var userID = row.getAttribute('data-userid');
                var userName = row.querySelector('td:nth-child(1)').textContent;
                var phoneNumber = row.querySelector('td:nth-child(2)').textContent;
                var userEmail = row.querySelector('td:nth-child(4)').textContent;
                var plate = row.querySelector('td:nth-child(5)').textContent;
                var gender = row.querySelector('td:nth-child(6) select').value;
                //alert(userName+","+phoneNumber+","+durum+","+userEmail+","+userID+","+plate+","+gender);
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
        new DataTable('#example', {
            initComplete: function() {
                this.api()
                    .columns()
                    .every(function() {
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

        $("#example input[type='checkbox']:first").click(function() {
            $("#example input[type='checkbox']").alterCheck('#example');
        });
        </script>