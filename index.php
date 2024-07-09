<?php
session_start();
require_once 'class.user.php';
$user_login = new USER();

function validateCaptcha($captcha) {
    $secretKey = "6Ld0njYpAAAAAGByIPz8beq8vT-LAt19XUDR-5Hm";
    $ip = $_SERVER['REMOTE_ADDR'];
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
    $responseKeys = json_decode($response, true);
    return intval($responseKeys["success"]) === 1;
}

function setCookies($email, $password) {
    setcookie("cokkiemail", base64_encode($email), time() + (86400 * 30));
    setcookie("cokkiepass", base64_encode($password), time() + (86400 * 30));
}

function redirectUserBasedOnRole($role) {
    global $user_login;
    if ($role == 1) {
        $user_login->redirect('Admin/index?parametre=dashboard');
    } elseif ($role == 3) {
        $user_login->redirect('Kullanici/giris');
    } else {
        echo '<h2>Geçersiz kullanıcı rolü.</h2>';
    }
}

if (isset($_COOKIE["cokkiemail"]) && isset($_COOKIE["cokkiepass"])) {
    $email = base64_decode($_COOKIE["cokkiemail"]);
    $upass = base64_decode($_COOKIE["cokkiepass"]);
    $_SESSION["mail"] = $email;
    if ($user_login->login($email, $upass)) {
        $_SESSION["mail"] = $email;
        redirectUserBasedOnRole($_SESSION['rol']);
    }
}

if (isset($_POST['btn-login'])) {
    $email = $_POST['txtemail'];
    $upass = $_POST['txtupass'];
    base64_decode($upass);
    $remember = trim($_POST["remember"]);
    
    if (isset($_POST['g-recaptcha-response'])) {
        $captcha = $_POST['g-recaptcha-response'];
    }

    if (!$captcha || !validateCaptcha($captcha)) {
        echo '<h2>Lütfen captcha bölümünü kontrol ediniz!</h2>';
        header('Location: /katsis');
        exit();
    }

    if ($user_login->login($email, $upass)) {
     
        if ($remember == "on") {
            setCookies($email, $upass);
        }
        $_SESSION["mail"] = $email;
        redirectUserBasedOnRole($_SESSION['rol']);
    } else {
        echo '<h2>Geçersiz email veya şifre.</h2>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="76x76" href="admin/assets/img/ico.png">
    <link rel="icon" type="image/png" href="admin/assets/img/ico.png">
    <title>Giriş Yap | Katsis</title>


    <!-- Your custom styles -->
    
    <link href="assets/css/style.css" rel="stylesheet" media="screen">

    <script src="https://kit.fontawesome.com/be694eddd8.js" crossorigin="anonymous"></script>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen"> -->

    <!-- Modernizr JavaScript -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script> -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body id="login" class="loginbody">
  
  <div class="container">

    <div class="login-box">

      <div class="logo-box">
        <img src="admin/assets/img/ico.png" alt="">
      </div> 

      <form class="login-form" method="post">

        <h1 class="form-signin-heading">Katsis'e Hoşgeldiniz</h1>

        <p class="form-signin-heading1">Giriş yapmak için lütfen bilgilerinizi giriniz</p>


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
        <label class="label-block-level" for="txtemail">E-Posta veya Kullanıcı Numarası</label>
        <div class="inputBox">
        <input type="text" class="input-block-level" id="txtemail" placeholder="E-posta adresi" name="txtemail" required />
        </div>

        
        <label class="label-block-level" for="txtupass">Parola</label>
        <div class="inputBox">
          <input type="password" class="input-block-level" placeholder="Şifre" id="txtupass" name="txtupass" required />
          <i id="eyeicon" class="fa-regular fa-eye-slash"></i>
        </div>
        
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

        <button class="btn-custom" type="submit" name="btn-login">Giriş yap</button>

        <p class="hesap">
          Hesabınız yok mu?<br> <a href="signup">Hesap Oluştur</a>
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
    let password = document.getElementById("txtupass");

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


  <script src="bootstrap/js/jquery-1.9.1.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
