
<?php

//message = '<div class ="alert alert-success" role="alert"> cookkie oluşturuldu</div>';
session_start();

require_once 'class.user.php';
$user_login = new USER();


if (isset($_COOKIE["cokkiemail"]) && isset($_COOKIE["cokkiepass"])){

  $email = base64_decode($_COOKIE["cokkiemail"]);
  $upass = base64_decode($_COOKIE["cokkiepass"]);
  $_SESSION["mail"] =$email;
  if($user_login->login($email,$upass))
  {
    $_SESSION["mail"] =$email;
    $user_login->redirect('Admin/index');
  }
}

if(isset($_POST['btn-login']))
{
 $email = $_POST['txtemail'];
 $upass = $_POST['txtupass'];
 $remember =trim($_POST["remember"]);
 if(isset($_POST['g-recaptcha-response'])){
      $captcha=$_POST['g-recaptcha-response'];
    }
    if(!$captcha){
      echo '<h2>Lütfen captcha bölümünü kontrol ediniz!</h2>';
      header('Location: '.'/katsis');
    }
    $secretKey = "6Ld0njYpAAAAAGByIPz8beq8vT-LAt19XUDR-5Hm";
    $ip = $_SERVER['REMOTE_ADDR'];
    $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
    $responseKeys = json_decode($response,true);

 if($user_login->login($email,$upass))
 {
  if(intval($responseKeys["success"]) !== 1) {
      echo '<h2>Spam? ! Tekrar kontrol etmelisin.</h2>';
    }else{
       if($remember =="on"){
   //decode64 çözmek için hee!!
    $emailcokkie= setcookie("cokkiemail", base64_encode($email)
    , time()+(86400*30));
    $passcokkie= setcookie("cokkiepass", base64_encode($upass)
    ,time()+(86400*30));
  }
  $_SESSION["mail"] =$email;
  $user_login->redirect('Admin/index');
 }
    }
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap | Katsis</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">

    <!-- Your custom styles -->
    
    <link href="assets/css/style.css" rel="stylesheet" media="screen">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Modernizr JavaScript -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script> -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body id="login" class="loginbody">
  
  <div class="container">

    <div class="logo-box">
      <img src="assets/img/siyah.png" alt="">
    </div> 

    <div class="login-box">

      <form class="login-form" method="post">

        <h2 class="form-signin-heading">Giriş Yap</h2>

        <div class="hr"></div>

      <?php
      if(isset($_GET['inactive']))
      {
       ?>
        <div class='alert alert-warning'>
          <strong>Uyarı!</strong> Hesap henüz aktive edilmemiş. Lütfen gelen kutunuzu kontrol edin ve hesabınızı aktifleştirin.
        </div>
      <?php
      }
      ?>

      <?php
      if(isset($_GET['error']))
      {
      ?>
      <div class='alert alert-danger'>
        <strong>E-posta adresiniz veya şifreniz hatalı.</strong> 
      </div>
      <?php
      }
      ?>

        <input type="email" class="input-block-level" placeholder="E-posta adresi" name="txtemail" required />

        <input type="password" class="input-block-level1" placeholder="Şifre" name="txtupass" required />

        <div class="remember-div">

          <div class="checkbox-wrapper-4">
            <input class="inp-cbx" type="checkbox" name="remember" id="remember"/>
            <label class="cbx" for="remember"><span>
            <svg width="12px" height="10px">
              <use xlink:href="#check-4"></use>
            </svg></span><span>Oturumum açık kalsın</span></label>
            <svg class="inline-svg">
              <symbol id="check-4" viewbox="0 0 12 10">
                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
              </symbol>
            </svg>
          </div>

          <a class="fpass" href="fpass">Şifremi unuttum</a>

        </div>

        <div class="g-recaptcha" data-sitekey="6Ld0njYpAAAAAC027yq47stnNrM7uKvoiGv6-Eud"></div>

        <button class="btn btn-large btn-primary" type="submit" name="btn-login">Giriş yap</button>

        <a href="signup" class="btn btn-large olusturbtn">Hesap Oluştur</a>

        <div class="hr"></div>

      </form>

    </div>

  </div> <!-- /container -->
  
  <script src="bootstrap/js/jquery-1.9.1.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
