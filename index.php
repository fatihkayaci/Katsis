<?php

//message = '<div class ="alert alert-success" role="alert"> cookkie oluşturuldu</div>';
session_start();

require_once 'class.user.php';
$user_login = new USER();
$message = "default";
 echo "cella";
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

 if($user_login->login($email,$upass))
 {
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
?> 

<!DOCTYPE html>
<html>
<head>
    <title>Login | Coding Cage</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">

    <!-- Your custom styles -->
    <link href="assets/styles.css" rel="stylesheet" media="screen">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Modernizr JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

  <body id="login">
    <div class="container">
  <?php 
  if(isset($_GET['inactive']))
  {
   ?>
            <div class='alert alert-error'>
    <button class='close' data-dismiss='alert'>&times;</button>
    <strong>Sorry!</strong> This Account is not Activated Go to your Inbox and Activate it. 
   </div>
            <?php
  }
  ?>
        <form action="validate.php" class="form-signin" method="post">
        <?php
        if(isset($_GET['error']))
  {
   ?>
            <div class='alert alert-success'>
    <button class='close' data-dismiss='alert'>&times;</button>
    <strong>Wrong Details!</strong> 
   </div>
            <?php
  }
  ?>
        <h2 class="form-signin-heading">Sign In.</h2><hr />
        <input type="email" class="input-block-level" placeholder="Email address" name="txtemail" required />
        <input type="password" class="input-block-level" placeholder="Password" name="txtupass" required />,
        <div class="g-recaptcha" data-sitekey="6Ld0njYpAAAAAC027yq47stnNrM7uKvoiGv6-Eud"></div>

        <hr />

        <input type="checkbox" name="remember" />
        <label>beni hatırla</label><br>
        <button class="btn btn-large btn-primary" type="submit" name="btn-login">Sign in</button>
      
        <a href="signup" style="float:right;" class="btn btn-large">Sign Up</a><hr />
        <a href="fpass">Lost your Password ? </a>
      </form>
      <?php 
          echo $message;
        ?>
    </div> <!-- /container -->
    <script src="bootstrap/js/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>