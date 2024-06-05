<body>

<!-- Popup Form -->

<div id="popup">

    <form class="login-form new-chck" id="userForm">

        <h2 class="form-signin-heading">İstisna Ekleme</h2>

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
                <tr id="mainTr">
                    <td data-title="Seç" class="check-style">
                        <input id="check-" data-userid=""
                            class="check1" type="checkbox" onclick="toggleMainCheckbox()" />
                        <label for="check-" class="check">
                            <svg width="18px" height="18px" viewBox="0 0 18 18">
                                <path
                                    d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z">
                                </path>
                                <polyline points="1 9 7 14 15 4"></polyline>
                            </svg>
                        </label>
                    </td>
                    <td>01</td>
                    <td>Kat Maliki</td> 
                    <td>Kiracı</td>
                </tr>

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
                                                    <button class="adduser btn-custom-outline bcoc1 m-0">İstisna Ekle</button>
                                                </div>
        	                                </div>

                                            <hr class="horizontal dark w-100">

                                            <div class="toplu-p b-old">
                                                <div class="esit-veri">
                                                    <p>Tutar :</p>
                                                    <p class="toplu-info">Gelişmiş hesaplama seçenekleri ile daire tipi, arsa payı veya sayaçlara göre borçlandırma yapabilirsiniz</p>
                                                </div>
                                                <div class="esit-input">
                                                    <input class="toplu-input" type="text">
                                                </div>
        	                                </div>

                                            <div class="toplu-p mt-3 b-old">
                                                <div class="esit-input">
                                                    <div class="gelismis-checkbox">
                                                        <div class="yeni-check">
                                                            <input class="yenichk-inpt" id="gelismis" type="checkbox"/>
                                                            <label class="yenichk-label" for="gelismis"><span>
                                                                <svg width="12px" height="10px">
                                                                    <use xlink:href="#check-4"></use>
                                                                </svg></span><span>Gelişmiş Seçenekler</span>
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
                                                <div class="esit-input">
                                                    <div class="dropToplu-div w-100">
                                                        <div class="dropdown-nereden">
                                                            <div class="group">
                                                                <input class="toplu-input i-kontrol" data-user-id="" type="text" list="Users" id="tutar" name="options" required="" readonly />
                                                                <i class="fa-solid fa-chevron-down absolute-input"></i>
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
                                                                <input class="toplu-input i-kontrol" data-user-id="" type="text" list="Users" id="pay" name="options" required="" readonly />
                                                                <i class="fa-solid fa-chevron-down absolute-input"></i>
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
                                            
                                            <div class="toplu-p mt-3 b-old">
                                                <div class="esit-input">
                                                    <button class="btn-custom-outline m-0 bcoc1" id="tekrar-button"><i class="fa-solid fa-rotate"></i> Tekrarla</button>
                                                </div>
                                            </div>
                                            
                                            <div class="toplu-p mt-3 b-old tekrar-tarih">
                                                <div class="esit-veri">
                                                    <p>İlk Tekrar Tarihi :</p>
                                                </div>
                                                <div class="esit-input">
                                                    <input class="toplu-input" id="datepickerSecim" type="text">
                                                </div>
                                            </div>
                                            
                                            <div class="toplu-p mt-3 b-old tekrar-tarih">
                                                <div class="esit-veri">
                                                    <p>Tarihine Kadar Tekrarla :</p>
                                                </div>
                                                <div class="esit-input">
                                                    <input class="toplu-input" id="datepickerSecim2" type="text">
                                                </div>
                                            </div>
                                            
                                            <div class="toplu-p mt-3 b-old tekrar-tarih">
                                                <div class="esit-veri">
                                                    <p>Son Ödeme Tarihi :</p>
                                                </div>
                                                <div class="esit-input">
                                                    <input class="toplu-input" id="datepickerSecim3" type="text">
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
                                                    <button class="adduser btn-custom-outline bcoc1 m-0">İstisna Ekle</button>
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

                                            <div class="toplu-p mt-3 b-old">
                                                <div class="esit-input">
                                                    <div class="gelismis-checkbox">
                                                        <div class="yeni-check">
                                                            <input class="yenichk-inpt" id="gelismis1" type="checkbox"/>
                                                            <label class="yenichk-label" for="gelismis1"><span>
                                                                <svg width="12px" height="10px">
                                                                    <use xlink:href="#check-4"></use>
                                                                </svg></span><span>Gelişmiş Seçenekler</span>
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
    
        var picker = new Lightpick({
            field: document.getElementById('datepickerSecim'),
            singleDate: true,
            selectForward: true,
            selectBackward: false,
            startDate: moment().startOf().add(10, 'day'),
            lang: 'tr',
            minDate: moment(),
            maxDate: moment().add(3, 'months'),
            repick: true,
            onSelect: function(date){
                document.getElementById('datepickerSecim').value = date.format('DD MMMM YYYY');
            }
        });
    
   

   
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
    $('#guncelleButton').css('display', 'inline-block');
    $('#silButton').css('display', 'inline-block');

    $('.git-ac').addClass('git-ac-color');
} else if (!masterCheckbox.checked) {
    $('#guncelleButton').css('display', 'none');
    $('#silButton').css('display', 'none');
    $('.git-ac').removeClass('git-ac-color');
}
}


function toggleMainCheckbox(id) {

var checkboxes = document.querySelectorAll('.check1'); // Tüm checkboxları al
var guncelleButton = document.getElementById('guncelleButton');
var silButton = document.getElementById('silButton');
var enAzBirSecili = false;

checkboxes.forEach(function(checkbox) {
    if (checkbox.checked) {
        enAzBirSecili = true;
    }
});

if (enAzBirSecili) {
    guncelleButton.style.display = 'inline-block';
    silButton.style.display = 'inline-block';
} else {
    guncelleButton.style.display = 'none';
    silButton.style.display = 'none';
}



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

<!-- tab lari aktif etme kisimi -->

<script>

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

dropDownn('hesaplar1', 'hesaplar1DP', 'searchInput1');
dropDownn('kategori1', 'kategori1DP', 'searchInput-kategori1');
dropDownn('tutar1', 'tutar1DP', 'searchInput-tutar1');
dropDownn('pay1', 'pay1DP', 'searchInput-pay1');


  document.getElementById("btn-select").click();


</script>

<body>