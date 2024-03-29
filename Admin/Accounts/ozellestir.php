<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <input type="hidden" id="apartmanId" value=<?php echo $_SESSION["apartID"]?> />
    <input type="hidden" id="userId" value=<?php echo $_SESSION['userPage']?> />
    <input type="hidden" id="daireId" value=<?php echo $_SESSION['dId']?> />

    <?php

try {
    $sql = "SELECT u.userID, u.userName, u.user_no, u.userEmail, u.gender, u.userPass, u.plate, u.tc, u.phoneNumber, 
    d.daire_id, b.blok_adi AS blok_adi, u.oldBlock, u.oldNumber, u.oldState, u.arsive, d.kiraciGiris, d.katMGiris, d.daire_sayisi,
    CASE
        WHEN d.katMalikiID = u.userID THEN 'Kat Maliki'
        WHEN d.kiraciID = u.userID THEN 'Kiracı'
        ELSE 'Belirtilmemiş'
    END AS durum
    FROM tbl_users u
    LEFT JOIN tbl_daireler d ON u.userID = d.katMalikiID OR u.userID = d.kiraciID
    LEFT JOIN tbl_blok b ON d.blok_adi = b.blok_id
    WHERE rol=3 AND u.apartman_id = " . $_SESSION["apartID"]." AND u.userID = " . $_SESSION['userPage'];
if (!$_SESSION['dId'] == "") {
    $sql .= " AND d.daire_id = " . $_SESSION['dId']; 
} 
$sql .= " ORDER BY u.userID ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    // Sonuç kümesinin satır sayısını kontrol etme
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
   $kategori_listesi = array();
$sql2 = "SELECT * FROM tbl_kategori where apartman_id=".$_SESSION["apartID"];
$stmt2 = $conn->prepare($sql2);
    $stmt2->execute();
    $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
foreach ($result2 as $row2) {
    $kategori_listesi[$row2['kategori_id']] = $row2['kategori_adi'];
}


$sql4 = "SELECT aciklama, odeme_tar, borc_miktar, 
                (SELECT SUM(borc_miktar) FROM tbl_maliye 
                 WHERE user_id = ".$_SESSION['userPage']." AND apartman_id = ".$_SESSION["apartID"];
           if (!$_SESSION['dId'] == "") {
            $sql4 .= " AND daire_id = " . $_SESSION['dId']; 
        }       
                 
                 
         $sql4 .=") AS toplam_borc 
         FROM tbl_maliye 
         WHERE user_id = ".$_SESSION['userPage']." AND apartman_id = ".$_SESSION["apartID"];



if (!$_SESSION['dId'] == "") {
    $sql4 .= " AND daire_id = " . $_SESSION['dId']; 
} 



$stmt4 = $conn->prepare($sql4);
    $stmt4->execute();
    $result4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);







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
                    <select class="input" id="kategori" required="">
                        <option style="display: none;" value="" disabled selected></option>
                        <?php
                foreach ($kategori_listesi as $kategori_id => $kategori_adi) {
                    echo "<option value='" . $kategori_id . "'>" . $kategori_adi . "</option>";
                }
                ?>
                    </select>
                    <label id="kategoriLabel" for="kategori">Kategoriler *</label>
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

            <h2 class="form-signin-heading">Borç Ekle</h2>


            <div class="row">

                <div class="col-md-6 col-btn">
                    <input class="input" type="text" id="aciklama" required="" />
                    <label id="aciklamaLabel" for="aciklama">Açıklama *: </label>
                </div>

                <div class="col-md-6 col-btn">
                    <input class="input" type="text" id="tahsilatTutar" />
                    <label id="tahsilatLabel" for="tahsilatTutar">Tahsilat Tutarı *:</label>
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
                    <select class="input" id="kategori" required="">
                        <option style="display: none;" value="" disabled selected></option>
                        <?php
                foreach ($kategori_listesi as $kategori_id => $kategori_adi) {
                    echo "<option value='" . $kategori_id . "'>" . $kategori_adi . "</option>";
                }
                ?>
                    </select>
                    <label id="kategoriLabel" for="kategori">Kategoriler *</label>
                </div>

            </div>

            <hr class="horizontal dark w-100">

            <div class="row row-btn">
                <button type="button" class="btn-custom-close"
                    onclick="popupCloseControl('popupTahsilatEkle','tahsilatEkleForm')">Kapat</button>
                <button type="button" class="btn-custom" id="saveButton">Kaydet</button>
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
                                <p><?php echo $initials; ?></p>
                            </div>
                            <h5 class="user-name"><?= !empty($row["userName"]) ? $row["userName"] : "-" ?></h5>
                        </div>
                        <hr class="horizontal dark mt-0">
                        <div class="ps-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <label for="tc">T.C. Kimlik No</label>
                            <p id="tc"><?= !empty($row["tc"]) ? $row["tc"] : "-" ?></p>
                        </div>
                        <hr class="horizontal dark mt-0">
                        <div class="ps-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <label for="phoneNumber">Telefon Numarası</label>
                            <p id="phoneNumber"><?= !empty($row["phoneNumber"]) ? $row["phoneNumber"] : "-" ?></p>
                        </div>
                        <hr class="horizontal dark mt-0">
                        <div class="ps-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <label for="userEmail">E-Posta</label>
                            <p id="userEmail"><?= !empty($row["userEmail"]) ? $row["userEmail"] : "-" ?></p>
                        </div>
                        <hr class="horizontal dark mt-0">
                        <div class="ps-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <label for="gender">Cinsiyet</label>
                            <p id="gender"><?= !empty($row["gender"]) ? $row["gender"] : "-" ?></p>
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
                                if($row["arsive"] == 1) {
                                    if ($row["oldState"] == "kiraci") {
                                        echo "kiraci";
                                    } elseif ($row["oldState"] == "katMaliki") {
                                        echo "kat Maliki";
                                    } else {
                                        echo "belirtilmemis";
                                    }
                                }else if($row["arsive"] == 0) {
                                    if ($row["durum"] == "Kiracı") {
                                        echo "kiraci";
                                    } elseif ($row["durum"] == "Kat Maliki") {
                                        echo "kat-maliki";
                                    } else {
                                        echo "belirtilmemis";
                                    }
                                }
                                ?>">
                                    <?php   
                                    if($row["arsive"] == 1) {
                                        echo "Eski ".$row["oldState"];
                                    }else if($row["arsive"] == 0) {
                                        echo $row["durum"];
                                    }
                                     ?>
                                </div>
                            </div>

                            <hr class="horizontal dark mt-0">

                            <div class="bilgi-p col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <p class="bilgi-p">Daire :</p>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">

                                <?php 
                                        if (!empty($row["blok_adi"]) && !empty($row["daire_sayisi"])) {  ?>

                                <p class="daire-link"
                                    onclick=userGo(<?= !empty($row["daire_id"]) ? $row["daire_id"] : "null" ?>)> 
                                    <?php 
                                        if (!empty($row["blok_adi"]) && !empty($row["daire_sayisi"])) {
                                            echo $row["blok_adi"] . " / " . $row["daire_sayisi"];
                                            ?>
                                            <i class="fa-solid fa-link"></i>
                                </p>
                                <?php

                                        } else{
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
                                <p class="bilgi-p"><?= !empty($row["user_no"]) ? $row["user_no"] : "-" ?></p>
                            </div>

                            <hr class="horizontal dark mt-0">

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <p class="bilgi-p">Giriş Tarihi :</p>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <p class="bilgi-p"><?php 
                                if($row["durum"]=="Kiracı"){
                                    echo $row["kiraciGiris"];
                                } else if($row["durum"]== "Kat Maliki"){
                                    echo $row["katMGiris"];
                                }
                                ?></p>
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
                                <p class="bilgi-p"><?php echo base64_decode( $row["userPass"]); ?></p>
                            </div>

                            <hr class="horizontal dark mt-0">

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <p class="bilgi-p">Araç Plakası :</p>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <p class="bilgi-p"><?= !empty($row["plate"]) ? $row["plate"] : "-" ?></p>
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
                                <button class="btn-custom-outline bcoc1"
                                    onclick=" popupOpenControl('popupTahsilatEkle','tahsilatEkleForm')">Tahsilat</button>
                            </div>
                            <div class="input-group1">
                                <button class="btn-custom-outline bcoc3">Düzenle</button>
                            </div>
                        </div>

                        <div class="borc-box">
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
                                <p class="borc"><?php echo  $yeni_format;   ?></p>
                                <p class="para"><?php echo $row4['aciklama'];   ?></p>
                                <p class="para"><?php echo $row4['borc_miktar'];   ?></p>
                            </a>

                            <?php } ?>
                            <a href="">
                                <p class="borc">BAKİYE : </p>
                                <p class="borc"><?php echo  $row4['toplam_borc'];    ?></p>
                                
                            </a>
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





    //////////////////////////////////////////////



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