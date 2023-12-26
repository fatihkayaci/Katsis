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
                    </tr>
                </thead>
                <tbody>';

        foreach ($result as $row) {
            echo '<tr>
                    <td contenteditable="true">' . $row["fullName"] . '</td>
                    <td contenteditable="true">' . $row["TC"] . '</td>
                    <td contenteditable="true">' . $row["phoneNumber"] . '</td>
                    <td contenteditable="true">' . $row["email"] . '</td>
                    <td contenteditable="true">' . $row["vehiclePlate"] . '</td>
                    <td contenteditable="true">' . $row["gender"] . '</td>
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
            <input type="text" name="fullName" required><br>

            <label for="TC">TC:</label>
            <input type="text" name="TC" required><br>

            <label for="phoneNumber">Phone Number:</label>
            <input type="text" name="phoneNumber" required><br>

            <label for="email">Email:</label>
            <input type="text" name="email" required><br>

            <label for="vehiclePlate">Vehicle Plate:</label>
            <input type="text" name="vehiclePlate" required><br>

            <label for="gender">Gender:</label>
            <input type="text" name="gender" required><br>

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

        var saveButton = document.getElementById('saveButton');

    
        saveButton.addEventListener('click', function() {
            $.ajax({
                url: 'Controller/save_user.php', 
                type: 'POST',
                success: function(response) {
                    alert(response);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });

        function saveUser() {
       
           
        }

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