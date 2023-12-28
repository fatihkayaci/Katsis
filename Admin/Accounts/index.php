<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <style>
    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }

    #popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 20px;
        background: #fff;
        z-index: 1000;
    }
    </style>
</head>

<body>
    <button class="adduser">Add User</button>
    <?php
try {
    $sql = "SELECT * FROM tbl_kullanici";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Sonuç kümesinin satır sayısını kontrol etme
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        echo '<table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>TC</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Vehicle Plate</th>
                        <th>Gender</th>
                        <th>update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>';

                foreach ($result as $row) {
                    echo '<tr data-userid="' . $row["kullanıcıID"] . '">
                            <td contenteditable="true">' . $row["fullName"] . '</td>
                            <td contenteditable="true">' . $row["TC"] . '</td>
                            <td contenteditable="true">' . $row["phoneNumber"] . '</td>
                            <td contenteditable="true">' . $row["email"] . '</td>
                            <td contenteditable="true">' . $row["vehiclePlate"] . '</td>
                            <td contenteditable="true">
                            <select>
                                <option value="Erkek" ' . ($row["gender"] == "Erkek" ? 'selected' : '') . '>Erkek</option>
                                <option value="Kadın" ' . ($row["gender"] == "Kadın" ? 'selected' : '') . '>Kadın</option>
                            </select>
                            </td>

                            <td><button class="updateButton">update</button></td>
                            <td><button class="deleteButton">delete</button></td>
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
        <form id="userForm">
            <label for="fullName">Full Name:</label>
            <input type="text" name="fullName" placeholder="İsminizi Giriniz." required><br>

            <label for="TC">TC:</label>
            <input type="text" name="TC" placeholder="T.C. giriniz." required><br>

            <label for="phoneNumber">Phone Number:</label>
            <input type="tel" name="phoneNumber" pattern="[0-9]{10}" placeholder="e.g., 5551234567" required><br>

            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="Email adresi(opsiyonel)"><br>

            <label for="vehiclePlate">Vehicle Plate:</label>
            <input type="text" name="vehiclePlate" placeholder="Araba plakası(opsiyonel)"><br>

            <label for="gender">gender</label>
            <select id="gender">
                <option value="Erkek">Erkek</option>
                <option value="Kadın">Kadın</option>
            </select>

            <button type="button" onclick="closePopup()">Close</button>
            <button type="button" id="saveButton">Save</button>
        </form>
    </div>

    <body>
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script type="text/javascript">
        $('.adduser').click(function() {
            $('#popup').show();
        });

        function closePopup() {
            $('#popup').hide();
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
        //kısıtlama ile ilgili fonksiyonlar bitiş...

        var saveButton = document.getElementById('saveButton');
        saveButton.addEventListener('click', function() {
            var fullName = $('input[name="fullName"]').val();
            var TC = $('input[name="TC"]').val();
            var phoneNumber = $('input[name="phoneNumber"]').val();
            var email = $('input[name="email"]').val();
            var vehiclePlate = $('input[name="vehiclePlate"]').val();
            var gender = $('select#gender').val(); // Gender bilgisini al
            //kısıtlamalar.
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
            if (TC.length !== 11) {
                alert('TC numarı 11 haneli olmalıdır.');
                return; // Fonksiyondan çık
            }

            //telefon kısıtlamaları
            if (phoneNumber.length !== 10) {
                alert('Telefon numarası 10 haneli olmalıdır.');
                return;
            }
            //email kısıtlamaları
            if (email !== null && email.trim() !== "") {
                if (!validateEmail(email)) {
                    alert('Lütfen geçerli bir e-posta adresi girin.');
                    return;
                }
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
                    TC: TC,
                    phoneNumber: phoneNumber,
                    email: email,
                    vehiclePlate: vehiclePlate,
                    gender: gender
                },
                success: function(response) {
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
                var kullanıcıID = row.getAttribute('data-userid');
                var fullName = row.querySelector('td:nth-child(1)').textContent;
                var TC = row.querySelector('td:nth-child(2)').textContent;
                var phoneNumber = row.querySelector('td:nth-child(3)').textContent;
                var email = row.querySelector('td:nth-child(4)').textContent;
                var vehiclePlate = row.querySelector('td:nth-child(5)').textContent;
                var gender = row.querySelector('td:nth-child(6) select').value; // Gender'ı seçili değerden al
                

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
                if (TC.length !== 11) {
                    alert('TC numarı 11 haneli olmalıdır.');
                    return; // Fonksiyondan çık
                }

                //telefon kısıtlamaları
                if (phoneNumber.length !== 10) {
                    alert('Telefon numarası 10 haneli olmalıdır.');
                    return;
                }
                //email kısıtlamaları
                if (email !== null && email.trim() !== "") {
                    if (!validateEmail(email)) {
                        alert('Lütfen geçerli bir e-posta adresi girin.');
                        return;
                    }
                }
                //araba plakası kısıtlamaları.
                if (vehiclePlate !== null && vehiclePlate.trim() !== "") {
                    if (!validateVehiclePlate(vehiclePlate)) {
                        alert('Lütfen geçerli bir araba plakası giriniz.');
                        return;
                    }
                }
                //KISITLAMALAR BİTİŞ...
                $.ajax({
                    url: 'Controller/update_user.php',
                    type: 'POST',
                    data: {
                        kullanıcıID: kullanıcıID,
                        fullName: fullName,
                        TC: TC,
                        phoneNumber: phoneNumber,
                        email: email,
                        vehiclePlate: vehiclePlate,
                        gender: gender
                    },
                    success: function(response) {
                        if (response == 1) {
                            alert("güncellendi" + response);
                            //location.reload();
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });
        });
        var deleteButtons = document.querySelectorAll('.deleteButton');

        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var row = this.closest('tr'); // Güncellenen satırı bul
                var fullName = row.querySelector('td:nth-child(1)').textContent;
                var TC = row.querySelector('td:nth-child(2)').textContent;
                var phoneNumber = row.querySelector('td:nth-child(3)').textContent;
                var email = row.querySelector('td:nth-child(4)').textContent;
                var vehiclePlate = row.querySelector('td:nth-child(5)').textContent;
                var gender = row.querySelector('td:nth-child(6)').textContent;
                var kullanıcıID = row.getAttribute('data-userid');
                $.ajax({
                    url: 'Controller/delete_user.php',
                    type: 'POST',
                    data: {
                        kullanıcıID: kullanıcıID,
                        fullName: fullName,
                        TC: TC,
                        phoneNumber: phoneNumber,
                        email: email,
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