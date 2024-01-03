<?php
session_start(); // Session'ları başlat

// Eğer session'da email varsa, kullanıcı girişi yapılmış demektir
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    echo "Hoş geldiniz, $email!";
} else {
    echo "Giriş yapmış bir kullanıcı bulunmamaktadır.";
}
include("header.php");
include("leftbar.php");
?>
