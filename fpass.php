<?php
session_start();
require_once 'class.user.php';
$user = new USER();

if($user->is_logged_in()!="")
{
 $user->redirect('home.php');
}

if(isset($_POST['btn-submit']))
{
 $email = $_POST['txtemail'];
 
 $stmt = $user->runQuery("SELECT userID FROM tbl_users WHERE userEmail=:email LIMIT 1");
 $stmt->execute(array(":email"=>$email));
 $row = $stmt->fetch(PDO::FETCH_ASSOC); 
 if($stmt->rowCount() == 1)
 {
  $id = base64_encode($row['userID']);
  $code = md5(uniqid(rand()));
  
  $stmt = $user->runQuery("UPDATE tbl_users SET tokenCode=:token WHERE userEmail=:email");
  $stmt->execute(array(":token"=>$code,"email"=>$email));
  
  $message= "
       Merhaba , $email
       <br /><br />
       Parola değiştirme talebinizi aldık. Eğer bu işlemi siz yapmadıysanız hesap bilgilerini değiştiriniz ve bizimle iletişime geçiniz.
       <br /><br />
       Parolanızı değiştirmek için link'e tıklayınız.
       <br /><br />
       <a href='http://localhost/katsis/resetpass.php?id=$id&code=$code'>Parolayı değiştirmek için tıklayınız.</a>
       <br /><br />
       Teşekkürler :)
       ";
  $subject = "Password Reset";
  
  $user->send_mail($email,$message,$subject);
  
  $msg = "<div class='alert alert-success alert-area-password'>
     Talebinizi aldık. Yeni parolanızı oluşturmak için, $email Postanıza parola yenileme postası gönderdik.
                  Yeni parolanızı oluşturmak için postanıza gelen maildeki adımları takip ediniz.
      </div>";
 }
 else
 {
  $msg = "<div class='alert alert-danger alert-area-password'>
     <strong>Üzgünüz!</strong>  Kayıtlı Bir E-Posta Bulunamadı. 
       </div>";
 }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Şifremi Unuttum | Katsis</title>
    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">

    <!-- Your custom styles -->
    
    <link href="assets/css/style.css" rel="stylesheet" media="screen">
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body id="login" class="loginbody">

    <div class="container">

      <div class="logo-box">
        <img src="assets/img/siyah.png" alt="">
      </div> 

      <div class="login-box1">

      <form class="login-form" method="post">

          <h2 class="form-signin-heading">Şifremi Unuttum</h2>
          
          <div class="hr"></div>

          <?php
          if(isset($msg))
          {
           echo $msg;
          }
          else
          {
           ?>
           <div class='alert alert-info alert-area-password'>
           Lütfen kayıt olduğunuz e-posta adresinizi yazınız. E-posta adresinize şifre sıfırlama linki gönderilecektir.
           </div>  
          <?php
          }
          ?>

        <input type="email" class="input-block-level" placeholder="E-posta Hesabınız" name="txtemail" required />
        <hr />

        <button class="btn btn-danger btn-primary" type="submit" name="btn-submit">Parolamı Sıfırla</button>
        
        <a href="index.php" class="btn btn-large olusturbtn">Giriş Yap</a>

        <div class="hr"></div>

      </form>
    </div> 

    </div> <!-- /container -->
    <script src="bootstrap/js/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>