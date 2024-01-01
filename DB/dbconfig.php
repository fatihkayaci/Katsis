<?php
$host = "45.10.151.41";
$db_name = "katsis";
$username = "root";
$password = "ELlggUcQi62HjoAZ";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     
} catch (PDOException $e) {
    
}
?>