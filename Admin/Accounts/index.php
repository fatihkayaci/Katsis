<<<<<<< HEAD









=======
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
    </style>
</head>
<body>

<?php

$host = "45.10.151.41";
$db_name = "katsis";
$username = "root";
$password = "ELlggUcQi62HjoAZ";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    // PDO hata modunu ayarla
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Veritabanından veri çekme
    $stmt = $conn->prepare("SELECT * FROM tbl_users");
    $stmt->execute();

    // Sonuç kümesinin satır sayısını kontrol etme
    $rowCount = $stmt->rowCount();

    if ($rowCount > 0) {
        echo '<table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>';

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>
                    <td contenteditable="true">' . $row["userID"] . '</td>
                    <td contenteditable="true">' . $row["userName"] . '</td>
                    <td contenteditable="true">' . $row["userEmail"] . '</td>
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

// Bağlantıyı kapat
$conn = null;
?>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
   new DataTable('#example', {
    initComplete: function () {
        this.api()
            .columns()
            .every(function () {
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
</body>
</html>
>>>>>>> 393bda5336bb34889b1c082a2a517448520f2394
