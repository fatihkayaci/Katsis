<?php
include("../../DB/dbconfig.php");
function randomPassword($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $userPass = '';

    for ($i = 0; $i < $length; $i++) {
        $userPass .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $userPass;
}


function generateUniqueUserID( $conn) {

    $query = "SELECT COALESCE(MAX(userID), 0) AS max_userID FROM tbl_users";
    $statement =  $conn->query($query);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $maxUserID = $result['max_userID'];
    $maxUserID = $maxUserID + 25384500;
    return  $maxUserID;
}



?>