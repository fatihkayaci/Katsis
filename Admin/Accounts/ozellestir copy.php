<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <input type="hidden" id="apartmanId" value=<?php echo $_SESSION["apartID"] ?> />
    <input type="hidden" id="userId" value=<?php echo $_SESSION['userPage'] ?> />
    <input type="hidden" id="daireId" value=<?php echo $_SESSION['dId'] ?> />

    <?php

    try {
        $sql = "SELECT u.userID, u.userName, u.user_no, u.userEmail, u.gender, u.userPass, u.plate, u.tc, u.phoneNumber, 
    d.daire_id, b.blok_adi AS blok_adi, d.kiraciGiris, d.katMGiris, d.daire_sayisi,
    CASE
        WHEN d.katMalikiID = u.userID THEN 'Kat Maliki'
        WHEN d.kiraciID = u.userID THEN 'Kiracı'
        ELSE 'Belirtilmemiş'
    END AS durum
    FROM tbl_users u
    LEFT JOIN tbl_daireler d ON u.userID = d.katMalikiID OR u.userID = d.kiraciID
    LEFT JOIN tbl_blok b ON d.blok_adi = b.blok_id
    WHERE rol=3 AND u.apartman_id = " . $_SESSION["apartID"] . " AND u.userID = " . $_SESSION['userPage'];
        if (!$_SESSION['dId'] == "") {
            $sql .= " AND d.daire_id = " . $_SESSION['dId'];
        }
        $sql .= " ORDER BY u.userID ASC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Sonuç kümesinin satır sayısını kontrol etme
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $kategori_listesi = array();
        $sql2 = "SELECT * FROM tbl_kategori where apartman_id=" . $_SESSION["apartID"];
        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute();
        $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result2 as $row2) {
            $kategori_listesi[$row2['kategori_id']] = $row2['kategori_adi'];
        }


        $turu=1;
        //////////////////////////////////
        $sql4 = "SELECT m.aciklama, m.odeme_tar, m.borc_miktar, 
(SELECT SUM(borc_miktar) FROM tbl_maliye 
 WHERE user_id = :user_id AND apartman_id = :apartman_id AND maliye_turu = :maliyeturu";

        if (!empty($_SESSION['dId'])) {
            $sql4 .= " AND daire_id = :daire_id";
        }

        $sql4 .= ") AS toplam_borc, k.kategori_adi
FROM tbl_maliye m
INNER JOIN tbl_kategori k ON m.kategori_id = k.kategori_id
WHERE m.user_id = :user_id AND m.apartman_id = :apartman_id AND maliye_turu = :maliyeturu";

        if (!empty($_SESSION['dId'])) {
            $sql4 .= " AND m.daire_id = :daire_id";
        }

        // Sorguyu hazırla
        $stmt4 = $conn->prepare($sql4);

        // Değişkenleri bağla
        $stmt4->bindParam(':user_id', $_SESSION['userPage'], PDO::PARAM_INT);
        $stmt4->bindParam(':apartman_id', $_SESSION["apartID"], PDO::PARAM_INT);
        $stmt4->bindParam(':maliyeturu', $turu, PDO::PARAM_INT);


        if (!empty($_SESSION['dId'])) {
            $stmt4->bindParam(':daire_id', $_SESSION['dId'], PDO::PARAM_INT);
        }

        // Sorguyu çalıştır
        $stmt4->execute();

        // Sonuçları al
        $result4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
        if ($result4) {
            $toplamBorc = $result4[0]['toplam_borc'];
        } else {
            $toplamBorc = 0;
        }
        













        /////////////////////////////////
    






        if ($result) {
            foreach ($result as $row) {
                ?>



                <!-- POPUPLARIN OLUŞTURULDUĞU BÖLÜM-->

                <!-- Borç Ekleme Popup-->
                <div id="popupBorcEkle" class="form-popup">

                    <form id="borcEkleForm" class="login-form">

                        <h2 class="form-signin-heading">Borç Ekle</h2>


                        <div class="row">

                            <div class="col-md-6 col-btn">
                                <input class="input" type="text" id="aciklama" required="" />
                                <label id="aciklamaLabel" for="aciklama">Açıklama *: </label>
                            </div>

                            <div class="col-md-12 col-btn">
                                <input class="input" type="text" id="borcTutar" placeholder="0,00" step="0.01"
                                    onclick="selectInput(this)" onkeypress="return onlyNumberKey(event)" />
                                <label id="borcLabel" for="borcTutar">Borç Tutarı *:</label>
                            </div>

                            <div class="col-md-6 col">
                                <input class="input" type="date" value="<?php echo date('Y-m-d'); ?>" id="dateInput" required="" />
                                <label id="label_tarih" for="dateInput">Borç Tanımlama Tarihi :</label>
                            </div>

                            <div class="col-md-6 col">
                                <input class="input" type="date" value="<?php echo date('Y-m-d', strtotime('+7 days')); ?>"
                                    id="dateInput2" required="" />
                                <label id="label_tarih2" for="dateInput2">Son Ödeme Tarihi :</label>
                            </div>

                            <div class="col-md-6 col-btn">

                                <!-- <select class="input" id="kategori" required="">
                                    <option style="display: none;" value="" disabled selected></option>
                                    <?php
                                    foreach ($kategori_listesi as $kategori_id => $kategori_adi) {
                                        echo "<option value='" . $kategori_id . "'>" . $kategori_adi . "</option>";
                                    }
                                    ?>
                                </select>
                                <label id="kategoriLabel" for="kategori">Kategoriler *</label> -->

                                <div class="select-div">
                                    <input class="search-selectx input" type="text" list="Users" id="kategori" name="options" required="" />
                                    <label id="kategoriLabel" class="selectx-label" for="kategori">Kategoriler : *</label>
                                    <ul class="value-listx" id="kategoriDrop">
                                        <?php 
                                            foreach($kategori_listesi as $kategori_id => $kategori_adi){
                                                echo '                                        
                                                   <li class="li-select" data-user-id="' . $kategori_adi . '">' . $kategori_adi . '</li>';
                                            }
                                        ?>                                        
                                    </ul>
                                </div>
                            </div>

                        </div>

                        <hr class="horizontal dark w-100">

                        <div class="row row-btn">
                            <button type="button" class="btn-custom-close"
                                onclick="popupCloseControl('popupBorcEkle','borcEkleForm')">Kapat</button>
                            <button type="button" class="btn-custom" id="saveButton" onclick="borcAdd()">Kaydet</button>
                        </div>

                    </form>

                </div>

                <!-- =========================================== -->

                <!-- Tahsilat Ekleme Popup-->
                <div id="popupTahsilatEkle" class="form-popup">

                    <form id="tahsilatEkleForm" class="login-form">

                        <h2 class="form-signin-heading">Tahsilat Ekle</h2>


                        <div class="row">

                            <div class="col-md-12 col-btn">
                                <input class="input" type="text" id="aciklama_tahsilat" required="" />
                                <label id="aciklamaLabel_tahsilat" for="aciklama_tahsilat">Açıklama *: </label>
                            </div>

                            <div class="col-md-12 col-btn">
                                <input class="input" type="text" id="tahsilatTutar" />
                                <label id="tahsilatLabel" for="tahsilatTutar">Tahsilat Tutarı *:</label>
                            </div>

                            <div class="col-md-12 col-btn">
                                <input class="input" type="date" value="<?php echo date('Y-m-d'); ?>" id="dateInput3" required="" />
                                <label id="label_tarih3" for="dateInput3">Tahsilat Tarihi :</label>
                            </div>

                            

                        </div>

                        <hr class="horizontal dark w-100">

                        <div class="row row-btn">
                            <button type="button" class="btn-custom-close"
                                onclick="popupCloseControl('popupTahsilatEkle','tahsilatEkleForm')">Kapat</button>
                            <button type="button" class="btn-custom" id="saveButton" onclick="tahsilatAdd()">Kaydet</button>
                        </div>

                    </form>

                </div>
                <!-- =========================================== -->

                <div class="emp-profile row">

                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                        <div class="h-100">
                            <div class="contact-form">
                                <div class="account-settings">

                                    <div class="user-profile">
                                        <?php
                                        $names = explode(" ", $row["userName"]);
                                        $initials = "";
                                        $count = 0;
                                        foreach ($names as $name) {
                                            $initials .= strtoupper(substr($name, 0, 1));
                                            $count++;
                                            if ($count == 2) {
                                                break;
                                            }
                                        }
                                        ?>
                                        <div class="user-avatar">
                                            <p>
                                                <?php echo $initials; ?>
                                            </p>
                                        </div>
                                        <h5 class="user-name">
                                            <?= !empty($row["userName"]) ? $row["userName"] : "-" ?>
                                        </h5>
                                    </div>
                                    <hr class="horizontal dark mt-0">
                                    <div class="ps-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <label for="tc">T.C. Kimlik No</label>
                                        <p id="tc">
                                            <?= !empty($row["tc"]) ? $row["tc"] : "-" ?>
                                        </p>
                                    </div>
                                    <hr class="horizontal dark mt-0">
                                    <div class="ps-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <label for="phoneNumber">Telefon Numarası</label>
                                        <p id="phoneNumber">
                                            <?= !empty($row["phoneNumber"]) ? $row["phoneNumber"] : "-" ?>
                                        </p>
                                    </div>
                                    <hr class="horizontal dark mt-0">
                                    <div class="ps-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <label for="userEmail">E-Posta</label>
                                        <p id="userEmail">
                                            <?= !empty($row["userEmail"]) ? $row["userEmail"] : "-" ?>
                                        </p>
                                    </div>
                                    <hr class="horizontal dark mt-0">
                                    <div class="ps-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <label for="gender">Cinsiyet</label>
                                        <p id="gender">
                                            <?= !empty($row["gender"]) ? $row["gender"] : "-" ?>
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                        <div class="h-100">
                            <div class="contact-form">

                                <form id="" method="post" action="">

                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <h6 class="mb-2">Daire Bilgileri</h6>
                                        </div>

                                        <hr class="horizontal dark mt-3">

                                        <div class="bilgi-p col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                            <p class="bilgi-p">Durumu :</p>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                            <div class="cursor-none main-durum <?php
                                          
                                                if ($row["durum"] == "Kiracı") {
                                                    echo "kiraci";
                                                } elseif ($row["durum"] == "Kat Maliki") {
                                                    echo "kat-maliki";
                                                } else {
                                                    echo "belirtilmemis";
                                                }
                                            ?>">
                                                <?php
                            
                                                    echo $row["durum"];
                                                ?>
                                            </div>
                                        </div>

                                        <hr class="horizontal dark mt-0">

                                        <div class="bilgi-p col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                            <p class="bilgi-p">Daire :</p>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">

                                            <?php
                                            if (!empty($row["blok_adi"]) && !empty($row["daire_sayisi"])) { ?>

                                                <p class="daire-link" onclick=userGo(<?= !empty($row["daire_id"]) ? $row["daire_id"] : "null" ?>)>
                                                    <?php
                                                    if (!empty($row["blok_adi"]) && !empty($row["daire_sayisi"])) {
                                                        echo $row["blok_adi"] . " / " . $row["daire_sayisi"];
                                                        ?>
                                                        <i class="fa-solid fa-link"></i>
                                                    </p>
                                                    <?php

                                                    } else {
                                                        echo "-";
                                                    }
                                            }
                                            ?>

                                        </div>

                                        <hr class="horizontal dark mt-0">

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                            <p class="bilgi-p">Kullanıcı No :</p>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                            <p class="bilgi-p">
                                                <?= !empty($row["user_no"]) ? $row["user_no"] : "-" ?>
                                            </p>
                                        </div>

                                        <hr class="horizontal dark mt-0">

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                            <p class="bilgi-p">Giriş Tarihi :</p>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                            <p class="bilgi-p">
                                                <?php
                                                if ($row["durum"] == "Kiracı") {
                                                    echo $row["kiraciGiris"];
                                                } else if ($row["durum"] == "Kat Maliki") {
                                                    echo $row["katMGiris"];
                                                }
                                                ?>
                                            </p>
                                        </div>

                                        <hr class="horizontal dark mt-0">

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                            <p class="bilgi-p">Son Oturum Açma Tarihi :</p>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                            <p class="bilgi-p">Son Oturum Açma Tarihi yazılacak</p>
                                        </div>

                                        <hr class="horizontal dark mt-0">

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                            <p class="bilgi-p">Parola :</p>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                            <p class="bilgi-p">
                                                <?php echo base64_decode($row["userPass"]); ?>
                                            </p>
                                        </div>

                                        <hr class="horizontal dark mt-0">

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                            <p class="bilgi-p">Araç Plakası :</p>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                            <p class="bilgi-p">
                                                <?= !empty($row["plate"]) ? $row["plate"] : "-" ?>
                                            </p>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="h-100">
                            <div class="contact-form overflow-borc">
                                <div class="account-settings">

                                    <div class="input-group-div fixed-borc">
                                        <div class="input-group1">
                                            <button class="btn-custom-outline bcoc1"
                                                onclick=" popupOpenControl('popupBorcEkle','borcEkleForm')">Borç</button>

                                            <?php if ($toplamBorc > 0) { ?>


                                                <button class="btn-custom-outline bcoc1"
                                                    onclick=" popupOpenControl('popupTahsilatEkle','tahsilatEkleForm')">Tahsilat</button>
                                            <?php } ?>

                                        </div>
                                        <div class="input-group1">
                                            <button class="btn-custom-outline bcoc3">Düzenle</button>
                                        </div>
                                    </div>
                                    <input type="hidden" id="topborc" value=<?php echo $toplamBorc; ?> />
                                    <div class="borc-box">
                                    <a href="">
                                                <p class="tarih">BAKİYE : </p>
                                                <p class="borc">
                                                    <?php echo $toplamBorc; ?> <img class="tl-img"
                                                        src="../Admin\assets\img\tl.png" alt="">
                                                </p>
                                            </a>
                                        <?php

                                        if ($result4) {
                                            foreach ($result4 as $row4) {

                                                $odeme_tarihi = $row4['odeme_tar'];

                                                // Türkçe ay isimleri dizisi
                                                $turkce_aylar = array(
                                                    '01' => 'Ocak',
                                                    '02' => 'Şubat',
                                                    '03' => 'Mart',
                                                    '04' => 'Nisan',
                                                    '05' => 'Mayıs',
                                                    '06' => 'Haziran',
                                                    '07' => 'Temmuz',
                                                    '08' => 'Ağustos',
                                                    '09' => 'Eylül',
                                                    '10' => 'Ekim',
                                                    '11' => 'Kasım',
                                                    '12' => 'Aralık'
                                                );

                                                // Tarihi parçalara ayırma
                                                $tarih_parcalari = explode('-', $odeme_tarihi);
                                                $gun = $tarih_parcalari[2];
                                                $ay = $turkce_aylar[$tarih_parcalari[1]];
                                                $yil = $tarih_parcalari[0];

                                                // Yeni format
                                                $yeni_format = $gun . ' ' . $ay . ' ' . $yil;
                                                ?>

                                                <a href="">
                                                    <p class="tarih">
                                                        <?php echo $yeni_format; ?>
                                                    </p>
                                                    <p class="aciklama">
                                                        <?php echo $row4['aciklama']; ?>
                                                        <p class="aciklama">
                                                            <?php echo $row4['kategori_adi']; ?>
                                                        </p>
                                                        <p class="borc">
                                                            <?php echo $row4['borc_miktar']; ?> <img class="tl-img"
                                                                src="../Admin\assets\img\tl.png" alt="">
                                                        </p>
                                                </a>

                                            <?php } ?>
                                          
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <?php
                                        }
            }
        }
    } catch (PDOException $e) {
        echo "Bağlantı hatası: " . $e->getMessage();
    }
    ?>



    <script type="text/javascript">
        $(document).ready(function () {
            $('#borcTutar').css('border-color', '#0d0c22');
            $('#borcLabel').css('color', '#0d0c22');
            $('#dateInput').css('border-color', '#0d0c22');
            $('#label_tarih').css('color', '#0d0c22');
            $('#dateInput2').css('border-color', '#0d0c22');
            $('#label_tarih2').css('color', '#0d0c22');
        });



        function borcAdd() {
            var apartmanId = document.getElementById('apartmanId').value;
            var userId = document.getElementById('userId').value;
            var daireId = document.getElementById('daireId').value;
            var gelir_turu = 1;
            var aciklamaValue = document.getElementById('aciklama').value;
            var borcTutarValue = document.getElementById('borcTutar').value;
            var dateInputValue = document.getElementById('dateInput').value;
            var dateInput2Value = document.getElementById('dateInput2').value;
            var kategoriValue = document.getElementById('kategori').value;
            var a1 = true,
                a2 = true,
                a3 = true,
                a4 = true,
                a5 = true,
                a6 = true;


            if (aciklamaValue.trim() === '') {
                $('#aciklama').css('border-color', 'red');
                $('#aciklamaLabel').css('color', 'red');
                a1 = false;
            }

            if (borcTutarValue.trim() === '' || borcTutarValue <= 0) {
                $('#borcTutar').css('border-color', 'red');
                $('#borcLabel').css('color', 'red');
                a2 = false;
            }

            if (dateInputValue.trim() === '') {
                $('#dateInput').css('border-color', 'red');
                $('#label_tarih').css('color', 'red');
                a3 = false;
            }

            if (dateInput2Value.trim() === '') {
                $('#dateInput2').css('border-color', 'red');
                $('#label_tarih2').css('color', 'red');
                a4 = false;
            }


            if (kategoriValue.trim() === '') {
                $('#kategori').css('border-color', 'red');
                $('#kategoriLabel').css('color', 'red');
                a5 = false;
            }

            if (!a5 || !a4 || !a1 || !a3 || !a2) {
                alert("İlgili Alanlar Boş Olamaz");

            } else {

                $.ajax({
                    url: 'Controller/maliye_kayit.php',
                    type: 'POST',
                    data: {
                        daireId: daireId,
                        userId: userId,
                        apartmanId: apartmanId,
                        gelir_turu: gelir_turu,
                        aciklamaValue: aciklamaValue,
                        borcTutarValue: borcTutarValue,
                        dateInputValue: dateInputValue,
                        dateInput2Value: dateInput2Value,
                        kategoriValue: kategoriValue,

                    },
                    success: function (response) {
                        if (response) {
                            document.getElementById('aciklama').value = "";
                            document.getElementById('borcTutar').value = "";
                            document.getElementById('kategori').value = "";
                            popupCloseControl('popupBorcEkle', 'borcEkleForm');
                            location.reload();
                        }


                    },
                    error: function (xhr, status, error) {
                        var errorMessage = xhr.status + ': ' + xhr.statusText;
                        alert('Hata alındı: ' + errorMessage);
                    }
                });




            }





        }
        // Form alanlarına odaklandığında kendi renklerine dönmesi için yazılan kodlar.
        $('#aciklama').focus(function () {
            $('#aciklama').css('border-color', '#277ce0');
            $('#aciklamaLabel').css('color', '#277ce0');
        });

        // Borç Tutarı alanına odaklandığınızda
        $('#borcTutar').focus(function () {
            $('#borcTutar').css('border-color', '#277ce0');
            $('#borcLabel').css('color', '#277ce0');
        });

        // Tarih alanına odaklandığınızda
        $('#dateInput').focus(function () {
            $('#dateInput').css('border-color', '#277ce0');
            $('#label_tarih').css('color', '#277ce0');
        });

        // Diğer Tarih alanına odaklandığınızda
        $('#dateInput2').focus(function () {
            $('#dateInput2').css('border-color', '#277ce0');
            $('#label_tarih2').css('color', '#277ce0');
        });

        // Kategori alanına odaklandığınızda
        $('#kategori').focus(function () {
            $('#kategori').css('border-color', '#277ce0');
            $('#kategoriLabel').css('color', '#277ce0');
        });



        // Aciklama alanından odak kaybedildiğinde
        $('#aciklama').blur(function () {

            $('#aciklama').css('border-color', '#0d0c22');
            $('#aciklamaLabel').css('color', '#0d0c22');

        });

        // Borç Tutarı alanından odak kaybedildiğinde
        $('#borcTutar').blur(function () {
            $('#borcTutar').css('border-color', '#0d0c22');
            $('#borcLabel').css('color', '#0d0c22');
        });

        // Tarih alanından odak kaybedildiğinde
        $('#dateInput').blur(function () {
            $('#dateInput').css('border-color', '#0d0c22');
            $('#label_tarih').css('color', '#0d0c22');
        });

        // Diğer Tarih alanından odak kaybedildiğinde
        $('#dateInput2').blur(function () {
            $('#dateInput2').css('border-color', '#0d0c22');
            $('#label_tarih2').css('color', '#0d0c22');
        });

        // Kategori alanından odak kaybedildiğinde
        $('#kategori').blur(function () {
            $('#kategori').css('border-color', '#0d0c22');
            $('#kategoriLabel').css('color', '#0d0c22');
        });







        //////////////////////  TAHSİLAT İŞLEMLERİ /////////////////////
function tahsilatAdd(){
            
            var apartmanId = document.getElementById('apartmanId').value;
            var userId = document.getElementById('userId').value;
            var daireId = document.getElementById('daireId').value;
            var gelir_turu = 0;
            var aciklamaValue1 = document.getElementById('aciklama_tahsilat').value;
            var tahsilatTutarValue = document.getElementById('tahsilatTutar').value;
            var dateInputValue11 = document.getElementById('dateInput3').value;
            var b1 = true,
                b2 = true,
                b3 = true;
                
            if (aciklamaValue1.trim() === '') {
                $('#aciklama_tahsilat').css('border-color', 'red');
                $('#aciklamaLabel_tahsilat').css('color', 'red');
             b1=false;
            }

            if (tahsilatTutarValue.trim() === '' || tahsilatTutarValue <= 0) {
                $('#tahsilatTutar').css('border-color', 'red');
                $('#tahsilatLabel').css('color', 'red');
                b2=false;
            }

            if (dateInputValue11.trim() === '') {
                $('#dateInput3').css('border-color', 'red');
                $('#label_tarih3').css('color', 'red');
                b3=false;
            }
            if ( !b1 || !b3 || !b2) {
                alert("İlgili Alanlar Boş Olamaz");

            } else {

                $.ajax({
                    url: 'Controller/maliye_tahsilat.php',
                    type: 'POST',
                    data: {
                        daireId: daireId,
                        userId: userId,
                        apartmanId: apartmanId,
                        gelir_turu: gelir_turu,
                        aciklamaValue: aciklamaValue1,
                       TahsilatTutarValue: tahsilatTutarValue,
                        dateInputValue: dateInputValue11,

                    },
                    success: function (response) {
                        alert(response);
                        if (response) {
                            document.getElementById('aciklama').value = "";
                            document.getElementById('borcTutar').value = "";
                            document.getElementById('kategori').value = "";
                            popupCloseControl('popupBorcEkle', 'borcEkleForm');
                            location.reload();
                        }


                    },
                    error: function (xhr, status, error) {
                        var errorMessage = xhr.status + ': ' + xhr.statusText;
                        alert('Hata alındı: ' + errorMessage);
                    }
                });




            }


}
        $('#aciklama_tahsilat').focus(function () {
            $('#aciklama_tahsilat').css('border-color', '#277ce0');
            $('#aciklamaLabel_tahsilat').css('color', '#277ce0');
        });

        // Borç Tutarı alanına odaklandığınızda
        $('#tahsilatTutar').focus(function () {
            $('#tahsilatTutar').css('border-color', '#277ce0');
            $('#tahsilatLabel').css('color', '#277ce0');
        });

        // Tarih alanına odaklandığınızda
        $('#dateInput3').focus(function () {
            $('#dateInput3').css('border-color', '#277ce0');
            $('#label_tarih3').css('color', '#277ce0');
        });
        //////////////////////////////////////////////

        $('#aciklama_tahsilat').blur(function () {

$('#aciklama_tahsilat').css('border-color', '#0d0c22');
$('#aciklamaLabel_tahsilat').css('color', '#0d0c22');

});

// Borç Tutarı alanından odak kaybedildiğinde
$('#tahsilatTutar').blur(function () {
$('#tahsilatTutar').css('border-color', '#0d0c22');
$('#tahsilatLabel').css('color', '#0d0c22');
});

// Tarih alanından odak kaybedildiğinde
$('#dateInput3').blur(function () {
$('#dateInput3').css('border-color', '#0d0c22');
$('#label_tarih3').css('color', '#0d0c22');
});


        function userGo(id) {


            var d = "daire";
            $.ajax({
                url: 'Controller/create_session.php',
                type: 'POST',
                data: {

                    id: id,
                    d: d,

                },
                success: function (response) {


                    if (response) {
                        window.location.href = "index.php?parametre=detail";
                        localStorage.setItem('selectedLink', 'Accounts');
                    }



                },
                error: function (xhr, status, error) {
                    var errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Hata alındı: ' + errorMessage);
                }
            });
        }



        //POPUPLARIN AÇMA KAPATMA KODLARI

        function popupOpenControl(popupName, popupForm) {

            $('body').css('overflow', 'hidden');

            $('#' + popupName).show().css('display', 'flex').delay(100).queue(function (next) {
                $('#' + popupName).css('opacity', '1');
                $('#' + popupForm).css('opacity', '1');
                $('#' + popupForm).css('transform', 'translateY(0)');
                next();
            });
        }


        function popupCloseControl(popupName, popupForm) {

            $('#' + popupForm).css('opacity', '0').css('transform', 'translateY(-180px)').delay(100).queue(function (next) {
                $('#' + popupName).css('opacity', '0').delay(300).queue(function (nextInner) {
                    $(this).hide().css('display', 'none');
                    nextInner();
                    $('body').css('overflow', 'auto');
                });
                next();
            });

        }



        function onlyNumberKey(evt) {
            // Prevents the default action of the key pressed
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;

            // Allows only digits, comma, and backspace keys
            if (charCode > 31 && (charCode != 44) && (charCode < 48 || charCode > 57))
                return false;

            // Ensures only one decimal point
            if (charCode == 44) {
                if (evt.target.value.indexOf(',') !== -1 || evt.target.value.indexOf('.') !== -1)
                    return false;
            }

            // Limits to two decimal places after comma or dot
            if (evt.target.value.indexOf(',') !== -1 || evt.target.value.indexOf('.') !== -1) {
                var dotIndex = evt.target.value.indexOf(',') !== -1 ? evt.target.value.indexOf(',') : evt.target.value
                    .indexOf('.');
                var afterDotLength = evt.target.value.length - dotIndex;
                if (afterDotLength > 2)
                    return false;
            }

            return true;
        }

        function selectInput(input) {
            input.select();

        }



        var topborc = document.getElementById('topborc').value;
            document.getElementById('tahsilatTutar').value=topborc;
        // Tarihlerin kontrolü
        var dateInput = document.getElementById('dateInput');
        var dateInput2 = document.getElementById('dateInput2');


        dateInput.addEventListener('change', function () {
            dateInput2.min = this.value;
            if (dateInput2.value < this.value) {
                dateInput2.value = this.value;
            }
        });

        dateInput2.addEventListener('change', function () {
            if (this.value < dateInput.value) {
                this.value = dateInput.value;
            }
        });
    </script>

    <!-- =============================== -->
<!-- custom gender input start -->

<script>
function setupSearchSelect(inputSelector, dropdownSelector) {
  const inputField = document.querySelector(inputSelector);
  const dropdown = document.querySelector(dropdownSelector);
  const dropdownArray = [...dropdown.querySelectorAll('.li-select')];
  let valueArray = [];

  dropdown.classList.add('open');
  inputField.focus();

  dropdownArray.forEach(item => {
    valueArray.push(item.textContent);
  });

  const closeDropdown = () => {
    dropdown.classList.remove('open');
  }

  inputField.addEventListener('input', () => {
    dropdown.classList.add('open');
    let inputValue = inputField.value.toLowerCase();
    let valueSubstring;
    if (inputValue.length > 0) {
      for (let j = 0; j < valueArray.length; j++) {
        if (!(inputValue.substring(0, inputValue.length) === valueArray[j].substring(0, inputValue.length).toLowerCase())) {
          dropdownArray[j].classList.add('closed'); 
        } else {
          dropdownArray[j].classList.remove('closed');
        }
      }
    } else {
      dropdownArray.forEach(item => {
        item.classList.remove('closed');
      });
    }
  });

  dropdownArray.forEach(item => {
    item.addEventListener('click', (evt) => {
      selectedUserID = evt.target.dataset.userId;
      inputField.value = item.textContent;
      dropdownArray.forEach(dropdown => {
        dropdown.classList.add('closed');
      });
    });
  });

  inputField.addEventListener('focus', () => {
    dropdown.classList.add('open');
    dropdownArray.forEach(dropdown => {
      dropdown.classList.remove('closed');
    });
  });

  inputField.addEventListener('blur', () => {
    dropdown.classList.remove('open');
  });

  document.addEventListener('click', (evt) => {
    const isDropdown = dropdown.contains(evt.target);
    const isInput = inputField.contains(evt.target);
    if (!isDropdown && !isInput) {
      dropdown.classList.remove('open');
    }
  });
}

setupSearchSelect('#kategori', '#kategoriDrop');
</script>