<?php
function randomPassword($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $userPass = '';

    for ($i = 0; $i < $length; $i++) {
        $userPass .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $userPass;
}




?>