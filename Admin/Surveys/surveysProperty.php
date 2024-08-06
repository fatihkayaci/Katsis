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
    <div class="cener-table">

    <?php

require_once "Controller/class.func.php";

try {
    $sql = "SELECT tbl_surveys.*, tbl_surveys_options.optionName
            FROM tbl_surveys
            JOIN tbl_surveys_options ON tbl_surveys.surveysID = tbl_surveys_options.surveysID
            WHERE tbl_surveys.surveysID = :surveysID";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':surveysID', $_SESSION['surveysID'], PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($result) {
        $options = [];
        foreach ($result as $row) {
            $options[] = $row['optionName'];
        }
        ?>
            <!-- profile area -->
            <div class="review-area mt-0">
                <div class="borc-info align-items-center">
                    <div class="toplu-borc-area">
                        <div class="bilgi-info toplu-flex mt-2">

                            <div class="toplu-p b-old mb-4">
        	                	<h4 class="mt-2 mb-2">Anket Ayarları</h4>
                                <div class="duzenleBtns">
                                    <button class="duzenleProfil" id="iptapBtn" onclick="iptal()" title="İptal"><i class="fa-solid fa-xmark"></i></button>
                                    <button class="duzenleProfil" id="duzenleBtn" onclick="okuma()" title="Profili Düzenle"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button class="duzenleProfil" id="kaydetBtn" onclick="saveProfil()" title="Kaydet"><i class="fa-solid fa-check"></i></button>
                                </div>
        	                </div>

                            <div class="toplu-borc-inside">
                                <div class="toplu-p b-old">
                                    <div class="esit-veri">
                                        <p>Anket Başlığı :</p>
                                        <p class="toplu-info">Anketin ana başlığıdır.</p>
                                    </div>
                                    <div class="esit-input">
                                        <input class="profile-edit font-inp name-edit" id="surveysQuestion" type="text" value="<?= !empty($row["surveysQuestion"]) ? $row["surveysQuestion"] : "-" ?>">
                                    </div>
                                </div>
                                <hr class="horizontal dark w-100">
                                <div class="toplu-p b-old">
                                    <div class="esit-veri">
                                        <p>Anket Açıklaması :</p>
                                        <p class="toplu-info">Anketin anlaşılabilmesi için yazılan açıklamasıdır.</p>
                                    </div>
                                    <div class="esit-input">
                                        <textarea name="aciklama" id="aciklama" class="input font-inp profile-edit textArea1"></textarea>
                                    </div>
                                </div>
                                <hr class="horizontal dark w-100">
                                <div class="toplu-p b-old">
                                    <div class="esit-veri">
                                        <p>Son Cevaplama Tarih :</p>
                                        <p class="toplu-info">Anketin son cevaplanabilir tarihi göstermektedir.</p>
                                    </div>
                                    <div class="esit-input">
                                        <input class="profile-edit font-inp w-100" id="lastDate" type="text" value="<?= tarihDonustur($row["lastDate"]) ?>">
                                    </div>
                                </div>
                                <hr class="horizontal dark w-100">
                                <div class="toplu-p b-old align-items-start">
                                    <div class="esit-veri">
                                        <p>Seçenekler :</p>
                                        <p class="toplu-info">Anketin cevap seçenekleri gösterilmektedir.</p>
                                    </div>
                                    <div class="esit-input">
                                        <div id="dynamic-options">
                                            <!-- Dinamik olarak eklenecek input alanları buraya gelecek -->
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark w-100">
                                <div class="toplu-p b-old">
                                    <div class="esit-veri">
                                        <p>Kişiler :</p>
                                        <p class="toplu-info">Anketleri Görüntüleyebilecek kişi grupları.</p>
                                    </div>
                                    <div class="esit-input">
                                        <div class="col-md-12">
                                            <div class="select-div m-0">
                                                <div class="dropdown-nereden">
                                                    <div class="group">
                                                        <input class="input font-inp profile-edit w-100" data-user-id="" type="text" id="kisiler" value="<?php
                                                        if($row["voters"] == 1){
                                                            echo "Tüm Kişiler";
                                                        }else if($row["voters"] == 2){
                                                            echo  "Kat Malikleri";
                                                        }else if($row["voters"] == 3){
                                                            echo  "Kiracılar";
                                                        }else{
                                                            echo " ";
                                                        }
                                                        ?>"
                                                            required="" />
                                                    </div>
                                                    
                                                    <div class="dropdown-content-nereden searchInput-btn" id="kisilerDP">
                                                        <div class="dropdown-content-inside-nereden mainpopupx">
                                                            <input type="hidden" id="kisilerSearch" placeholder="Ara...">
                                                            <button data-odeme-durumu="tumkisiler" name="tumkisiler">Tüm Kişiler</button>
                                                            <button data-odeme-durumu="katmaliki" name="katmaliki">Kat Malikleri</button>
                                                            <button data-odeme-durumu="kiraci" name="kiraci">Kiracılar</button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark w-100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <script>
            let options = <?= json_encode($options) ?>;
            let optionsContainer = document.getElementById('dynamic-options');
            options.forEach(option => {
                let input = document.createElement('input');
                input.className = 'profile-edit';
                input.classList.add('secenek-inpt','font-inp');
                input.type = 'text';
                input.value = option;
                optionsContainer.appendChild(input);
            });
        </script>
        <?php
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
        var voters = 0;

        $('.dropdown-content-inside-nereden button').click(function() {
            var selectedOption = $(this).attr('data-odeme-durumu');

            if (selectedOption === 'tumkisiler') {
                voters = 1;
            } else if (selectedOption === 'katmaliki') {
                voters = 2;
            } else if (selectedOption === 'kiraci') {
                voters = 3;
            }
        });

        $('#kaydetBtn').on('click', function() {
            var surveysID = $('#surveysID').val();
            var surveysQuestion = $('#surveysQuestion').val();
            var lastDate = $('#lastDate').val();
            var options = [];
            $('#dynamic-options input').each(function() {
                options.push($(this).val());
            });

            $.ajax({
                url: 'Controller/Surveys/surveysUpdate.php',
                type: 'POST',
                data: {
                    surveysID: surveysID,
                    surveysQuestion: surveysQuestion,
                    lastDate: lastDate,
                    voters: voters,
                    options: options
                },
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                success: function(response) {
                    location.reload(); // Sayfayı yeniden yükle
                },
                error: function(xhr, status, error) {
                    console.error('Gönderim hatası:', error);
                }
            });
        });
    });
    </script>

<script src="assets/js/mycode/dropdown.js"></script>
<script>
    
    dropDownn('kisiler', 'kisilerDP', 'kisilerSearch');
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
            location.reload();
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