<?php
session_start();
require_once 'class.user.php';

$reg_user = new USER();




if(isset($_POST['btn-signup']))
{
 $uname = trim($_POST['txtuname']);
 $email = trim($_POST['txtemail']);
 $upass = trim($_POST['txtpass']);
 $confirmPassword = trim($_POST["confirm_password"]);


 if (empty($email) || empty($upass) || empty($confirmPassword) ) {
  echo "Lütfen tüm alanları doldurun.";
} else if ($upass != $confirmPassword) {
  echo "Parolalar eşleşmiyor.";
}

 $code = md5(uniqid(rand()));
 
 $stmt = $reg_user->runQuery("SELECT * FROM tbl_users WHERE userEmail=:email_id");
 $stmt->execute(array(":email_id"=>$email));
 $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
 if($stmt->rowCount() > 0)
 {
  $msg = "
        <div class='alert alert-danger'>
        <strong>Uyarı!</strong>  Bu E-Posta Zaten Kayıtlı, Başka Bir E-Posta Deneyiniz.
        </div>
        ";
 }
 else
 {
  if($reg_user->register($uname,$email,$upass,$code,$confirmPassword))
  {   
   $id = $reg_user->lasdID();  
   $key = base64_encode($id);
   $id = $key;
   
   $message = "     
      Merhaba $uname,
      <br/><br/>
      Katsis'e Hoşgeldiniz.<br/>
      Kaydınızı tamamlamak için aşağıdaki bağlantıya tıklamanız yeterlidir.<br/>
      <br/>
      <a href='http://localhost/katsis/verify.php?id=$id&code=$code'>Etkinleştirmek için BURAYA tıklayın</a>
      <br/><br/>
      Teşekkürler.";
      
   $subject = "Kaydınızı doğrulayınız";
      
   $reg_user->send_mail($email,$message,$subject); 
   $msg = "
     <div class='alert alert-success'>
      <strong>Kaydınız Başarılı!</strong> $email E-Posta Adresinize Doğrulama Maili Göderdik.
                    Lütfen Mail Hesabınızı kontrol Ediniz. 
       </div>
     ";
  }
  else
  {
   echo "sorry , Query could no execute...";
  }  
 }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hesap Oluştur | Katsis</title>

    <!-- Bootstrap -->
    
    <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen"> -->

    <!-- Your custom styles -->
    
    <link href="assets/css/style.css" rel="stylesheet" media="screen">
    
    <script src="https://kit.fontawesome.com/be694eddd8.js" crossorigin="anonymous"></script>
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
  </head>
  <body id="login" class="loginbody">

    <div class="container">

      <div class="login-box">

        <div class="logo-box">
          <img src="admin/assets/img/ico.png" alt="">
        </div> 
        
          <form class="login-form" method="post">

            <h1 class="form-signin-heading">Katsis'e Hoşgeldiniz</h1>
            
            <p class="form-signin-heading1">Hesap oluşturmak için lütfen bilgilerinizi giriniz</p>

            <?php if(isset($msg)){
             echo $msg; 
            }  
            ?>

            <label class="label-block-level" for="txtuname">Ad Soyad</label>
            <div class="inputBox">
              <input type="text" class="input-block-level" placeholder="Ad ve Soyad" id="txtuname" name="txtuname" required />
            </div>

            <label class="label-block-level" for="txtemail">E-Posta</label>
            <div class="inputBox">
              <input type="email" class="input-block-level" placeholder="E-Posta Adresi" id="txtemail" name="txtemail" required />
            </div>

            <label class="label-block-level" for="txtpass">Parola</label>
            <div class="inputBox">
              <input type="password" class="input-block-level" placeholder="Parola" id="txtpass" name="txtpass" required />
              <i id="eyeicon" class="fa-regular fa-eye-slash"></i>
            </div>

            <label class="label-block-level" for="confirm_password">Parola Tekrarı</label>
            <div class="inputBox">
              <input type="password" class="input-block-level" placeholder="Parola Tekrarı" id="confirm_password" name="confirm_password" required />
              <i id="eyeicon1" class="fa-regular fa-eye-slash"></i>
            </div>

            <button class="btn-custom" type="submit" id="" name="btn-signup">Hesap Oluştur</button>
            
            <p class="hesap">
              Hesabınız var mı?<br> <a href="index">Giriş Yap</a>
            </p>
          
          </form>

      </div>

      <div class="img-box">
        <h1 class="form-signin-heading">KATSİS</h1>
        <p class="form-signin-heading2">Bina Yönetiminde Güvenilir Çözüm!</p>
        <img src="assets/img/img.png" alt="">
      </div>
      
    </div> <!-- /container -->

    <script>
    let eyeicon = document.getElementById("eyeicon");
    let password = document.getElementById("txtpass");

    eyeicon.addEventListener("click", () => {
        if (password.type == "password") {
            password.type = "text";
            eyeicon.classList.remove("fa-eye-slash");
            eyeicon.classList.add("fa-eye");
        } else {
            password.type = "password";
            eyeicon.classList.remove("fa-eye");
            eyeicon.classList.add("fa-eye-slash");
        }
    });
    </script>

    <script>
        let eyeicon1 = document.getElementById("eyeicon1");
        let password1 = document.getElementById("confirm_password");

        eyeicon1.addEventListener("click", () => {
            if (password1.type == "password") {
                password1.type = "text";
                eyeicon1.classList.remove("fa-eye-slash");
                eyeicon1.classList.add("fa-eye");
            } else {
                password1.type = "password";
                eyeicon1.classList.remove("fa-eye");
                eyeicon1.classList.add("fa-eye-slash");
            }
        });
    </script>


    <script src="vendors/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>