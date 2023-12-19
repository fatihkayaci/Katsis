<?php
// Session başlat
session_start();

// Rastgele bir sayı üret
$randomNumber = rand(1000, 9999);

// Sayıyı session'a kaydet
$_SESSION['captcha'] = $randomNumber;

// Oluşturulan sayıyı resim olarak çiz
$image = imagecreate(100, 40);
$bgColor = imagecolorallocate($image, 255, 255, 255);
$textColor = imagecolorallocate($image, 0, 0, 0);
imagestring($image, 5, 20, 10, $randomNumber, $textColor);

// Resmi görüntüleme tipini ayarla
header('Content-type: image/png');

// Resmi PNG formatında gönder
imagepng($image);

// Belleği temizle
imagedestroy($image);
?>
