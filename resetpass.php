<?php
require_once 'class.user.php';
$user = new USER();

if(empty($_GET['id']) && empty($_GET['code']))
{
 $user->redirect('index.php');
}

if(isset($_GET['id']) && isset($_GET['code']))
{
 $id = base64_decode($_GET['id']);
 $code = $_GET['code'];
 
 $stmt = $user->runQuery("SELECT * FROM tbl_users WHERE userID=:uid AND tokenCode=:token");
 $stmt->execute(array(":uid"=>$id,":token"=>$code));
 $rows = $stmt->fetch(PDO::FETCH_ASSOC);
 
 if($stmt->rowCount() == 1)
 {
  if(isset($_POST['btn-reset-pass']))
  {
   $pass = $_POST['pass'];
   $cpass = $_POST['confirm-pass'];
   
   if($cpass!==$pass)
   {
    $msg = "<div class='alert alert-block'>
      <button class='close' data-dismiss='alert'>&times;</button>
      <strong>Sorry!</strong>  Password Doesn't match. 
      </div>";
   }
   else
   {
    $cpass=base64_encode($cpass);
    $stmt = $user->runQuery("UPDATE tbl_users SET userPass=:upass WHERE userID=:uid");
    $stmt->execute(array(":upass"=>$cpass,":uid"=>$rows['userID']));
    
    $msg = "<div class='alert alert-success'>
      <button class='close' data-dismiss='alert'>&times;</button>
      Password Changed.
      </div>";
    header("refresh:5;index.php");
   }
  } 
 }
 else
 {
  exit;
 }
 
 
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parola Değiştirme | Katsis</title>

    <link href="assets/css/style.css" rel="stylesheet" media="screen">

</head>
<body id="login" class="loginbody">

<div class="container">

  <div class="login-box">

  <div class="logo-box">
    <img src="admin/assets/img/ico.png" alt="">
  </div> 

    <form class="login-form" method="post">

      <h1 class="form-signin-heading">Katsis'e Hoşgeldiniz</h1>

      <p class="form-signin-heading1">Hoşgeldiniz <strong><?php echo $rows['userName'] ?> </strong> Yeni Parolanızı Oluşturunuz</p>

        <?php
        if(isset($msg))
        {
         echo $msg;
        }
        ?>

        <label class="label-block-level" for="yeniparola">Yeni Parola</label>
        <input type="password" class="input-block-level" placeholder="" id="yeniparola" name="pass" required />

        <label class="label-block-level" for="yeniparola1">Yeni Parola Tekrar</label>
        <input type="password" class="input-block-level" placeholder="" id="yeniparola1" name="confirm-pass" required />

        <button class="btn-custom" type="submit" name="btn-reset-pass">Parolamı Sıfırla</button>

        <p class="hesap">
          <a href="index">Giriş Yap</a>
        </p>
        
      </form>

    </div> 

    <div class="img-box">
      <h1 class="form-signin-heading">KATSİS</h1>
      <p class="form-signin-heading2">Bina Yönetiminde Güvenilir Çözüm!</p>
      <img src="assets/img/img.png" alt="">
    </div>  

    </div> <!-- /container -->
    <script src="bootstrap/js/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>