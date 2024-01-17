<!--
    sonradan eklenecekler işlemler kısmı eklenecek.
    icra durumu
    bakiye.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
</head>

<body>
    <button class="adduser btn btn-primary">Kullanıcı Ekle</button>

    <?php
try {
    $sql = "SELECT * FROM tbl_kullanici WHERE apartmanID = " .$_SESSION["apartID"]  ;
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    // Sonuç kümesinin satır sayısını kontrol etme
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        echo '<table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>tc</th>
                        <th>Phone Number</th>
                        <th>Durum</th>
                        <th>Email</th>
                        <th>Şifre</th>
                        <th>Vehicle Plate</th>
                        <th>Gender</th>
                        <th>update</th>
                        <th>Delete</th>
                        <th>Özelleştir</th>
                    </tr>
                </thead>
                <tbody>';

                foreach ($result as $row) {
                    echo '<tr data-userid="' . $row["kullaniciID"] . '">
                            <td contenteditable="true">' . $row["fullName"] . '</td>
                            <td contenteditable="true">' . $row["tc"] . '</td>
                            <td contenteditable="true">' . $row["phoneNumber"] . '</td>
                            <td contenteditable="true">
                            <select>
                                <option value="katmaliki" ' . ($row["durum"] == "katmaliki" ? 'selected' : '') . '>katmaliki</option>
                                <option value="kiracı" ' . ($row["durum"] == "kiracı" ? 'selected' : '') . '>kiracı</option>
                            </select>
                            </td>
                            <td contenteditable="true">' . $row["email"] . '</td>
                            <td contenteditable="true">' . $row["sifre"] . '</td>
                            <td contenteditable="true">' . $row["vehiclePlate"] . '</td>
                            <td contenteditable="true">
                            <select>
                                <option value="Erkek" ' . ($row["gender"] == "Erkek" ? 'selected' : '') . '>Erkek</option>
                                <option value="Kadın" ' . ($row["gender"] == "Kadın" ? 'selected' : '') . '>Kadın</option>
                            </select>
                            </td>

                            <td><button class="updateButton">update</button></td>
                            <td><button class="deleteButton">delete</button></td>
                            <td><a href="index?parametre=custom"><button class="ozellestirButton">ozellestir</button></a></td>
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
    <div id="popup">
        <form class="login-form" id="userForm">
            
            <h2 class="form-signin-heading">Kullanıcı Ekleme</h2>
            
            <hr class="horizontal dark mt-0 w-100">

            <div class="row">
                <div class="col-md-6 col">
                    <label for="fullName">Ad Soyad :</label>
                    <input class="input" type="text" name="fullName" placeholder="İsminizi Giriniz." required><br>
                </div>

                <div class="col-md-6 col">
                    <label for="tc">T.C. Kimlik No :</label>
                    <input class="input" type="text" name="tc" placeholder="T.C. giriniz." required><br>
                </div>  
            </div>

            <div class="row">
                <div class="col-md-6 col">
                    <label for="phoneNumber">Telefon Numarası :</label>
                    <input class="input" type="text" name="phoneNumber" pattern="[0-9]{10}" placeholder="e.g., 5551234567" required><br>
                </div>

                <div class="col-md-6 col">
                    <label for="durum">Durum :</label>
                    <select class="input" id="durum">
                        <option value="katmaliki">kat Maliki</option>
                        <option value="kiracı">kiracı</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col margint">
                    <label for="email">E-Posta (opsiyonel) :</label>
                    <input class="input" type="text" name="email" placeholder="Email adresi (opsiyonel)"><br>
                </div>

                <div class="col-md-6 col">
                    <label for="vehiclePlate">Araba Plakası (opsiyonel) :</label>
                    <input class="input" type="text" name="vehiclePlate" placeholder="Araba plakası (opsiyonel)"><br>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col">
                    <label for="apartID">sadsad :</label>
                    <input class="input" type="text" name="apartID" value=<?php echo $_SESSION["apartID"];   ?> hidden>
                </div>

                <div class="col-md-6 col margint">
                    <label for="gender">Cinsiyet :</label>
                    <select class="input" id="gender">
                        <option value="Erkek">Erkek</option>
                        <option value="Kadın">Kadın</option>
                    </select>
                </div>
            </div>

            <hr class="horizontal dark mt-4 w-100">

            <div class="row row-btns">
                    <button type="button" class="btn btn-secondary btn-size" onclick="closePopup()">Kapat</button>
                    <button type="button" class="btn btn-primary btn-size" id="saveButton">Kaydet</button>
            </div>

            

        </form>
    </div>

    <body>
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script type="text/javascript">
        $('.adduser').click(function() {
            $('#popup').show();
            $('#popup').css('display', 'flex');
        });

        function closePopup() {
            $('#popup').hide();
            $('#popup').css('display', 'none');
        }

        //kısıtlama ile ilgili fonksiyonlar başlangıç...
        function validateFullName(fullName) {
            const regex = /^[A-Za-zÇçĞğİıÖöŞşÜü\s]+$/;
            return regex.test(fullName);
            event.preventDefault(); // Formun gönderimini engelle
        }

        function validateEmail(email) {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
            event.preventDefault(); // Formun gönderimini engelle
        }

        function validateVehiclePlate(vehiclePlate) {
            //const regex = /^\d{2}\s[A-ZÇĞİÖŞÜ]{1,3}\s\d{2,3}\s?[A-ZÇĞİÖŞÜ]{0,1}\s?[0-9]{0,3}$/; BOŞLUKLU İSTERSEK.
            const regex = /^\d{2}[A-ZÇĞİÖŞÜ]{1,3}\d{2,3}?[A-ZÇĞİÖŞÜ]{0,1}?[0-9]{0,3}$/;
            return regex.test(vehiclePlate);
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
            if (!/(?=.*[a-zÇçĞğİıÖöŞşÜü])(?=.*[A-ZÇçĞğİıÖöŞşÜü])(?=.*\d)[A-Za-zÇçĞğİıÖöŞşÜü\d]/.test(sifre)) {
                alert('Parola güçlü değil. Lütfen en az bir büyük harf, bir küçük harf ve bir sayı içersin.');
                return false;
            }


            // Tüm kısıtlamalar geçildiyse true döndür
            return true;
        }
        //kısıtlama ile ilgili fonksiyonlar bitiş...

        var saveButton = document.getElementById('saveButton');
        saveButton.addEventListener('click', function() {

            var fullName = $('input[name="fullName"]').val();
            var tc = $('input[name="tc"]').val();
            var phoneNumber = $('input[name="phoneNumber"]').val();
            var durum = $('select#durum').val();
            var email = $('input[name="email"]').val();
            var vehiclePlate = $('input[name="vehiclePlate"]').val();
            var gender = $('select#gender').val();
            var apartID = $('input[name="apartID"]').val();


            if (fullName.length < 3) {
                alert('Full Name en az 3 karakter olmalıdır.');
                return;
            }
            if (fullName.length > 100) {
                alert('Full Name 100den fazla karakter olamaz.');
                return;
            }
            if (!validateFullName(fullName)) {
                alert('Lütfen yalnızca harf karakterleri içeren geçerli bir tam ad girin.');
                return;
            }
            //tc kısıtlamaları
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
            if (!validateEmail(email)) {
                alert('Lütfen geçerli bir e-posta adresi girin.');
                return;
            }
            //araba plakası kısıtlamaları.
            if (vehiclePlate !== null && vehiclePlate.trim() !== "") {
                if (!validateVehiclePlate(vehiclePlate)) {
                    alert('Lütfen geçerli bir araba plakası giriniz.');
                    return;
                }
            }

            $.ajax({
                url: 'Controller/save_user.php',
                type: 'POST',
                data: {
                    fullName: fullName,
                    tc: tc,
                    phoneNumber: phoneNumber,
                    durum: durum,
                    email: email,
                    vehiclePlate: vehiclePlate,
                    gender: gender,
                    apartID: apartID
                },
                success: function(response) {
                    alert(response);
                    if (response == 1) {
                        location.reload();
                    }
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });

        var updateButtons = document.querySelectorAll('.updateButton');

        updateButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var row = this.closest('tr'); // Güncellenen satırı bul
                var kullaniciID = row.getAttribute('data-userid');
                var fullName = row.querySelector('td:nth-child(1)').textContent;
                var tc = row.querySelector('td:nth-child(2)').textContent;
                var phoneNumber = row.querySelector('td:nth-child(3)').textContent;
                var durum = row.querySelector('td:nth-child(4) select').value;
                var email = row.querySelector('td:nth-child(5)').textContent;
                var sifre = row.querySelector('td:nth-child(6)').textContent;
                var vehiclePlate = row.querySelector('td:nth-child(7)').textContent;
                var gender = row.querySelector('td:nth-child(8) select').value;
                //KISITLAMALAR BAŞLANGIÇ...
                //fullname
                if (fullName.length < 3) {
                    alert('Full Name en az 3 karakter olmalıdır.');
                    return;
                }
                if (fullName.length > 100) {
                    alert('Full Name 100den fazla karakter olamaz.');
                    return;
                }
                if (!validateFullName(fullName)) {
                    alert('Lütfen yalnızca harf karakterleri içeren geçerli bir tam ad girin.');
                    return;
                }
                //tc kısıtlamaları
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
                if (!validateEmail(email)) {
                    alert('Lütfen geçerli bir e-posta adresi girin.');
                    return;
                }
                //araba plakası kısıtlamaları.
                if (vehiclePlate !== null && vehiclePlate.trim() !== "") {
                    if (!validateVehiclePlate(vehiclePlate)) {
                        alert('Lütfen geçerli bir araba plakası giriniz.');
                        return;
                    }
                }
                if (!validatePassword(sifre)) {
                    return; // Kısıtlamaları geçemezse işlemi durdur
                }

                //KISITLAMALAR BİTİŞ...

                $.ajax({
                    url: 'Controller/update_user.php',
                    type: 'POST',
                    data: {
                        kullaniciID: kullaniciID,
                        fullName: fullName,
                        tc: tc,
                        phoneNumber: phoneNumber,
                        durum: durum,
                        email: email,
                        sifre: sifre,
                        vehiclePlate: vehiclePlate,
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
            });
        });
        var deleteButtons = document.querySelectorAll('.deleteButton');

        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var row = this.closest('tr'); // Güncellenen satırı bul
                var fullName = row.querySelector('td:nth-child(1)').textContent;
                var tc = row.querySelector('td:nth-child(2)').textContent;
                var phoneNumber = row.querySelector('td:nth-child(3)').textContent;
                var email = row.querySelector('td:nth-child(4)').textContent;
                var sifre = row.querySelector('td:nth-child(5)').textContent;
                var vehiclePlate = row.querySelector('td:nth-child(6)').textContent;
                var gender = row.querySelector('td:nth-child(7)').textContent;
                var kullaniciID = row.getAttribute('data-userid');
                $.ajax({
                    url: 'Controller/delete_user.php',
                    type: 'POST',
                    data: {
                        kullaniciID: kullaniciID,
                        fullName: fullName,
                        tc: tc,
                        phoneNumber: phoneNumber,
                        email: email,
                        sifre: sifre,
                        vehiclePlate: vehiclePlate,
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