<?php
session_start();

// Post isteğinden trId'yi al
$trId = $_POST['id'];
$d = $_POST['d'];
$dId = $_POST['dId'];

if($dId==""){
    $_SESSION['dId'] = "";
}else{
    $_SESSION['dId'] = $dId;
}

if($d =="daire"){
    // Oturum verilerini ayarla
    $_SESSION['daireSayfa'] = $trId;

// İsteğe yanıt olarak bir mesaj gönder
    echo true;
}else if($d =="user"){
    $_SESSION['userPage'] = $trId;
    echo true;
}

?>