<?php
$host = "45.10.151.41";
$db_name = "katsis2";
$username = "roott";
$password = "PW2jnY5T8v6eHWRc";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     
} catch (PDOException $e) {
    
}
?>