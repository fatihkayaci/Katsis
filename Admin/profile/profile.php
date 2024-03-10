<body>

    <?php
try {
    $userID = $_SESSION["userID"];
    
    //$sql = "SELECT * FROM tbl_users WHERE apartman_id = " .$_SESSION["apartID"]."AND userID=".$userID ;
    $sql = "SELECT * FROM tbl_users WHERE apartman_id = " . $_SESSION["apartID"] . " AND userID=" . $userID;

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    // Sonuç kümesinin satır sayısını kontrol etme
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($result) {
        foreach ($result as $row) {
    ?>

<div class="cener-table">

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
                        <h5 class="user-name"><?php echo $row["userName"]; ?></h5>
        	        </div>
                    <hr class="horizontal dark mt-0">
        			<div class="ps-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <label for="tc">T.C. Kimlik No</label>
                        <p id="tc"><?php echo $row["tc"]; ?></p>
        			</div>
                    <hr class="horizontal dark mt-0">
                    <div class="ps-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <label for="phoneNumber">Telefon Numarası</label>
                        <p id="phoneNumber"><?php echo $row["phoneNumber"]; ?></p>
        			</div>
                    <hr class="horizontal dark mt-0">
                    <div class="ps-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <label for="userEmail">E-Posta</label>
                        <p id="userEmail"><?php echo $row["userEmail"]; ?></p>
        			</div>
                    <hr class="horizontal dark mt-0">
                    <div class="ps-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <label for="gender">Cinsiyet</label>
                        <p id="gender"><?php echo $row["gender"]; ?></p>
        			</div>

        		</div>
        	</div>
        </div>
    </div>

    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
        <div class="h-100">	
            <div class="contact-form new-padding">     
                        <div class="col-md-12">
                			<div class="tabbable-panel">
                				<div class="tabbable-line">
                                    
                					<ul class="nav nav-tabs ">
                						<li class="active">
                							<a href="#tab_default_1" data-toggle="tab">Profil</a>
                						</li>
                						<li>
                							<a href="#tab_default_2" data-toggle="tab">Duyurular</a>
                						</li>
                						<li>
                							<a href="#tab_default_3" data-toggle="tab">Ayarlar</a>
                						</li>
                					</ul>

                					<div class="tab-content">

                						<div class="tab-pane active" id="tab_default_1">

                                            <div class="row mt-4">

        	    		                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        	    		                        	<h6 class="mt-2 mb-2">Daire Bilgileri</h6>
        	    		                        </div>

                                                <hr class="horizontal dark mt-3">

        	    		                        <div class="bilgi-p col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
        	    		                        	<p class="bilgi-p">Daire :</p>
        	    		                        </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                                    <p class="bilgi-p">Daire Yazılacak</p>
        	    		                        </div>

                                                <hr class="horizontal dark mt-0">

                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                                    <p class="bilgi-p">Kullanıcı No :</p>
        	    		                        </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                                    <p class="bilgi-p">Kullanıcı No Yazılacak</p>
        	    		                        </div>

                                                <hr class="horizontal dark mt-0">

                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                                    <p class="bilgi-p">Giriş Tarihi :</p>
        	    		                        </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                                    <p class="bilgi-p">Giriş Tarihi Yazılacak</p>
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
                                                    <p class="bilgi-p">Parola yazılacak</p>
        	    		                        </div>

                                                <hr class="horizontal dark mt-0">

                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                                    <p class="bilgi-p">Araç Plakası :</p>
        	    		                        </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                                    <p class="bilgi-p">Araç Plakası yazılacak</p>
        	    		                        </div>
                                            </div>

                						</div>

                						<div class="tab-pane" id="tab_default_2">

                                            <div class="row todo-div mt-4">
                                                <div id="myDIV" class="to-do">

                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        	    		                            	<h6 class="mt-2 mb-2">Yapılacaklar Listesi</h6>
        	    		                            </div>

                                                    <hr class="horizontal dark mt-3">

                                                    <div class="nowrap">

                                                        <input class="todo-input" type="text" id="myInput" placeholder="Görev Yazınız..">
                                                       

                                                        <span onclick="newElement()" class="todo-btn btn-custom-outline bcoc1">Ekle</span>
                                                        
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <ul class="todo-ul" id="myUL">
                                                        <li class="todo-li">yapılacak 1</li>
                                                        <li class="todo-li checked">yapılacak 2</li>
                                                        <li class="todo-li">yapılacak 3</li>
                                                        <li class="todo-li">yapılacak 4</li>
                                                        <li class="todo-li">yapılacak 5</li>
                                                    </ul>
                                                </div>
                                            </div>

                						</div>

                						<div class="tab-pane" id="tab_default_3">  

        	                                <form id="" method="post" action="">

        	                                	<div class="row mt-4">
        	                                		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        	                                			<h6 class="mt-2 mb-2">Daire Bilgileri</h6>
        	                                		</div>
        	                                		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        	                                			<label for="daire">Daire</label>
        	                                			<input class="form-inpt-duzenle" type="text"  id="daire" name="daire" value="Daire">
        	                                		</div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        	                                			<label for="kullaniciNo">Kullanıcı No</label>
        	                                			<input class="form-inpt-duzenle" type="text"  id="kullaniciNo" name="kullaniciNo" value="Kullanıcı No">
        	                                		</div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        	                                			<label for="giris">Giriş Tarihi</label>
        	                                			<input class="form-inpt-duzenle" type="text"  id="giris" name="giris" value="giris tarihi">
        	                                		</div>
        	                                		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        	                                			<label for="oturum">Son Oturum Açma Tarihi</label>
        	                                			<input class="form-inpt-duzenle" type="oturum"  id="oturum" name="oturum" value="Son Oturum Açma Tarihi">
        	                                		</div>
                                                </div>
        	                                	<div class="row">
        	                                	    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        	                                	        <div class="text-right">
        	                                	            <button type="button" id="submit" name="submit1" class="btn-black-outline">Bilgileri Güncelle</button>
        	                                	        </div>
        	                                	    </div>
        	                                	</div>

        	                                </form>

        	                                <hr class="horizontal dark mt-0">

        	                                <form id="" method="post" action="">

        	                                	<div class="row">
                                            		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            		    <h6 class="mt-3 mb-2 mt-4">Parola Değiştirme</h6>
                                            		</div>
                                            		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            		    <label for="parola">Mevcut Parola</label>
                                            		    <input class="form-inpt-duzenle" name="parola" type="password"  id="parola" placeholder="Mevcut Parolanızı Giriniz">
                                            		</div>
                                            		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            		    <label for="parolaYeni">Yeni Parola</label>
                                            		    <input class="form-inpt-duzenle" name="parolaYeni" type="password"  id="parolaYeni" placeholder="Yeni Parolanızı Giriniz">
                                            		</div>
                                            		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            		    <label for="parolaYeniTekrar">Yeni Parola Tekrar</label>
                                            		    <input class="form-inpt-duzenle" name="parolaYeniTekrar" type="password"  id="parolaYeniTekrar" placeholder="Yeni Parolanızı Tekrar Giriniz">
                                            		</div>
        	                                	</div>
        	                                	<div class="row">
        	                                	    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        	                                	        <div class="text-right">
        	                                	            <button type="button" id="submit" name="submit" class="btn-black-outline">Parola Değiştir</button>
        	                                	        </div>
        	                                	    </div>
        	                                	</div>

        	                                </form>

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

<script>
    $(function(){
      var hash = window.location.hash;
      hash && $('ul.nav a[href="' + hash + '"]').tab('show');

      $('.nav-tabs a').click(function (e) {
        $(this).tab('show');
        var scrollmem = $('body').scrollTop();
        window.location.hash = this.hash;
        $('html,body').scrollTop(scrollmem);
      });
    });
    </script>

    <script>
    var myNodelist = document.getElementsByClassName("todo-li");
    var i;
    for (i = 0; i < myNodelist.length; i++) {
        var span = document.createElement("SPAN");
        var txt = document.createTextNode("\u00D7");
        span.className = "close";
        span.appendChild(txt);
        myNodelist[i].appendChild(span);
    }

    // Click on a close button to hide the current list item
    var close = document.getElementsByClassName("close");
    var i;
    for (i = 0; i < close.length; i++) {
        close[i].onclick = function() {
            var div = this.parentElement;
            div.style.display = "none";
        }
    }

    // Add a "checked" symbol when clicking on a list item
    var list = document.querySelector('.todo-ul');
    list.addEventListener('click', function(ev) {
        if (ev.target.tagName === 'LI') {
            ev.target.classList.toggle('checked');
        }
    }, false);

    // Create a new list item when clicking on the "Add" button
    function newElement() {
        var li = document.createElement("li");
        var inputValue = document.getElementById("myInput").value;
        var t = document.createTextNode(inputValue);
        li.appendChild(t);
        if (inputValue === '') {
            alert("You must write something!");
        } else {
            document.getElementById("myUL").appendChild(li);
        }
        document.getElementById("myInput").value = "";

        var span = document.createElement("SPAN");
        var txt = document.createTextNode("\u00D7");
        span.className = "close";
        span.appendChild(txt);
        li.appendChild(span);

        // Re-bind close buttons for newly created list items
        close = document.getElementsByClassName("close");
        for (i = 0; i < close.length; i++) {
            close[i].onclick = function() {
                var div = this.parentElement;
                div.style.display = "none";
            }
        }
    }
</script>

<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  
    <?php
    }
    }
} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
?>

    <body>
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script type="text/javascript">
        //kısıtlama ile ilgili fonksiyonlar başlangıç...
        function validateFullName(fullName) {
            const regex = /^[A-Za-zÇçĞğİıÖöŞşÜü\s]+$/;
            return regex.test(fullName);
            event.preventDefault(); // Formun gönderimini engelle
        }

        function validateEmail(email) {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
            event.preventDefault(); // Formun gönderimini engelle
        }

        function validateVehiclePlate(vehiclePlate) {
            //const regex = /^\d{2}\s[A-ZÇĞİÖŞÜ]{1,3}\s\d{2,3}\s?[A-ZÇĞİÖŞÜ]{0,1}\s?[0-9]{0,3}$/; BOŞLUKLU İSTERSEK.
            const regex = /^\d{2}[A-ZÇĞİÖŞÜ]{1,3}\d{2,3}?[A-ZÇĞİÖŞÜ]{0,1}?[0-9]{0,3}$/;
            return regex.test(vehiclePlate);
            event.preventDefault(); // Formun gönderimini engelle
        }
        //parola için kısıtlama
        function validatePassword(sifre) {
            // Parola en az 8 karakterden oluşmalıdır.
            if (sifre.length < 8) {
                alert('Parola en az 8 karakterden oluşmalıdır.');
                return false;
            }

            // Parola 50 karakterden fazla olmamalıdır.
            if (sifre.length > 50) {
                alert('Parola 50 karakterden fazla olamaz.');
                return false;
            }

            // Parolada en az bir büyük harf, bir küçük harf, bir sayı ve bir özel karakter olmalıdır.
            if (!/(?=.*[a-zÇçĞğİıÖöŞşÜü])(?=.*[A-ZÇçĞğİıÖöŞşÜü])(?=.*\d)[A-Za-zÇçĞğİıÖöŞşÜü\d]/.test(sifre)) {
                alert('Parola güçlü değil. Lütfen en az bir büyük harf, bir küçük harf ve bir sayı içersin.');
                return false;
            }


            // Tüm kısıtlamalar geçildiyse true döndür
            return true;
        }
        //kısıtlama ile ilgili fonksiyonlar bitiş...

        var updateButtons = document.querySelectorAll('.updateButton');

        updateButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var row = this.closest('tr'); // Güncellenen satırı bul
                var kullaniciID = row.getAttribute('data-userid');
                var fullName = row.querySelector('td:nth-child(1)').textContent;
                var tc = row.querySelector('td:nth-child(2)').textContent;
                var phoneNumber = row.querySelector('td:nth-child(3)').textContent;
                var durum = row.querySelector('td:nth-child(4) select').value;
                var email = row.querySelector('td:nth-child(5)').textContent;
                var sifre = row.querySelector('td:nth-child(6)').textContent;
                var vehiclePlate = row.querySelector('td:nth-child(7)').textContent;
                var gender = row.querySelector('td:nth-child(8) select').value;
                //alert(kullaniciID+","+fullName+","+tc+","+phoneNumber+","+durum+","+email+","+sifre+","+vehiclePlate+","+gender);

                $.ajax({
                    url: 'Controller/update_user.php',
                    type: 'POST',
                    data: {
                        kullaniciID: kullaniciID,
                        fullName: fullName,
                        tc: tc,
                        phoneNumber: phoneNumber,
                        durum: durum,
                        email: email,
                        sifre: sifre,
                        vehiclePlate: vehiclePlate,
                        gender: gender
                    },
                    success: function(response) {
                        alert(response);
                        if (response == 1) {
                            alert("güncellendi");
                            //location.reload();
                        }
                    },
                    error: function(error) {
                        console.error('Gönderim hatası:', error);
                    }
                });
            });
        });
        var deleteButtons = document.querySelectorAll('.deleteButton');

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
        </script>

        <script type="text/javascript">
        $.fn.extend({
            alterCheck: function(tablo) {
                if ($("" + tablo + " input[type='checkbox']:first").is(":checked")) {
                    return this.each(function() {
                        this.checked = true;
                    });
                } else {
                    return this.each(function() {
                        this.checked = false;
                    });
                }
            }
        });

        $("#example input[type='checkbox']:first").click(function() {
            $("#example input[type='checkbox']").alterCheck('#example');
        });
        </script>