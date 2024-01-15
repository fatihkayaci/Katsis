<?php
session_start();
require_once 'class.user.php';

$reg_user = new USER();

if($reg_user->is_logged_in()!="")
{
 $reg_user->redirect('home.php');
}


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
  if($reg_user->register($uname,$email,$upass,$code))
  {   
   $id = $reg_user->lasdID();  
   $key = base64_encode($id);
   $id = $key;
   
   $message = "     
      Merhaba $uname,
      <br /><br />
      Katsis'e Hoşgeldiniz.<br/>
      Kaydınızı tamamlamak için aşağıdaki bağlantıya tıklamanız yeterlidir.<br/>
      <br /><br />
      <a href='http://localhost/katsis/verify.php?id=$id&code=$code'>Etkinleştirmek için BURAYA tıklayın</a>
      <br /><br />
      Teşekkürler,";
      
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
<html>
  <head>
    <title>Hesap Oluştur | Katsis</title>

    <!-- Bootstrap -->
    
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">

    <!-- Your custom styles -->
    
    <link href="assets/css/style.css" rel="stylesheet" media="screen">
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
  </head>
  <body id="login" class="loginbody">

    <div class="container">

      <div class="logo-box">
        <img src="assets/img/siyah.png" alt="">
      </div> 

      <div class="login-box">
        
          <form class="login-form" method="post">

            <h2 class="form-signin-heading">Hesap Oluştur</h2>
            
            <div class="hr"></div>

            <?php if(isset($msg)){
             echo $msg; 
            }  ?>
            
            <input type="text" class="input-block-level" placeholder="Kullanıcı Adı" name="txtuname" required />
            <input type="email" class="input-block-level" placeholder="E-Posta Adresi" name="txtemail" required />
            <input type="password" class="input-block-level" placeholder="Parola" name="txtpass" required />
            <input type="password" class="input-block-level" placeholder="Parola Tekrarı" name="confirm_password" required />
          
            <button class="btn btn-large btn-primary" type="submit" name="btn-signup">Hesap Oluştur</button>
            <a href="index.php" class="btn btn-large olusturbtn">Giriş Yap</a>
          </form>

          <div class="hr"></div>

      </div>
    </div> <!-- /container -->

    <script src="vendors/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>