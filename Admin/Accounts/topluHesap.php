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
</head>

<body>
    <?php
try {
    //$sql = "SELECT *,blok_adi,daire_sayisi FROM tbl_users INNER JOIN tbl_daireler ON tbl_users.apartman_id = tbl_daireler.apartman_id WHERE rol = 3";
    $sql = "SELECT blok_adi,daire_sayisi FROM tbl_daireler WHERE apartman_id = " . $_SESSION["apartID"];
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    // Sonuç kümesinin satır sayısını kontrol etme
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        echo '<table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Blok Adı</th>
                        <th>Daire Sayısı</th>
                    </tr>
                </thead>
                <tbody>';

                foreach ($result as $row) {
                    echo '<tr data-userid="">
                            <td contenteditable="true">' . $row["blok_adi"] . '</td>
                            <td contenteditable="true">' . $row["daire_sayisi"] . '</td>
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

    <body>
        <script type="text/javascript">
        //kısıtlama ile ilgili fonksiyonlar başlangıç...
        function validateFullName(userName) {
            const regex = /^[A-Za-zÇçĞğİıÖöŞşÜü\s]+$/;
            return regex.test(userName);
            event.preventDefault(); // Formun gönderimini engelle
        }

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
        }

        function kisitlamalar(userName, tc, phoneNumber, userEmail, plate) {
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
            }
            return true;
        }
        //kısıtlama ile ilgili fonksiyonlar bitiş...

        var saveButton = document.getElementById('saveButton');
        saveButton.addEventListener('click', function() {
            var userName = $('input[name="userName"]').val();
            var tc = $('input[name="tc"]').val();
            var phoneNumber = $('input[name="phoneNumber"]').val();
            var durum = $('select#durum').val();
            var userEmail = $('input[name="userEmail"]').val();
            var plate = $('input[name="plate"]').val();
            var gender = $('select#gender').val();
            var apartman_id = $('input[name="apartman_id"]').val();
            //alert(userName+","+  tc+","+phoneNumber+","+durum+","+userEmail+","+apartman_id+","+plate+","+gender);
            if (kisitlamalar(userName, tc, phoneNumber, userEmail, plate)) {
                $.ajax({
                    url: 'Controller/save_user.php',
                    type: 'POST',
                    data: {
                        userName: userName,
                        tc: tc,
                        phoneNumber: phoneNumber,
                        durum: durum,
                        userEmail: userEmail,
                        plate: plate,
                        gender: gender,
                        apartman_id: apartman_id
                    },
                    success: function(response) {
                        //alert(response);
                        if (response == 1) {
                            location.reload();
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
                var tc = row.querySelector('td:nth-child(2)').textContent;
                var phoneNumber = row.querySelector('td:nth-child(3)').textContent;
                var durum = row.querySelector('td:nth-child(4) select').value;
                var userEmail = row.querySelector('td:nth-child(5)').textContent;
                var userPass = row.querySelector('td:nth-child(6)').textContent;
                var plate = row.querySelector('td:nth-child(7)').textContent;
                var gender = row.querySelector('td:nth-child(8) select').value;
                //alert(userName+","+  tc+","+phoneNumber+","+durum+","+userEmail+","+userID+","+plate+","+gender);
                if (kisitlamalar(userName, tc, phoneNumber, userEmail, plate)) {
                    $.ajax({
                        url: 'Controller/update_user.php',
                        type: 'POST',
                        data: {
                            userID: userID,
                            userName: userName,
                            tc: tc,
                            phoneNumber: phoneNumber,
                            durum: durum,
                            userEmail: userEmail,
                            userPass: userPass,
                            plate: plate,
                            gender: gender
                        },
                        success: function(response) {
                            //alert(response);
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
        </script>