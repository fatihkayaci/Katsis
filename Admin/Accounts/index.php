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

    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 20%;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    #openModalBtn {
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    </style>
</head>

<!-- Açma butonu ekleyelim -->
<button id="openModalBtn">Aç</button>

<!-- Modal yapısı -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <form id="popform" >
            <label>Full Name</label>
            <input type="text" id="full_Name" />
            <label>TC</label>
            <input type="number" id="TC" />
            <button type="button" onclick="Kaydet()">Kaydet</button>
            <button type="button" class="close" onclick="kapat()">close</button>
        </form>
    </div>
</div>
<div id="sonuc"></div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="script.js"></script>

<body>
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
                    </tr>
                </thead>
                <tbody>';

        foreach ($result as $row) {
            echo '<tr>
                    <td contenteditable="true">' . $row["fullName"] . '</td>
                    <td contenteditable="true">' . $row["TC"] . '</td>
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


    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
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
    // DataTable initialization ve diğer scriptler burada kalsın

    // Açma butonuna tıklanınca modalı açan JavaScript kodu
    document.getElementById('openModalBtn').addEventListener('click', function() {
        // Modalı görünür yap
        document.getElementById('myModal').style.display = 'block';
    });

    // Modalın kapatılmasını sağlayan JavaScript kodu
    document.querySelector('.close').addEventListener('click', function() {
        // Modalı gizle
        document.getElementById('myModal').style.display = 'none';
    });

    // Kullanıcının modal dışındaki bir yere tıkladığında modalı kapatma
    window.addEventListener('click', function(event) {
        var modal = document.getElementById('myModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });

    function Kaydet() {
        // Form verilerini al
        var kullaniciAdi = $("#full_Name").val();
        var tc= $("#TC").val();

        // AJAX isteği gönder
        $.ajax({
            type: "POST", // Veri gönderme yöntemi (GET veya POST)
            data: {
                veri: kullaniciAdi
                veri: tc
            }, // Gönderilecek veri
            success: function(response) {
                // İşlem başarılı olduğunda burası çalışacak
                $("#sonuc").html(response); // Sonucu ekrana yazdır
            },
            error: function(error) {
                // İşlem sırasında hata oluştuğunda burası çalışacak
                console.log("Hata: " + error);
            }
        });
    }
    </script>