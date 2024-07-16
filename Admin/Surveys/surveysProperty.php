<?php require_once "Controller/class.func.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <input type="hidden" id="surveysID" value=<?php echo $_SESSION['surveysID'] ?> />

    <?php

    try {
        $sql = "SELECT tbl_surveys.*, GROUP_CONCAT(tbl_surveys_options.optionName SEPARATOR ', ') as options
        FROM tbl_surveys
        JOIN tbl_surveys_options ON tbl_surveys.surveysID = tbl_surveys_options.surveysID
        WHERE tbl_surveys.surveysID = " . $_SESSION['surveysID'] . "
        GROUP BY tbl_surveys.surveysID";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if ($result) {
            foreach ($result as $row) {
                ?>
    <!-- profile area -->

    <div class="review-area">

        <div class="profile-area">

            <div class="name-area">
                <div class="user-info-top" >
                    <div class="top-guncelle">
                        <h5 class="user-name">
                            <input class="profile-edit" id="userName" type="text" value="<?= !empty($row["surveysQuestion"]) ? $row["surveysQuestion"] : "-" ?>">
                        </h5>
                        <div class="duzenleBtns">
                            <button class="duzenleProfil" id="iptapBtn" onclick="iptal()" title="İptal"><i class="fa-solid fa-xmark"></i></button>
                            <button class="duzenleProfil" id="duzenleBtn" onclick="okuma()" title="Profili Düzenle"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="duzenleProfil" id="kaydetBtn" onclick="saveProfil()" title="Kaydet"><i class="fa-solid fa-check"></i></button>
                        </div>
                    </div>
                    
                </div>

            </div>

            <div class="shown-info">

                <hr class="horizontal dark m-0 w-100">

                <div class="bilgi-p p-new">
                    <p>Son Tarih</p>
                    <input class="profile-edit" id="tc" type="text" value="<?= !empty($row["lastDate"]) ? $row["lastDate"] : "-" ?>">
                </div>
                <hr class="horizontal dark m-0 w-100">
                <div class="bilgi-p p-new">
                    <p>Seçenekler</p>
                    <input class="profile-edit" id="options" type="text" value="<?= !empty($row["optionName"]) ? $row["optionName"] : "-" ?>">
                </div>
                <hr class="horizontal dark m-0 w-100">

            </div>
        </div>

    </div>




    <?php
                                      
            }
        }
    } catch (PDOException $e) {
        echo "Bağlantı hatası: " . $e->getMessage();
    }
    ?>


<script>
    // Butonlara tıklanınca input alanını güncelleme
    document.querySelectorAll('.genderButton').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('gender').value = this.innerText;
        });
    });
</script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#kaydetBtn').on('click', function() {
            var userID = $('#userNo').data('user-id');
            var userNo = $('#userNo').val();
            var userName = $('#userName').val();
            var phoneNumber = $('#phoneNumber').val();
            var gender = $('#gender').val();
            var tc = $('#tc').val();
            var password = $('#parola').val();
            var userEmail = $('#userEmail').val();
            var plate = $('#plate').val();
            //plate var birde ona bakılacak

            $.ajax({
                url: 'Controller/Accounts/updateOzellestir.php',
                type: 'POST',
                data: {
                    userNo: userNo,
                    userName: userName,
                    phoneNumber: phoneNumber,
                    gender: gender,
                    tc: tc,
                    password: password,
                    userEmail: userEmail,
                    plate: plate,
                    userID: userID
                },
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                success: function(response) {
                    console.log(response);
                    if (response == 1) {
                        location.reload(); // Sayfayı yeniden yükle
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Gönderim hatası:', error);
                }
            });
        });
    });
    </script>

    <!-- =============================== -->
    <!-- custom gender input start -->
  
    <script>
        function okuma() {
            // .profile-edit öğelerine "activeEdit" sınıfını ekle
            const elements = document.querySelectorAll('.profile-edit');
            elements.forEach(element => {
                element.classList.add('activeEdit');
            });
        
            // Butonların görünürlüğünü ayarla
            document.getElementById('iptapBtn').style.display = 'flex';
            document.getElementById('kaydetBtn').style.display = 'flex';
            document.getElementById('duzenleBtn').style.display = 'none';
        }

        function iptal() {
            // .profile-edit öğelerinden "activeEdit" sınıfını kaldır
            const elements = document.querySelectorAll('.profile-edit');
            elements.forEach(element => {
                element.classList.remove('activeEdit');
            });
        
            // Butonların görünürlüğünü ayarla
            document.getElementById('iptapBtn').style.display = 'none';
            document.getElementById('kaydetBtn').style.display = 'none';
            document.getElementById('duzenleBtn').style.display = 'flex';
        }

        function saveProfil() {
            // Profil kaydetme işlemlerini burada gerçekleştirin
            const elements = document.querySelectorAll('.profile-edit');
            elements.forEach(element => {
                element.classList.remove('activeEdit');
            });        
            // Kaydetme işleminden sonra butonların görünürlüğünü ayarla
            document.getElementById('iptapBtn').style.display = 'none';
            document.getElementById('kaydetBtn').style.display = 'none';
            document.getElementById('duzenleBtn').style.display = 'flex';
        }

    </script>