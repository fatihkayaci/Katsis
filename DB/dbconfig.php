<?php
$host = "185.92.2.129";
$db_name = "katsis";
$username = "roott";
$password = "LnHgM5o-0WtltVCH";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     
} catch (PDOException $e) {
    
}
?>