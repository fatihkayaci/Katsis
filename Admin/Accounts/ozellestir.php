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
(SELECT   ROUND(SUM(borc_miktar),2) FROM tbl_maliye 
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
                                  
                                </select>
                                <label id="kategoriLabel" for="kategori">Kategoriler *</label> -->

                    <div class="select-div">

                        <div class="dropdown-nereden">
                            <div class="group">
                                <input class="search-selectx input" data-user-id="" type="text" list="Users"
                                    id="kategori" name="options" required="" />
                                <label id="kategoriLabel" class="selectx-label" for="kategori">Kategoriler : *</label>
                            </div>

                            <div class="dropdown-content-nereden searchInput-btn" id="kategoriDP">
                                <div class="dropdown-content-inside-nereden">
                                    <input type="text" id="searchInput" placeholder="Ara...">

                                    <?php 
                                            foreach($kategori_listesi as $kategori_id => $kategori_adi){
                                                echo '                                        
                                                   <button  data-user-id="' . $kategori_id . '">' . $kategori_adi . '</button>';
                                            }
                                        ?>
                                </div>

                            </div>

                        </div>




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
    <!-- profile area -->

    <div class="review-area">

        <div class="profile-area">

            <div class="name-area">
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
                </div>
                <div class="user-info-top">
                    <div class="top-guncelle">
                        <h5 class="user-name">
                            <?= !empty($row["userName"]) ? $row["userName"] : "-" ?>
                        </h5>
                        <div class="duzenleBtns">
                            <button class="duzenleProfil" id="iptapBtn" onclick="iptal()" title="İptal"><i class="fa-solid fa-xmark"></i></button>
                            <button class="duzenleProfil" id="duzenleBtn" onclick="okuma()" title="Profili Düzenle"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="duzenleProfil" id="kaydetBtn" onclick="saveProfil()" title="Kaydet"><i class="fa-solid fa-check"></i></button>
                        </div>
                    </div>
                    <div class="bilgi-p">
                        <p>Durumu :</p>
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

                    <div class="bilgi-p">
                        <p>Daire :</p>
                        <?php
                                    if (!empty($row["blok_adi"]) && !empty($row["daire_sayisi"])) { ?>

                        <p class="daire-link hover-link"
                            onclick=userGo(<?= !empty($row["daire_id"]) ? $row["daire_id"] : "null" ?>)>
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
                </div>

            </div>

            <div class="shown-info">

                <hr class="horizontal dark m-0 w-100">

                <div class="bilgi-p p-new">
                    <p>E-Posta</p>
                    <p id="userEmail">
                        <?= !empty($row["userEmail"]) ? $row["userEmail"] : "-" ?>
                    </p>
                </div>

                <hr class="horizontal dark m-0 w-100">

                <div class="bilgi-p p-new">
                    <p>Telefon Numarası</p>
                    <input class="profile-edit" id="phoneNumber" type="text" value="<?= !empty($row["phoneNumber"]) ? $row["phoneNumber"] : "-" ?>">
                </div>

                <hr class="horizontal dark m-0 w-100">

                <div class="bilgi-p p-new">
                    <p>Cinsiyet</p>
                    <input class="profile-edit" id="gender" type="text" value="<?= !empty($row["gender"]) ? $row["gender"] : "-" ?>">
                </div>
                
                <hr class="horizontal dark m-0 w-100">

                <div class="bilgi-p p-new">
                    <p>T.C. Kimlik No</p>
                    <input class="profile-edit" id="tc" type="text" value="<?= !empty($row["tc"]) ? $row["tc"] : "-" ?>">
                </div>

            </div>

            <div class="hide-info">

                <hr class="horizontal dark m-0 w-100">

                <div class="bilgi-p p-new">
                    <p>Kullanıcı No :</p>
                    <input class="profile-edit" id="userNo" type="text" value="<?= !empty($row["user_no"]) ? $row["user_no"] : "-" ?>">
                </div>

                <hr class="horizontal dark m-0 w-100">

                <div class="bilgi-p p-new">
                    <p>Parola :</p>
                    <input class="profile-edit" id="parola" type="text" value="<?php echo base64_decode($row["userPass"]); ?>">
                </div>

                <hr class="horizontal dark m-0 w-100">

                <div class="bilgi-p p-new">
                    <p>Araç Plakası :</p>
                    <input class="profile-edit" id="parola" type="text" value="<?= !empty($row["plate"]) ? $row["plate"] : "-" ?>">
                </div>

                <hr class="horizontal dark m-0 w-100">

                <div class="bilgi-p p-new">
                    <p>Giriş Tarihi :</p>
                    <p>
                        <?php
                                    if ($row["durum"] == "Kiracı") {
                                        echo $row["kiraciGiris"];
                                    } else if ($row["durum"] == "Kat Maliki") {
                                        echo $row["katMGiris"];
                                    }
                                    ?>
                    </p>
                </div>

                <hr class="horizontal dark m-0 w-100">

                <div class="bilgi-p p-new">
                    <p>Son Oturum Açma Tarihi :</p>
                    <p>Son Oturum Açma Tarihi yazılacak</p>
                </div>

            </div>

        </div>

        <div class="borc-info">

            <div class="borc-area overflow-borc">
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
                    <input type="hidden" id="topborc" value=<?php echo  duzenleSayi($toplamBorc); ?> />
                    <div class="borc-box">
                        <div class="bakiye-header">
                            <p class="tarih">BAKİYE : </p>
                            <p class="borc">
                                <?php echo  duzenleSayi($toplamBorc); ?> <img class="tl-img"
                                    src="../Admin\assets\img\tl.png" alt="">
                            </p>
                        </div>
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

                        <a href="" class="bakiye-area">
                            <p class="tarih">
                                <?php echo $yeni_format; ?>
                            </p>
                            <p class="aciklama">
                                <?php echo $row4['aciklama']; ?>
                                <p class="aciklama">
                                    <?php echo $row4['kategori_adi']; ?>
                                </p>
                                <p class="borc">
                                    <?php echo  duzenleSayi($row4['borc_miktar']); ?> <img class="tl-img"
                                        src="../Admin\assets\img\tl.png" alt="">
                                </p>
                        </a>

                        <?php }
                    } ?>
                    </div>
                </div>
            </div>

            <div class="borc-area overflow-borc">
                <div class="account-settings">

                    <div class="row todo-div mt-2">
                        <div id="myDIV" class="to-do">

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mt-2 mb-2">Notlar</h6>
                            </div>

                            <hr class="horizontal dark mt-3">

                            <div class="nowrap">

                                <input class="todo-input" type="text" id="myInput" placeholder="Notunuzu Yazınız..">


                                <span onclick="newElement()" class="todo-btn btn-custom-outline bcoc1">Ekle</span>

                            </div>

                        </div>

                        <div class="row">
                            <ul class="todo-ul" id="myUL">
                                <li class="todo-li">not 1</li>
                                <li class="todo-li checked">not 2</li>
                                <li class="todo-li">not 3</li>
                                <li class="todo-li">not 4</li>
                                <li class="todo-li">not 5</li>
                            </ul>
                        </div>
                    </div>

                </div>
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



    <script type="text/javascript">
    $(document).ready(function() {
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
        var kategoriAd = document.getElementById('kategori').value;

        if (kategoriAd == "" || kategoriAd == null) {
            var kategoriValue = "";
        } else {
            var kategoriValue = document.getElementById('kategori').dataset.userId;
        }

        alert(kategoriValue);

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
                success: function(response) {
                    if (response) {
                        document.getElementById('aciklama').value = "";
                        document.getElementById('borcTutar').value = "";
                        document.getElementById('kategori').value = "";
                        popupCloseControl('popupBorcEkle', 'borcEkleForm');
                        location.reload();
                    }


                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Hata alındı: ' + errorMessage);
                }
            });




        }





    }
    // Form alanlarına odaklandığında kendi renklerine dönmesi için yazılan kodlar.
    $('#aciklama').focus(function() {
        $('#aciklama').css('border-color', '#277ce0');
        $('#aciklamaLabel').css('color', '#277ce0');
    });

    // Borç Tutarı alanına odaklandığınızda
    $('#borcTutar').focus(function() {
        $('#borcTutar').css('border-color', '#277ce0');
        $('#borcLabel').css('color', '#277ce0');
    });

    // Tarih alanına odaklandığınızda
    $('#dateInput').focus(function() {
        $('#dateInput').css('border-color', '#277ce0');
        $('#label_tarih').css('color', '#277ce0');
    });

    // Diğer Tarih alanına odaklandığınızda
    $('#dateInput2').focus(function() {
        $('#dateInput2').css('border-color', '#277ce0');
        $('#label_tarih2').css('color', '#277ce0');
    });

    // Kategori alanına odaklandığınızda
    $('#kategori').focus(function() {
        $('#kategori').css('border-color', '#277ce0');
        $('#kategoriLabel').css('color', '#277ce0');
    });



    // Aciklama alanından odak kaybedildiğinde
    $('#aciklama').blur(function() {

        $('#aciklama').css('border-color', '#0d0c22');
        $('#aciklamaLabel').css('color', '#0d0c22');

    });

    // Borç Tutarı alanından odak kaybedildiğinde
    $('#borcTutar').blur(function() {
        $('#borcTutar').css('border-color', '#0d0c22');
        $('#borcLabel').css('color', '#0d0c22');
    });

    // Tarih alanından odak kaybedildiğinde
    $('#dateInput').blur(function() {
        $('#dateInput').css('border-color', '#0d0c22');
        $('#label_tarih').css('color', '#0d0c22');
    });

    // Diğer Tarih alanından odak kaybedildiğinde
    $('#dateInput2').blur(function() {
        $('#dateInput2').css('border-color', '#0d0c22');
        $('#label_tarih2').css('color', '#0d0c22');
    });

    // Kategori alanından odak kaybedildiğinde
    $('#kategori').blur(function() {
        $('#kategori').css('border-color', '#0d0c22');
        $('#kategoriLabel').css('color', '#0d0c22');
    });







    //////////////////////  TAHSİLAT İŞLEMLERİ /////////////////////
    function tahsilatAdd() {

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
            b1 = false;
        }

        if (tahsilatTutarValue.trim() === '' || tahsilatTutarValue <= 0) {
            $('#tahsilatTutar').css('border-color', 'red');
            $('#tahsilatLabel').css('color', 'red');
            b2 = false;
        }

        if (dateInputValue11.trim() === '') {
            $('#dateInput3').css('border-color', 'red');
            $('#label_tarih3').css('color', 'red');
            b3 = false;
        }
        if (!b1 || !b3 || !b2) {
            alert("İlgili Alanlar Boş Olamaz");

        } else {

            $.ajax({
                url: 'Controller/maliye_tahsilatt.php',
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
                success: function(response) {
                    alert(response);
                    if (response) {
                        document.getElementById('aciklama').value = "";
                        document.getElementById('borcTutar').value = "";
                        document.getElementById('kategori').value = "";
                        popupCloseControl('popupBorcEkle', 'borcEkleForm');
                        location.reload();
                    }


                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Hata alındı: ' + errorMessage);
                }
            });




        }


    }
    $('#aciklama_tahsilat').focus(function() {
        $('#aciklama_tahsilat').css('border-color', '#277ce0');
        $('#aciklamaLabel_tahsilat').css('color', '#277ce0');
    });

    // Borç Tutarı alanına odaklandığınızda
    $('#tahsilatTutar').focus(function() {
        $('#tahsilatTutar').css('border-color', '#277ce0');
        $('#tahsilatLabel').css('color', '#277ce0');
    });

    // Tarih alanına odaklandığınızda
    $('#dateInput3').focus(function() {
        $('#dateInput3').css('border-color', '#277ce0');
        $('#label_tarih3').css('color', '#277ce0');
    });
    //////////////////////////////////////////////

    $('#aciklama_tahsilat').blur(function() {

        $('#aciklama_tahsilat').css('border-color', '#0d0c22');
        $('#aciklamaLabel_tahsilat').css('color', '#0d0c22');

    });

    // Borç Tutarı alanından odak kaybedildiğinde
    $('#tahsilatTutar').blur(function() {
        $('#tahsilatTutar').css('border-color', '#0d0c22');
        $('#tahsilatLabel').css('color', '#0d0c22');
    });

    // Tarih alanından odak kaybedildiğinde
    $('#dateInput3').blur(function() {
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
            success: function(response) {


                if (response) {
                    window.location.href = "index.php?parametre=detail";
                    localStorage.setItem('selectedLink', 'Accounts');
                }



            },
            error: function(xhr, status, error) {
                var errorMessage = xhr.status + ': ' + xhr.statusText;
                alert('Hata alındı: ' + errorMessage);
            }
        });
    }



    //POPUPLARIN AÇMA KAPATMA KODLARI

    function popupOpenControl(popupName, popupForm) {

        $('body').css('overflow', 'hidden');

        $('#' + popupName).show().css('display', 'flex').delay(100).queue(function(next) {
            $('#' + popupName).css('opacity', '1');
            $('#' + popupForm).css('opacity', '1');
            $('#' + popupForm).css('transform', 'translateY(0)');
            next();
        });
    }


    function popupCloseControl(popupName, popupForm) {

        $('#' + popupForm).css('opacity', '0').css('transform', 'translateY(-180px)').delay(100).queue(function(next) {
            $('#' + popupName).css('opacity', '0').delay(300).queue(function(nextInner) {
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
    document.getElementById('tahsilatTutar').value = topborc;
    // Tarihlerin kontrolü
    var dateInput = document.getElementById('dateInput');
    var dateInput2 = document.getElementById('dateInput2');


    dateInput.addEventListener('change', function() {
        dateInput2.min = this.value;
        if (dateInput2.value < this.value) {
            dateInput2.value = this.value;
        }
    });

    dateInput2.addEventListener('change', function() {
        if (this.value < dateInput.value) {
            this.value = dateInput.value;
        }
    });
    </script>

    <!-- =============================== -->
    <!-- custom gender input start -->
    <script src="assets/js/mycode/dropdown.js"></script>
    <script>
    dropDownn('kategori', 'kategoriDP', 'searchInput');
    </script>

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