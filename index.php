<?php
//message = '<div class ="alert alert-success" role="alert"> cookkie oluşturuldu</div>';
session_start();
require_once 'class.user.php';
$user_login = new USER();
$message = "default";

if($user_login->is_logged_in()!="")
{
 $user_login->redirect('home.php');
}

if(isset($_POST['btn-login']))
{
 $email = trim($_POST['txtemail']);
 $upass = trim($_POST['txtupass']);
 $remember = isset($_POST["remember"]);
 
 if($remember){
 ?>
 <script>alert("i")</script>;
 <?php
 }
 if($user_login->login($email,$upass))
 {
  $emailcokkie= setcookie("cokkiemail",$email);
  $passcokkie= setcookie("cokkiepass",$pass);
  $user_login->redirect('home.php');
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
        <form class="form-signin" method="post">
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
        <input type="password" class="input-block-level" placeholder="Password" name="txtupass" required />
      <hr />
        <input type="checkbox" name="rememberMe"/>
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