<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
try {
    $userID = null;
    if(isset($_GET['userID'])) {
        $userID = $_GET['userID'];
    }
    
    //$sql = "SELECT * FROM tbl_users WHERE apartman_id = " .$_SESSION["apartID"]."AND userID=".$userID ;
    $sql = "SELECT * FROM tbl_users WHERE apartman_id = " . $_SESSION["apartID"] . " AND userID=" . $userID;

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    // Sonuç kümesinin satır sayısını kontrol etme
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($result) {
        foreach ($result as $row) {
    ?>

<div class="emp-profile row">

    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
        <div class="h-100">
        	<div class="contact-form">
        		<div class="account-settings">

                    <div class="user-profile">
        	        	<div class="user-avatar">
        	        		<p>YF</p>
        	        	</div>
                        <h5 class="user-name"><?php echo $row["userName"]; ?></h5>
        	        </div>

        			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <label for="tc">T.C. Kimlik No</label>
                        <input class="form-inpt" type="text"  id="tc" name="tc" value="<?php echo $row["tc"]; ?>">
        			</div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <label for="phoneNumber">Telefon Numarası</label>
                        <input class="form-inpt" type="text"  id="phoneNumber" name="phoneNumber" value="<?php echo $row["phoneNumber"]; ?>">
        			</div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <label for="userEmail">E-Posta</label>
                        <input class="form-inpt" type="text"  id="userEmail" name="userEmail" value="<?php echo $row["userEmail"]; ?>">
        			</div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <label for="gender">Cinsiyet</label>
                        <select class="form-inpt select-fix" id="gender">
                            <option value="Erkek" <?php echo ($row["gender"] == "Erkek" ? 'selected' : '') ?>>Erkek</option>
                            <option value="Kadın" <?php echo ($row["gender"] == "Kadın" ? 'selected' : '') ?>>Kadın</option>
                        </select>
        			</div>

        	    	<div class="user-btn-area">
        	    	    <button type="button" id="submit" name="submit1" class="btn-black-outline">Bilgileri Güncelle</button>
        	    	</div>

        		</div>
        	</div>
        </div>
    </div>

    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
        <div class="h-100">	
            <div class="contact-form">                

        	    <form id="" method="post" action="">

        	    	<div class="row">
        	    		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        	    			<h6 class="mb-2">Daire Bilgileri</h6>
        	    		</div>
        	    		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        	    			<label for="daire">Daire</label>
        	    			<input class="form-inpt" type="text"  id="daire" name="daire" value="Daire">
        	    		</div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        	    			<label for="kullaniciNo">Kullanıcı No</label>
        	    			<input class="form-inpt" type="text"  id="kullaniciNo" name="kullaniciNo" value="Kullanıcı No">
        	    		</div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        	    			<label for="giris">Giriş Tarihi</label>
        	    			<input class="form-inpt" type="text"  id="giris" name="giris" value="giris tarihi">
        	    		</div>
        	    		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        	    			<label for="oturum">Son Oturum Açma Tarihi</label>
        	    			<input class="form-inpt" type="oturum"  id="oturum" name="oturum" value="Son Oturum Açma Tarihi">
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
                		    <input class="form-inpt" name="parola" type="password"  id="parola" placeholder="Mevcut Parolanızı Giriniz">
                		</div>
                		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                		    <label for="parolaYeni">Yeni Parola</label>
                		    <input class="form-inpt" name="parolaYeni" type="password"  id="parolaYeni" placeholder="Yeni Parolanızı Giriniz">
                		</div>
                		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                		    <label for="parolaYeniTekrar">Yeni Parola Tekrar</label>
                		    <input class="form-inpt" name="parolaYeniTekrar" type="password"  id="parolaYeniTekrar" placeholder="Yeni Parolanızı Tekrar Giriniz">
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

    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
        <div class="h-100">
        	<div class="contact-form">
        		<div class="account-settings">

                    <div class="btn-box-users">
                        <button class="btn-box-outline">Düzenle</button>
                        <div>
                        <button class="btn-box-outline">Borç</button>
                        <button class="btn-box-outline">Tahsilat</button>
                        </div>
                    </div>

                    <div class="borc-box">
                        <a href="">
                            <p class="borc">borç yazar burda be</p>
                            <p class="para">30 TL</p>
                        </a>

                        <a href="">
                            <p class="borc">borç yazar burda be</p>
                            <p class="para">30 TL</p>
                        </a>

                        <a href="">
                            <p class="borc">borç yazar burda be</p>
                            <p class="para">30 TL</p>
                        </a>

                        <a href="">
                            <p class="borc">borç yazar burda be</p>
                            <p class="para">30 TL</p>
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