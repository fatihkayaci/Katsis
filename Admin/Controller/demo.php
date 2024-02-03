<?php
include("../../DB/dbconfig.php");

try {
    session_start();

    $durum = $_POST['durum'];
    $lastID = $_SESSION['lastID'];
    //$sql = "UPDATE tbl_daireler SET kiraciID = :optionsBlok";

    if ($durum == "kiracı") {
        $sql  ="UPDATE tbl_daireler
            SET kiraciID = (SELECT userID FROM tbl_users WHERE userID = $lastID)
            WHERE daire_id = 114";
    } else if ($durum == "katmaliki") {
        $sql  ="UPDATE tbl_daireler
            SET katmalikiID = (SELECT userID FROM tbl_users WHERE userID = $lastID)
            WHERE daire_id = 114";
    }
    
    // PDO sorgusunu hazırla ve çalıştır
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    echo 1;
} catch (PDOException $e) {
    echo $e->getMessage(); // Hata mesajını ekrana yazdır
}
?>
