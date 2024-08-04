<?php 
require_once "Controller/class.func.php";
try {
    // $apartman_id değişkeninin tanımlandığını varsayıyoruz
    $idapartman =$_SESSION["apartID"];

    $sql = "
    SELECT 
    u1.userID AS katMalikiID, 
        
        u1.userName AS katMalikiName,
        u2.userID AS kiraciID,  
        u2.userName AS kiraciName, 
        b.blok_adi AS blokAdi,
        d.daire_sayisi AS dNO,
        d.daire_id,
        d.katMalikiID,
        d.KiraciID
    FROM tbl_daireler d
    LEFT JOIN tbl_users u1 ON d.katMalikiID = u1.userID
    LEFT JOIN tbl_users u2 ON d.KiraciID = u2.userID
    LEFT JOIN tbl_blok b ON d.blok_adi = b.blok_id  WHERE d.apartman_id=".$idapartman ;

    // Sorguyu hazırlama ve çalıştırma
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $daireler = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // tbl_kategori tablosundan verileri çekme
    $sql_kategori = "
        SELECT *
        FROM tbl_kategori
        WHERE apartman_id = :apartman_id
    ";

    $stmt_kategori = $conn->prepare($sql_kategori);
    $stmt_kategori->execute(['apartman_id' => $idapartman]);
    $results_kategori = $stmt_kategori->fetchAll();

    // Sonuçları birleştirerek işlemek için
    $results = [
        'kategori' => $results_kategori
        
    ];

   

 
} catch (PDOException $e) {
    // Hata oluştuğunda yakalanacak blok
    echo "Veritabanı hatası: " . $e->getMessage();
} catch (Exception $e) {
    // Genel bir hata oluştuğunda yakalanacak blok
    echo "Bir hata oluştu: " . $e->getMessage();
}
?>





<body>

<!-- Popup Form -->

<div id="popup">

    <form class="login-form new-chck" id="userForm">

        <h2 class="form-signin-heading mb-3">İstisna Ekleme</h2>

        <hr class="horizontal dark mt-0 w-100">

            <table class="users-table table-blok">
                <tr class="users-table-info">
                    <th class="check-style">
                        <input id="mainCheckbox" type="checkbox" onclick="toggleAll(this)" />
                        <label for="mainCheckbox" class="check">
                            <svg width="18px" height="18px" viewBox="0 0 18 18">
                                <path
                                    d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z">
                                </path>
                                <polyline points="1 9 7 14 15 4"></polyline>
                            </svg>
                        </label>
                    </th>
                    <th>Daire</th>
                    <th>Kat Maliki</th>
                    <th>Kiracı</th>
                </tr>
                <?php foreach ($daireler as $daire) { ?>
                <tr id="mainTr">
                    <td data-title="Seç" class="check-style">
                        <input id="check-<?php echo  $daire['daire_id'] ?>" data-userid="<?php echo  $daire['daire_id'] ?>"
                            class="check1" type="checkbox" onclick="toggleMainCheckbox('<?php echo  $daire['daire_id'] ?>')" />
                        <label for="check-<?php echo  $daire['daire_id'] ?>" class="check">
                            <svg width="18px" height="18px" viewBox="0 0 18 18">
                                <path
                                    d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z">
                                </path>
                                <polyline points="1 9 7 14 15 4"></polyline>
                            </svg>
                        </label>
                    </td>

                    
                    <td><?php echo $daire['blokAdi'] . ' Blok - No: ' . $daire['dNO']?></td>
                    <td><?php if (!empty($daire['katMalikiName'])) {
                            echo   $daire['katMalikiName'] ;
                    }else{echo "-";}  ?></td> 
                    <td><?php if (!empty($daire['kiraciName'])) {
                            echo   $daire['kiraciName'] ;
                    }else{echo "-";}  ?></td>
                </tr>
             

                <?php }?>
            </table>

        <hr class="horizontal dark mt-0 w-100">

        <div class="row row-btn">
            <button type="button" class="btn-custom-close" onclick="closePopup()">Kapat</button>
            <button type="button" class="btn-custom" onclick="saveUser()" id="saveButton">Kaydet</button>
        </div>


    </form>
</div>

<!-- Popup end -->

<!-- ================================================= -->

<div class="cener-table">

<div class="review-area mt-0">

    <div class="borc-info align-items-center">
        <div class="toplu-borc-area">	
            <div class="contact-form">     
                <div class="col-md-12">
                	<div class="tabbable-panel">
                		<div class="toplu-line">
                            
                			<ul class="nav nav-tabs ">
                				<li class="active">
                					<a href="#tab_default_1" data-toggle="tab">Toplu Borç</a>
                				</li>
                				<li>
                					<a href="#tab_default_2" data-toggle="tab">Sayaç Endeksi</a>
                				</li>
                				<li>
                					<a href="#tab_default_3" data-toggle="tab">Excel'den Yükleme</a>
                				</li>
                			</ul>

                            <hr class="horizontal dark mb-1 w-100">

                			<div class="tab-content">

<!-- ============================================================== -->

<!-- Tab 1 Start -->

                				<div class="tab-pane active" id="tab_default_1">

                                    <div class="bilgi-info toplu-flex mt-2">

        	                            <div class="toplu-p b-old">
        	                            	<h4 class="mt-2 mb-2">Toplu Borç</h4>
        	                            </div>

                                        <div class="toplu-borc-inside">

                                            <div class="toplu-p b-old">
                                                <div class="esit-veri">
                                                    <p>Kategori :</p>
                                                    <p class="toplu-info">işleminize uygun kategoriyi seçiniz.</p>
                                                </div>
                                                <div class="esit-input">
                                                    <div class="dropToplu-div w-100">
                                                        <div class="dropdown-nereden">
                                                            <div class="group">
                                                                <input class="toplu-input i-kontrol" data-user-id="" type="text" list="Users" id="kategori" name="options" required="" />
                                                                <i class="fa-solid fa-chevron-down absolute-input"></i>
                                                            </div>
                                                            <div class="dropdown-content-nereden searchInput-btn" id="kategoriDP">
                                                                <div class="dropdown-content-inside-nereden">
                                                                    <input type="hidden" id="searchInput-kategori" placeholder="Ara...">
                                                                     <?php    foreach ($results['kategori'] as $kategori) {   ?>       
                                                                    <button data-user-id="<?php echo $kategori["kategori_id"] ?>">   <?php echo $kategori["kategori_adi"] ?></button>
                                                                    
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div> 
                                                </div>
        	                                </div>

                                            <hr class="horizontal dark w-100">

                                            <div class="toplu-p b-old">
                                                <div class="esit-veri">
        	                                    	<p>Açıklama :</p>
                                                    <p class="toplu-info">Tüm borçlara yazılacak borç açıklamasıdır.</p>
                                                </div>
                                                <div class="esit-input">
                                                <input class="toplu-input" type="text" id="aciklama" onclick="selectInput(this)" value="<?php echo suanki_ayi_getir(); ?> Dönemi Aidatı">

                                                </div>
        	                                </div>

                                            <hr class="horizontal dark w-100">

                                            <div class="toplu-p b-old">
                                                <div class="esit-veri">
                                                    <p>Hesaplar :</p> 
                                                    <p class="toplu-info">Borçlandırmak istediğiniz kişiyi seçiniz</p>
                                                </div>
                                                <div class="esit-input col mb-0 align-items-end">
                                                    <div class="dropToplu-div w-100">
                                                        <div class="dropdown-nereden">
                                                            <div class="group">
                                                                <input class="toplu-input i-kontrol" data-user-id="" type="text" list="Users" id="hesaplar" name="options" required="" readonly />
                                                                <i class="fa-solid fa-chevron-down absolute-input"></i>
                                                            </div>
                                                            <div class="dropdown-content-nereden searchInput-btn" id="hesaplarDP">
                                                                <div class="dropdown-content-inside-nereden">
                                                                    <input type="hidden"  id="searchInput">

                                                                    <button data-user-id="1" id="btn-select" autofocus>Kiracılar, Yoksa kat malikleri</button>
                                                                    <button data-user-id="2">Kat Malikleri</button>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div> 
                                                    <button class="adduser btn-custom-outline finansClr m-0">İstisna Ekle</button>
                                                </div>
        	                                </div>

                                            <hr class="horizontal dark w-100">

                                            <div class="toplu-p b-old">
                                                <div class="esit-veri">
                                                    <p>Tutar :</p>
                                                    <p class="toplu-info">Gelişmiş hesaplama seçenekleri ile daire tipi, arsa payı veya sayaçlara göre borçlandırma yapabilirsiniz</p>
                                                </div>
                                                <div class="esit-input">
                                                    <input class="toplu-input" id="fiyat" type="text" onkeypress="return onlyNumberKey(event)" placeholder="0,00">
                                                </div>
        	                                </div>

                                            <div class="toplu-p b-old">
                                                <div class="esit-input">
                                                    <div class="gelismis-checkbox">
                                                        <div class="yeni-check">
                                                            <input class="yenichk-inpt" id="gelismis" type="checkbox"/>
                                                            <label class="yenichk-label" for="gelismis"><span>
                                                                <svg width="12px" height="10px">
                                                                    <use xlink:href="#check-4"></use>
                                                                </svg></span><span>Hesaplama Şekilleri</span>
                                                            </label>
                                                            <svg class="inline-svg">
                                                                <symbol id="check-4" viewbox="0 0 12 10">
                                                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                                </symbol>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tutar-ayar mt-3 b-old" id="tutar-ayar">
                                                <div class="esit-veri">
                                                    <p>Hesaplama Şekli :</p>
                                                    <p class="toplu-info">Tutarı daire parametrelerine veya sayaç endekslerine göre dağıtabilir yada birim fiyat olarak kullanarak sağlanan parametrelerle çarpabilirsiniz</p>
                                                </div>
                                                <div class="esit-input response-ttr">
                                                    <div class="dropToplu-div w-100">
                                                        <div class="dropdown-nereden">
                                                            <div class="group">
                                                                <input class="toplu-input i-kontrol" data-user-id="" type="text" list="Users" id="tutar" name="options" required="" readonly />
                                                                <i class="fa-solid fa-chevron-down absolute-input"></i>
                                                            </div>
                                                            <div class="dropdown-content-nereden searchInput-btn" id="tutarDP">
                                                                <div class="dropdown-content-inside-nereden">
                                                                    <input type="hidden" id="searchInput-tutar" placeholder="Ara...">

                                                                    <button id="tutar_bol" data-user-id="1">Tutarı Böl</button>
                                                                    <button id="tutar_carp" data-user-id="2">Tutarı Çarp</button>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div> 
                                                    <div class="dropToplu-div w-100">
                                                        <div class="dropdown-nereden">
                                                            <div class="group">
                                                                <input class="toplu-input i-kontrol" data-user-id="" type="text" list="Users" id="pay" name="options" required="" readonly />
                                                                <i class="fa-solid fa-chevron-down absolute-input"></i>
                                                            </div>
                                                            <div class="dropdown-content-nereden searchInput-btn" id="payDP">
                                                                <div class="dropdown-content-inside-nereden">
                                                                    <input type="hidden" id="searchInput-pay" placeholder="Ara...">

                                                                    <button id="esitPaylastır" data-user-id="1">Eşit Paylaştır</button>
                                                                    <button id="daireTipi" data-user-id="2">Daire Tipi</button>
                                                                    <button id="arsaPayı" data-user-id="3">Arsa Payı</button>
                                                                    <button id="brutm2" data-user-id="4">Brüt m2</button>
                                                                    <button id="netm2" data-user-id="5">Net m2</button>
                                                                  
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div> 
                                                </div>
                                            </div>
                                            
                                            <hr class="horizontal dark w-100">

                                            <div class="toplu-p b-old">
                                                <div class="esit-input">
                                                    <button class="btn-custom-outline m-0 finansClr" id="tekrar-button"><i class="fa-solid fa-rotate"></i> Tekrarla</button>
                                                </div>
                                            </div>

                                            <div class="toplu-p mt-3 b-old tekrar-once">
                                                <div class="esit-veri">
                                                    <p>Düzenleme Tarihi :</p>
                                                </div>
                                                <div class="esit-input">
                                                    <input class="toplu-input" data-user-id="" id="datepicker" type="text">
                                                </div>
                                            </div>
                                            
                                            <div class="toplu-p mt-3 b-old tekrar-once">
                                                <div class="esit-veri">
                                                    <p>Son Ödeme Tarihi :</p>
                                                </div>
                                                <div class="esit-input">
                                                    <input class="toplu-input" id="datepicker2" type="text">
                                                </div>
                                            </div>
                                            
                                            <div class="toplu-p mt-3 b-old tekrar-tarih">
                                                <div class="esit-veri">
                                                    <p>İlk Tekrar Tarihi :</p>
                                                </div>
                                                <div class="esit-input">
                                                    <input class="toplu-input" data-user-id="" id="datepickerSecim" type="text">
                                                </div>
                                            </div>
                                            
                                         
                                            
                                            <div class="toplu-p mt-3 b-old tekrar-tarih">
                                                <div class="esit-veri">
                                                    <p>Son Ödeme Tarihi :</p>
                                                </div>
                                                <div class="esit-input">
                                                    <div class="dropToplu-div w-100">
                                                        <div class="dropdown-nereden">
                                                            <div class="group">
                                                                <input class="toplu-input i-kontrol" data-user-id="" type="text" list="Users" id="kacgunSonraid" name="gecikmeTarih" required="" readonly />
                                                                <i class="fa-solid fa-chevron-down absolute-input"></i>
                                                            </div>
                                                            <div class="dropdown-content-nereden searchInput-btn mainpopupx" id="kacgunSonra">
                                                                <div class="dropdown-content-inside-nereden">
                                                                    <input type="hidden" id="searchInput-kacgunSonra" placeholder="Ara...">

                                                                    <button  data-user-id="1">1 Gün Sonra</button>
                                                                    <button  data-user-id="2">2 Gün Sonra</button>
                                                                    <button  data-user-id="3">3 Gün Sonra</button>
                                                                    <button  data-user-id="4">4 Gün Sonra</button>
                                                                    <button  data-user-id="5">5 Gün Sonra</button>
                                                                    <button  data-user-id="6">6 Gün Sonra</button>
                                                                    <button  data-user-id="7">7 Gün Sonra</button>
                                                                    <button  data-user-id="8">8 Gün Sonra</button>
                                                                    <button  data-user-id="9">9 Gün Sonra</button>
                                                                    <button  data-user-id="10">10 Gün Sonra</button>
                                                                    <button  data-user-id="11">11 Gün Sonra</button>
                                                                    <button  data-user-id="12">12 Gün Sonra</button>
                                                                    <button  data-user-id="13">13 Gün Sonra</button>
                                                                    <button  data-user-id="14">14 Gün Sonra</button>
                                                                    <button  data-user-id="15">15 Gün Sonra</button>
                                                                    <button  data-user-id="16">16 Gün Sonra</button>
                                                                    <button  data-user-id="17">17 Gün Sonra</button>
                                                                    <button  data-user-id="18">18 Gün Sonra</button>
                                                                    <button  data-user-id="19">19 Gün Sonra</button>
                                                                    <button  data-user-id="20">20 Gün Sonra</button>
                                                                    <button  data-user-id="21">21 Gün Sonra</button>
                                                                    <button  data-user-id="22">22 Gün Sonra</button>
                                                                    <button  data-user-id="23">23 Gün Sonra</button>
                                                                    <button  data-user-id="24">24 Gün Sonra</button>
                                                                    <button  data-user-id="25">25 Gün Sonra</button>
                                                                    <button  data-user-id="26">26 Gün Sonra</button>
                                                                    <button  data-user-id="27">27 Gün Sonra</button>
                                                                    <button  data-user-id="28">28 Gün Sonra</button>
                                                                    <button  data-user-id="29">29 Gün Sonra</button>
                                                                    <button  data-user-id="30">30 Gün Sonra</button>

                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div> 
                                                </div>
                                            </div>

                                            <hr class="horizontal dark w-100">

                                            <div class="toplu-p b-old">
                                                <div class="esit-veri">
                                                    <p>Gecikme Tazminatı :</p>
                                                    <p class="toplu-info">Borçların gecikmesi durumunda uygulanacak gecikme tazminatını günlük veya aylık olarak tanımlayabilirsiniz.</p>
                                                </div>
                                                <div class="esit-input">
                                                    <div class="gelismis-checkbox">
                                                        <div class="yeni-check">
                                                            <input class="yenichk-inpt" id="gecikmeTazminati" type="checkbox"/>
                                                            <label class="yenichk-label" for="gecikmeTazminati"><span>
                                                                <svg width="12px" height="10px">
                                                                    <use xlink:href="#check-4"></use>
                                                                </svg></span><span>Gecikme Tazminatı Uygula</span>
                                                            </label>
                                                            <svg class="inline-svg">
                                                                <symbol id="check-4" viewbox="0 0 12 10">
                                                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                                </symbol>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-3 b-old gecikmeT">
                                                <div class="esit-veri">
                                                    <p>Son Ödeme Tarihinden :</p>
                                                </div>
                                                <div class="esit-input">
                                                    <div class="dropToplu-div w-100">
                                                        <div class="dropdown-nereden">
                                                            <div class="group">
                                                                <input class="toplu-input i-kontrol" data-user-id="" type="text" list="Users" id="gecikmeTarih" name="gecikmeTarih" required="" readonly />
                                                                <i class="fa-solid fa-chevron-down absolute-input"></i>
                                                            </div>
                                                            <div class="dropdown-content-nereden searchInput-btn mainpopupx" id="gecikmeTarihDP">
                                                                <div class="dropdown-content-inside-nereden">
                                                                    <input type="hidden" id="searchInput-gecikmeTarih" placeholder="Ara...">

                                                                    <button  data-user-id="1">1 Gün Sonra</button>
                                                                    <button  data-user-id="2">2 Gün Sonra</button>
                                                                    <button  data-user-id="3">3 Gün Sonra</button>
                                                                    <button  data-user-id="4">4 Gün Sonra</button>
                                                                    <button  data-user-id="5">5 Gün Sonra</button>
                                                                    <button  data-user-id="6">6 Gün Sonra</button>
                                                                    <button  data-user-id="7">7 Gün Sonra</button>
                                                                    <button  data-user-id="8">8 Gün Sonra</button>
                                                                    <button  data-user-id="9">9 Gün Sonra</button>
                                                                    <button  data-user-id="10">10 Gün Sonra</button>
                                                                    <button  data-user-id="11">11 Gün Sonra</button>
                                                                    <button  data-user-id="12">12 Gün Sonra</button>
                                                                    <button  data-user-id="13">13 Gün Sonra</button>
                                                                    <button  data-user-id="14">14 Gün Sonra</button>
                                                                    <button  data-user-id="15">15 Gün Sonra</button>
                                                                    <button  data-user-id="16">16 Gün Sonra</button>
                                                                    <button  data-user-id="17">17 Gün Sonra</button>
                                                                    <button  data-user-id="18">18 Gün Sonra</button>
                                                                    <button  data-user-id="19">19 Gün Sonra</button>
                                                                    <button  data-user-id="20">20 Gün Sonra</button>
                                                                    <button  data-user-id="21">21 Gün Sonra</button>
                                                                    <button  data-user-id="22">22 Gün Sonra</button>
                                                                    <button  data-user-id="23">23 Gün Sonra</button>
                                                                    <button  data-user-id="24">24 Gün Sonra</button>
                                                                    <button  data-user-id="25">25 Gün Sonra</button>
                                                                    <button  data-user-id="26">26 Gün Sonra</button>
                                                                    <button  data-user-id="27">27 Gün Sonra</button>
                                                                    <button  data-user-id="28">28 Gün Sonra</button>
                                                                    <button  data-user-id="29">29 Gün Sonra</button>
                                                                    <button  data-user-id="30">30 Gün Sonra</button>

                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div> 
                                                </div>
                                            </div>
                                            
                                            <div class="mt-3 b-old gecikmeT">
                                                <div class="esit-veri">
                                                    <p>Gecikme Tazminatı Yüzdesi :</p>
                                                </div>
                                                <div class="esit-input">
                                                <div class="group w-100">
                                                    <input class="toplu-input" type="text">
                                                    <i class="fa-solid fa-percent absolute-input"></i>
                                                </div>
                                                </div>
                                            </div>
                                            
                                            <div class="mt-3 b-old gecikmeT">
                                                <div class="esit-veri">
                                                    <p>Tazminat Uygulama Şekli :</p>
                                                </div>
                                                <div class="esit-input">
                                                    <div class="dropToplu-div w-100">
                                                        <div class="dropdown-nereden">
                                                            <div class="group">
                                                                <input class="toplu-input i-kontrol" data-user-id="" type="text" list="Users" id="tazminatsekli" name="gecikmeTarih" required="" readonly />
                                                                <i class="fa-solid fa-chevron-down absolute-input"></i>
                                                            </div>
                                                            <div class="dropdown-content-nereden searchInput-btn mainpopupx" id="tazminatsekliDP">
                                                                <div class="dropdown-content-inside-nereden">
                                                                    <input type="hidden" id="searchInput-tazminatsekli" placeholder="Ara...">

                                                                    <button>Günlük</button>
                                                                    <button>Aylık</button>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div> 
                                                </div>
                                            </div>

                                            <hr class="horizontal dark w-100">

                                            <div class="toplu-p mt-3 b-old">
                                                <div class="esit-input">
                                                    <button class="btn-custom-close respense-btn">İptal</button>
                                                    <button class="btn-custom respense-btn" onclick="topluBorc()">Kaydet</button>
                                                </div>
                                            </div>

        	                            </div>    
                                    </div>

                				</div>

<!-- Tab 1 End  -->

<!-- ============================================================== -->

<!-- Tab 2  -->


                				<div class="tab-pane" id="tab_default_2">

                                    <div class="bilgi-info toplu-flex mt-2">

                                        <div class="toplu-p b-old">
                                            <h4 class="mt-2 mb-2">Sayaç Endeksi</h4>
                                        </div>

                                        <div class="toplu-borc-inside">

                                            <div class="toplu-p b-old">
                                                <div class="esit-veri">
                                                    <p>Kategori :</p>
                                                    <p class="toplu-info">işleminize uygun kategoriyi seçiniz.</p>
                                                </div>
                                                <div class="esit-input">
                                                    <div class="dropToplu-div w-100">
                                                        <div class="dropdown-nereden">
                                                            <div class="group">
                                                                <input class="toplu-input i-kontrol" data-user-id="" type="text" list="Users" id="kategori1" name="options" required="" />
                                                                <i class="fa-solid fa-chevron-down absolute-input"></i>
                                                            </div>
                                                            <div class="dropdown-content-nereden searchInput-btn" id="kategori1DP">
                                                                <div class="dropdown-content-inside-nereden">
                                                                    <input type="text" id="searchInput-kategori1" placeholder="Ara...">

                                                                    <button data-user-id="">Kategori 1</button>
                                                                    <button data-user-id="">Kategori 2</button>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div> 
                                                </div>
                                            </div>

                                            <hr class="horizontal dark w-100">

                                            <div class="toplu-p b-old">
                                                <div class="esit-veri">
                                                    <p>Açıklama :</p>
                                                    <p class="toplu-info">Tüm borçlara yazılacak borç açıklamasıdır.</p>
                                                </div>
                                                <div class="esit-input">
                                                    <input class="toplu-input" type="text">
                                                </div>
                                            </div>

                                            <hr class="horizontal dark w-100">

                                            <div class="toplu-p b-old">
                                                <div class="esit-veri">
                                                    <p>Hesaplar :</p> 
                                                    <p class="toplu-info">Borçlandırmak istediğiniz kişiyi seçiniz</p>
                                                </div>
                                                <div class="esit-input col mb-0 align-items-end">
                                                    <div class="dropToplu-div w-100">
                                                        <div class="dropdown-nereden">
                                                            <div class="group">
                                                                <input class="toplu-input i-kontrol" data-user-id="" type="text" list="Users" id="hesaplar1" name="options" required="" readonly />
                                                                <i class="fa-solid fa-chevron-down absolute-input"></i>
                                                            </div>
                                                            <div class="dropdown-content-nereden searchInput-btn" id="hesaplar1DP">
                                                                <div class="dropdown-content-inside-nereden">
                                                                    <input type="text" id="searchInput1" placeholder="Ara...">

                                                                    <button data-user-id="1">Kiracılar, Yoksa kat malikleri</button>
                                                                    <button data-user-id="2">Kat Malikleri</button>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div> 
                                                    <button class="adduser btn-custom-outline finansClr m-0">İstisna Ekle</button>
                                                </div>
                                            </div>

                                            <hr class="horizontal dark w-100">

                                            <div class="mt-3 toplu-p b-old" id="tutar-ayar">
                                                <div class="esit-veri">
                                                    <p>Hesaplama Şekli :</p>
                                                    <p class="toplu-info">Tutarı daire parametrelerine veya sayaç endekslerine göre dağıtabilir yada birim fiyat olarak kullanarak sağlanan parametrelerle çarpabilirsiniz</p>
                                                </div>
                                                <div class="esit-input">
                                                    <div class="dropToplu-div w-100">
                                                        <div class="dropdown-nereden">
                                                            <div class="group">
                                                                <input class="toplu-input i-kontrol" data-user-id="" type="text" list="Users" id="tutar1" name="options" required="" readonly />
                                                                <i class="fa-solid fa-chevron-down absolute-input"></i>
                                                            </div>
                                                            <div class="dropdown-content-nereden searchInput-btn" id="tutar1DP">
                                                                <div class="dropdown-content-inside-nereden">
                                                                    <input type="text" id="searchInput-tutar1" placeholder="Ara...">

                                                                    <button data-user-id="">Tutarı Paylaştır</button>
                                                                    <button data-user-id="">Tutarı Çarp</button>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div> 
                                                    <div class="dropToplu-div w-100">
                                                        <div class="dropdown-nereden">
                                                            <div class="group">
                                                                <input class="toplu-input i-kontrol" data-user-id="" type="text" list="Users" id="pay1" name="options" required="" readonly />
                                                                <i class="fa-solid fa-chevron-down absolute-input"></i>
                                                            </div>
                                                            <div class="dropdown-content-nereden searchInput-btn" id="pay1DP">
                                                                <div class="dropdown-content-inside-nereden">
                                                                    <input type="text" id="searchInput-pay1" placeholder="Ara...">

                                                                    <button data-user-id="">Eşit Paylaştır</button>
                                                                    <button data-user-id="">Daire Tipi</button>
                                                                    <button data-user-id="">Arsa Payı</button>
                                                                    <button data-user-id="">Brüt m2</button>
                                                                    <button data-user-id="">Net m2</button>
                                                                    <button data-user-id="">Park Sayısı</button>
                                                                    <button data-user-id="">Petek Sayısı</button>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div> 
                                                </div>
                                            </div>

                                            <hr class="horizontal dark w-100">

                                            <div class="toplu-p b-old">
                                                <div class="esit-veri">
                                                    <p>Doğalgas Faturası :</p>
                                                </div>
                                                <div class="esit-input">
                                                    <div class="group w-100">
                                                        <input class="toplu-input" type="text">
                                                        <p class="absolute-tl">TL</p>
                                                    </div>
                                                </div>
                                            </div>   

                                            <div class="toplu-p mt-3 b-old align-items-center">
                                                <div class="esit-veri">
                                                    <p>Isıtılan Su Fiyatı :</p>
                                                    <p class="toplu-info">Su faturası veya su metreküp (m³) birim fiyatını girebilirsiniz. Ortak sıcak su sisteminiz yoksa boş bırakabilirsiniz.</p>
                                                </div>
                                                <div class="esit-input">
                                                    <input class="toplu-input" type="text">
                                                </div>
                                            </div>     

                                            <div class="toplu-p b-old">
                                                <div class="esit-input">
                                                    <div class="gelismis-checkbox">
                                                        <div class="yeni-check">
                                                            <input class="yenichk-inpt" id="gelismis1" type="checkbox"/>
                                                            <label class="yenichk-label" for="gelismis1"><span>
                                                                <svg width="12px" height="10px">
                                                                    <use xlink:href="#check-4"></use>
                                                                </svg></span><span>Hesaplama Şekilleri</span>
                                                            </label>
                                                            <svg class="inline-svg">
                                                                <symbol id="check-4" viewbox="0 0 12 10">
                                                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                                </symbol>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-3 b-old gelismis-ayar" id="gelismis-ayar">
                                                <div class="esit-veri">
                                                    <p>Su Sıcaklığı(tw) :</p>
                                                </div>
                                                <div class="esit-input">
                                                    <input class="toplu-input" type="text">
                                                </div>
                                            </div>
                                            
                                            <div class="mt-3 b-old gelismis-ayar" id="gelismis-ayar">
                                                <div class="esit-veri">
                                                    <p>Yakıt Alt Isıl Değeri(HU) :</p>
                                                </div>
                                                <div class="esit-input">
                                                    <input class="toplu-input" type="text">
                                                </div>
                                            </div>
                                            
                                            <div class="mt-3 b-old gelismis-ayar" id="gelismis-ayar">
                                                <div class="esit-veri">
                                                    <p>Yakıt m3 Birim Fiyatı :</p>
                                                </div>
                                                <div class="esit-input">
                                                    <input class="toplu-input" type="text">
                                                </div>
                                            </div>
                                            
                                            <div class="mt-3 toplu-p b-old">
                                                <div class="esit-veri">
                                                    <p>İlk - Son Okuma :</p>
                                                </div>
                                                <div class="esit-input">
                                                    <input class="toplu-input" type="text">
                                                    <input class="toplu-input" type="text">
                                                </div>
                                            </div>

                                            <hr class="horizontal dark w-100">

                                            <div class="toplu-p b-old tekrar-once">
                                                <div class="esit-veri">
                                                    <p>Düzenleme Tarihi :</p>
                                                </div>
                                                <div class="esit-input">
                                                    <input class="toplu-input" type="text">
                                                </div>
                                            </div>

                                            <div class="toplu-p mt-3 b-old tekrar-once">
                                                <div class="esit-veri">
                                                    <p>Son Ödeme Tarihi :</p>
                                                </div>
                                                <div class="esit-input">
                                                    <input class="toplu-input" type="text">
                                                </div>
                                            </div>

                                            <hr class="horizontal dark w-100">

                                            <div class="toplu-p mt-3 b-old">
                                                <div class="esit-input">
                                                    <button class="btn-custom-close respense-btn">İptal</button>
                                                    <button class="btn-custom respense-btn">Kaydet</button>
                                                </div>
                                            </div>

                                        </div>    
                                    </div>

                				</div>

<!-- Tab 2 End  -->

<!-- ============================================================== -->

<!-- Tab 3  -->

                				<div class="tab-pane" id="tab_default_3">  

        	                        <div class="bilgi-info mt-2">

        	                            <div class="toplu-p b-old">
        	                            	<h6 class="mt-2 mb-2">Excel'den Yükleme</h6>
        	                            </div>


        	                            
                                    </div>

                				</div>

<!-- Tab 3 End  -->

<!-- ============================================================== -->

                			</div>

                		</div>
                	</div>

                </div>

        	</div>
        </div> 
    </div>
</div>
</div>

<!-- secme Tarihi -->
    <script src="assets/js/mycode/moment.min.js"></script>
    <script src="assets/js/mycode/moment.js"></script>
    <script src="assets/js/mycode/lightpick.js"></script>

<script>
 function tarihSecikili(veri){  
    var picker = new Lightpick({
        field: document.getElementById(veri),
        singleDate: false,
        selectForward: true,
        selectBackward: false,
        lang: 'tr',
        minDate: moment(),
        repick: true,
        onSelect: function(start, end){
            var str = '';
            str += start ? start.format('DD MMMM YYYY') + ' to ' : '';
            str += end ? end.format('DD MMMM YYYY') : '...';
            document.getElementById(veri).innerHTML = str;
            document.getElementById(veri).setAttribute('data-user-id',  str);
        }
    });
}

    function tarihSec(veri,day){
    var dateFormat = 'DD MMMM YYYY';
    var picker = new Lightpick({
        field: document.getElementById(veri),
        singleDate: true,
        selectForward: true,
        selectBackward: false,
        lang: 'tr',
        minDate: moment(),
        repick: true,
        startDate: moment().add(day, 'days'),
        onSelect: function(date){
            document.getElementById(veri).value = date.format(dateFormat);
            document.getElementById(veri).setAttribute('data-user-id',  date.format("YYYY-MM-DD"));
        }
      
    });

    // Başlangıç tarihini input alanına yazdır
    document.getElementById(veri).value = moment().add(day, 'days').format(dateFormat);
    document.getElementById(veri).setAttribute('data-user-id',  moment().add(day, 'days').format("YYYY-MM-DD"));
}

     
    tarihSecikili('datepickerSecim');

tarihSec('datepicker',0);
tarihSec('datepicker2',7);



    </script>
<!-- Istisna Ekle Popup -->

<script>


  

    $('.adduser').click(function () {
        $('#popup').show().css('display', 'flex').delay(100).queue(function (next) {
            $('body').css('overflow', 'hidden');
            $('#popup').css('opacity', '1');
            $('#userForm').css('opacity', '1');
            $('#userForm').css('transform', 'translateY(0)');
            next();
        });
    });

    function closePopup() {
        $('#userForm').css('opacity', '0').css('transform', 'translateY(-180px)').delay(100).queue(function (next) {
            $('#popup').css('opacity', '0').delay(300).queue(function (nextInner) {
                $(this).hide().css('display', 'none');
                nextInner();
                $('body').css('overflow', 'auto');
            });
            next();
        });
    }
</script>

<!-- ========================================= -->

<!-- tutar checkbox -->

<script>
    document.getElementById('gelismis').addEventListener('change', function() {
        var tutarAyar = document.getElementById('tutar-ayar');
        if (this.checked) {
            tutarAyar.style.display = 'flex';
        } else {
            tutarAyar.style.display = 'none';
        }
    });

    // Sayfa yüklendiğinde "tutar-ayar" div'ini gizle
    window.onload = function() {
        document.getElementById('tutar-ayar').style.display = 'none';
    };
</script>

<!-- ========================================= -->

<!-- Gelismis su ayar -->

<script>
    document.getElementById('gelismis1').addEventListener('change', function() {
    var tutarAyarElements = document.querySelectorAll('#gelismis-ayar');
    if (this.checked) {
        tutarAyarElements.forEach(function(element) {
            element.style.display = 'flex';
        });
    } else {
        tutarAyarElements.forEach(function(element) {
            element.style.display = 'none';
        });
    }
});

// Hide all "tutar-ayar" div elements when the page loads
window.onload = function() {
    var tutarAyarElements = document.querySelectorAll('#gelismis-ayar');
    tutarAyarElements.forEach(function(element) {
        element.style.display = 'none';
    });
};

</script>

<!-- ========================================= -->

<!-- tarih Tekrar btn -->

<script>
    document.getElementById('tekrar-button').addEventListener('click', function() {
        var tekrarOnceElems = document.querySelectorAll('.tekrar-once');
        var tekrarTarihElems = document.querySelectorAll('.tekrar-tarih');

        if (this.classList.contains('active-tekrar')) {
            this.classList.remove('active-tekrar');
            tekrarOnceElems.forEach(function(elem) {
                elem.style.display = 'flex';
            });
            tekrarTarihElems.forEach(function(elem) {
                elem.style.display = 'none';
            });
        } else {
            this.classList.add('active-tekrar');
            tekrarOnceElems.forEach(function(elem) {
                elem.style.display = 'none';
            });
            tekrarTarihElems.forEach(function(elem) {
                elem.style.display = 'flex';
            });
        }
    });

    // Sayfa yüklendiğinde tekrar-tarih div'lerini gizle
    window.onload = function() {
        document.querySelectorAll('.tekrar-tarih').forEach(function(elem) {
            elem.style.display = 'none';
        });
    };
</script>

<!-- ========================================= -->

<!-- Checkbox Islemi -->

<script>

function toggleAll(masterCheckbox) {


var checkboxes = document.getElementsByClassName('check1');

for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].checked = masterCheckbox.checked;
}
if (masterCheckbox.checked) {

    $('.git-ac').addClass('git-ac-color');
} else if (!masterCheckbox.checked) {
    $('.git-ac').removeClass('git-ac-color');
}
}


function toggleMainCheckbox(id) {

var checkboxes = document.querySelectorAll('.check1'); // Tüm checkboxları al

var enAzBirSecili = false;

checkboxes.forEach(function(checkbox) {
    if (checkbox.checked) {
        enAzBirSecili = true;
    }
});





var checkbox2 = document.getElementById('check-' + id);

if (checkbox2.checked) {
    $('#' + id).addClass('git-ac-color');
} else {

    $('#' + id).removeClass('git-ac-color');
}

}


// Herhangi bir alt checkbox işaret kaldırıldığında, "Hepsini Seç" kutusunu kaldırır
var checkboxes = document.getElementsByClassName('check1');
for (var i = 0; i < checkboxes.length; i++) {
checkboxes[i].addEventListener('change', function() {
    var allChecked = true;
    for (var j = 0; j < checkboxes.length; j++) {
        if (!checkboxes[j].checked) {
            allChecked = false;
            break;
        }
    }
    document.getElementById('mainCheckbox').checked = allChecked;
});
}
</script>

<!-- Checkbox Islemi bitis -->

<!-- ========================================= -->

<!-- gecikme tazminati -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('gecikmeTazminati');
        const gecikmeTDivs = document.querySelectorAll('.gecikmeT');

        checkbox.addEventListener('change', function() {
            if (checkbox.checked) {
                gecikmeTDivs.forEach(div => div.classList.add('flex'));
            } else {
                gecikmeTDivs.forEach(div => div.classList.remove('flex'));
            }
        });
    });
</script>

<!-- gecikme tazminati bitis -->

<!-- ========================================= -->

<!-- tab lari aktif etme kisimi -->

<script>

//Fiyatı 2 basamak alır virgülden sonra *Tekrar1 eden kod ilerde düzenle
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

//seçiilen inputun içindeki verileri seçer *Tekrar1 eden kod ilerde düzenle
    function selectInput(input) {
    input.select();
}

// Tıklanan input alanını seç
const inputs = document.querySelectorAll('.sayac-input');
inputs.forEach(input => {
    input.addEventListener('click', function() {
        selectInput(this);
    });
});

// buraya kadar -----------------


    $(document).ready(function(){
        resetTabs();
        $('ul.nav.nav-tabs li a').click(function(){
            $('ul.nav.nav-tabs li.active').removeClass('active');
            $('.tab-content .tab-pane.active').removeClass('active');

            $(this).parent('li').addClass('active');
            var target = $(this).attr('href');
            $(target).addClass('active');
        });
    
        $(window).on('load', function(){
            resetTabs();
        });
    });

    function resetTabs() {
        $('ul.nav.nav-tabs li.active').removeClass('active');
        $('.tab-content .tab-pane.active').removeClass('active');
        $('ul.nav.nav-tabs li:first').addClass('active');
        $('#tab_default_1').addClass('active');
    }

</script>

<script src="assets/js/mycode/dropdown.js"></script>
<script>
dropDownn('hesaplar', 'hesaplarDP', 'searchInput');
dropDownn('kategori', 'kategoriDP', 'searchInput-kategori');
dropDownn('tutar', 'tutarDP', 'searchInput-tutar');
dropDownn('pay', 'payDP', 'searchInput-pay');
dropDownn('kacgunSonraid', 'kacgunSonra', 'searchInput-kacgunSonra');
dropDownn('gecikmeTarih', 'gecikmeTarihDP', 'searchInput-gecikmeTarih');
dropDownn('tazminatsekli', 'tazminatsekliDP', 'searchInput-tazminatsekli');

dropDownn('hesaplar1', 'hesaplar1DP', 'searchInput1');
dropDownn('kategori1', 'kategori1DP', 'searchInput-kategori1');
dropDownn('tutar1', 'tutar1DP', 'searchInput-tutar1');
dropDownn('pay1', 'pay1DP', 'searchInput-pay1');


  document.getElementById("btn-select").click();
  document.getElementById("tutar_bol").click(); 
  document.getElementById("esitPaylastır").click();

  document.getElementById("tutar_carp").addEventListener("click", function(){
    document.getElementById("esitPaylastır").style.display = "none";   
    document.getElementById("daireTipi").click();
  });

  document.getElementById("tutar_bol").addEventListener("click", function(){
    document.getElementById("esitPaylastır").style.display = "flex";   
    document.getElementById("esitPaylastır").click();
  });



</script>
<script>
function topluBorc(){
    var kategori = document.getElementById('kategori').dataset.userId;
    var aciklama = document.getElementById('aciklama').value;
    var hesaplar = document.getElementById('hesaplar').dataset.userId;
    var fiyat = document.getElementById('fiyat').value; 

    

    //Hesaplama Şekli
    var checkbox = document.getElementById('gelismis').checked;
    var tutar = document.getElementById('tutar').dataset.userId;
    var pay = document.getElementById('pay').dataset.userId;

    // Tarihler
    var duzenlemeTarih = document.getElementById('datepicker').dataset.userId;
    var sonOdemeTarihi = document.getElementById('datepicker2').dataset.userId;
    
    var tekrarTarihi = document.getElementById('datepickerSecim').dataset.userId;
    // istisna daire idleri
    let getCheckValue = getCheckedValues();


   if(!checkbox){
    



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


            },
            error: function(xhr, status, error) {
                var errorMessage = xhr.status + ': ' + xhr.statusText;
                alert('Hata alındı: ' + errorMessage);
            }
        });
   }
    
    

} 











function getCheckedValues() {
    let checkedValues = [];
    // Get all checkboxes with class 'check1'
    let checkboxes = document.querySelectorAll('.check1');
    
    // Iterate over each checkbox
    checkboxes.forEach(function(checkbox) {
        // Check if the checkbox is checked
        if (checkbox.checked) {
            // Add the data-userid value to the array
            checkedValues.push(checkbox.getAttribute('data-userid'));
        }
    });
    
    // Return the array of checked values
    return checkedValues;
}
</script>

<body>