<?php
    $email;$comment;$captcha;
    if(isset($_POST['email'])){
      $email=$_POST['email'];
    }if(isset($_POST['comment'])){
      $email=$_POST['comment'];
    }if(isset($_POST['g-recaptcha-response'])){
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
    if(intval($responseKeys["success"]) !== 1) {
      echo '<h2>Spam? ! Tekrar kontrol etmelisin.</h2>';
    } else {
        header('Location: '.'/katsis/Admin/index.php');
    }
?>