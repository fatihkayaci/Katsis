<body>

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

                				<div class="tab-pane active" id="tab_default_1">

                                    <div class="bilgi-info toplu-flex mt-2">

        	                            <div class="bilgi-p b-old">
        	                            	<h4 class="mt-2 mb-2">Toplu Borç</h4>
        	                            </div>

                                        <div class="toplu-borc-inside">

                                            <div class="bilgi-p b-old">
                                                <div class="esit-veri">
        	                                    	<p>Açıklama :</p>
                                                    <p class="toplu-info">Tüm borçlara yazılacak borç açıklamasıdır.</p>
                                                </div>
                                                <div class="esit-input">
                                                    <input class="toplu-input" type="text">
                                                </div>
        	                                </div>

                                            <hr class="horizontal dark w-100">

                                            <div class="bilgi-p b-old">
                                                <div class="esit-veri">
                                                    <p>Kategori :</p>
                                                    <p class="toplu-info">işleminize uygun kategoriyi seçiniz.</p>
                                                </div>
                                                <div class="esit-input">
                                                    <div class="dropToplu-div w-100">
                                                        <div class="dropdown-nereden">
                                                            <div class="group">
                                                                <input class="toplu-input" data-user-id="" type="text" list="Users" id="kategori" name="options" required="" />
                                                            </div>
                                                            <div class="dropdown-content-nereden searchInput-btn" id="kategoriDP">
                                                                <div class="dropdown-content-inside-nereden">
                                                                    <input type="text" id="searchInput-kategori" placeholder="Ara...">

                                                                    <button data-user-id="">Kategori 1</button>
                                                                    <button data-user-id="">Kategori 2</button>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div> 
                                                </div>
        	                                </div>

                                            <hr class="horizontal dark w-100">

                                            <div class="bilgi-p b-old">
                                                <div class="esit-veri">
                                                    <p>Hesaplar :</p> 
                                                    <p class="toplu-info">Borçlandırmak istediğiniz kişiyi seçiniz</p>
                                                </div>
                                                <div class="esit-input">
                                                    <div class="dropToplu-div w-100">
                                                        <div class="dropdown-nereden">
                                                            <div class="group">
                                                                <input class="toplu-input" data-user-id="" type="text" list="Users" id="hesaplar" name="options" required="" readonly />
                                                            </div>
                                                            <div class="dropdown-content-nereden searchInput-btn" id="hesaplarDP">
                                                                <div class="dropdown-content-inside-nereden">
                                                                    <input type="text" id="searchInput" placeholder="Ara...">

                                                                    <button data-user-id="">Kiracılar, Yoksa kat malikleri</button>
                                                                    <button data-user-id="">Kat Malikleri</button>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div> 
                                                </div>
        	                                </div>

                                            <hr class="horizontal dark w-100">

                                            <div class="bilgi-p b-old">
                                                <div class="esit-veri">
                                                    <p>Tutar :</p>
                                                    <p class="toplu-info">Gelişmiş hesaplama seçenekleri ile daire tipi, arsa payı veya sayaçlara göre borçlandırma yapabilirsiniz</p>
                                                </div>
                                                <div class="esit-input">
                                                    <input class="toplu-input" type="text">
                                                </div>
        	                                </div>

                                            <div class="bilgi-p mt-3 b-old">
                                                <div class="esit-input">
                                                    <input id="gelismis" type="checkbox">
                                                    <label for="gelismis">Gelişmiş Seçenekler</label>
                                                </div>
                                            </div>

                                            <div class="tutar-ayar mt-3 bilgi-p b-old" id="tutar-ayar">
                                                <div class="esit-veri">
                                                    <p>Hesaplama Şekli :</p>
                                                    <p class="toplu-info">Tutarı daire parametrelerine veya sayaç endekslerine göre dağıtabilir yada birim fiyat olarak kullanarak sağlanan parametrelerle çarpabilirsiniz</p>
                                                </div>
                                                <div class="esit-input">
                                                    <div class="dropToplu-div w-100">
                                                        <div class="dropdown-nereden">
                                                            <div class="group">
                                                                <input class="toplu-input" data-user-id="" type="text" list="Users" id="tutar" name="options" required="" readonly />
                                                            </div>
                                                            <div class="dropdown-content-nereden searchInput-btn" id="tutarDP">
                                                                <div class="dropdown-content-inside-nereden">
                                                                    <input type="text" id="searchInput-tutar" placeholder="Ara...">

                                                                    <button data-user-id="">Tutarı Paylaştır</button>
                                                                    <button data-user-id="">Tutarı Çarp</button>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div> 
                                                    <div class="dropToplu-div w-100">
                                                        <div class="dropdown-nereden">
                                                            <div class="group">
                                                                <input class="toplu-input" data-user-id="" type="text" list="Users" id="pay" name="options" required="" readonly />
                                                            </div>
                                                            <div class="dropdown-content-nereden searchInput-btn" id="payDP">
                                                                <div class="dropdown-content-inside-nereden">
                                                                    <input type="text" id="searchInput-pay" placeholder="Ara...">

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

                                            <div class="bilgi-p b-old tekrar-once">
                                                <div class="esit-veri">
                                                    <p>Düzenleme Tarihi :</p>
                                                </div>
                                                <div class="esit-input">
                                                    <input class="toplu-input" type="text">
                                                </div>
                                            </div>
                                            
                                            <div class="bilgi-p mt-3 b-old tekrar-once">
                                                <div class="esit-veri">
                                                    <p>Son Ödeme Tarihi :</p>
                                                </div>
                                                <div class="esit-input">
                                                    <input class="toplu-input" type="text">
                                                </div>
                                            </div>
                                            
                                            <div class="bilgi-p mt-3 b-old">
                                                <div class="esit-input">
                                                    <button class="btn-custom-outline m-0 bcoc2" id="tekrar-button"><i class="fa-solid fa-rotate"></i> Tekrarla</button>
                                                </div>
                                            </div>
                                            
                                            <div class="bilgi-p mt-3 b-old tekrar-tarih">
                                                <div class="esit-veri">
                                                    <p>İlk Tekrar Tarihi :</p>
                                                </div>
                                                <div class="esit-input">
                                                    <input class="toplu-input" type="text">
                                                </div>
                                            </div>
                                            
                                            <div class="bilgi-p mt-3 b-old tekrar-tarih">
                                                <div class="esit-veri">
                                                    <p>Tarihine Kadar Tekrarla :</p>
                                                </div>
                                                <div class="esit-input">
                                                    <input class="toplu-input" type="text">
                                                </div>
                                            </div>
                                            
                                            <div class="bilgi-p mt-3 b-old tekrar-tarih">
                                                <div class="esit-veri">
                                                    <p>Son Ödeme Tarihi :</p>
                                                </div>
                                                <div class="esit-input">
                                                    <input class="toplu-input" type="text">
                                                </div>
                                            </div>

                                            <hr class="horizontal dark w-100">

                                            <div class="bilgi-p mt-3 b-old">
                                                <div class="esit-input">
                                                    <button class="btn-custom-close">İptal</button>
                                                    <button class="btn-custom">Kaydet</button>
                                                </div>
                                            </div>

        	                            </div>    
                                    </div>

                				</div>

                				<div class="tab-pane" id="tab_default_2">

                                    <div class="bilgi-info mt-2">

        	                            <div class="bilgi-p b-old">
        	                            	<h6 class="mt-2 mb-2">Sayaç Endeksi</h6>
        	                            </div>


        	                            
                                    </div>

                				</div>

                				<div class="tab-pane" id="tab_default_3">  

        	                        <div class="bilgi-info mt-2">

        	                            <div class="bilgi-p b-old">
        	                            	<h6 class="mt-2 mb-2">Excel'den Yükleme</h6>
        	                            </div>


        	                            
                                    </div>

                				</div>

                			</div>

                		</div>
                	</div>

                </div>

        	</div>
        </div> 
    </div>
    
</div>
</div>

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

<script>

/* tab lari aktif etme kisimi */
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
</script>

<body>