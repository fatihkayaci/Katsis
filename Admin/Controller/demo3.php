<?php
include ("../../DB/dbconfig.php");

try {
    session_start();
    $userIds = $_SESSION['userIds'];
    $blok_listesi = $_SESSION['blok_listesi'];
    $durum_listesi = $_SESSION['durum_listesi'];

    foreach ($durum_listesi as $i => $durum) {
        $columnName = ($durum == "kiracı") ? "kiraciID" : "katMalikiID";
        // Blok ve daireyi ayır
        $parcalanmis = explode("/", $blok_listesi[$i]);
        $blok = $parcalanmis[0];
        $daire = $parcalanmis[1];

        $sql = "UPDATE tbl_daireler AS d
                INNER JOIN tbl_blok AS b ON d.blok_adi = b.blok_id
                SET d.$columnName = :userID
                WHERE d.daire_sayisi = :daire 
                AND b.blok_adi = :blok
                AND d.apartman_id = :apartID
                AND d.$columnName IS NULL"; // Eski kullanıcıyı null yapmak yerine direkt yeni kullanıcıyı atayalım

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userID', $userIds[$i], PDO::PARAM_INT); // $userIds dizisinden ilgili kullanıcıyı al
        $stmt->bindParam(':daire', $daire, PDO::PARAM_STR); // Daireyi al
        $stmt->bindParam(':blok', $blok, PDO::PARAM_STR); // Bloku al
        $stmt->bindParam(':apartID', $_SESSION["apartID"], PDO::PARAM_INT);
        $stmt->execute();
    }

    echo "success";
} catch (PDOException $e) {
    echo "Hata oluştu: " . $e->getMessage(); // Hata mesajını ekrana yazdır
}
?>
