<?php

$maliye_id = $_GET["temp"];

$sql = "
SELECT 
    tbl_maliye.*, 
    tbl_kategori.kategori_adi,
    tbl_tahsilat.*,
    tbl_apartman.apartman_name,
    tbl_users.*,  
    tbl_daireler.*,
    tbl_blok.blok_adi as blokAd,
    user_with_role_1.userName as user_name 
FROM 
    tbl_maliye 
JOIN 
    tbl_kategori ON tbl_maliye.kategori_id = tbl_kategori.kategori_id
JOIN 
    tbl_apartman ON tbl_maliye.apartman_id = tbl_apartman.apartman_id
JOIN 
    tbl_users ON tbl_maliye.user_id = tbl_users.userID  
JOIN 
    tbl_daireler ON tbl_maliye.daire_id = tbl_daireler.daire_id
JOIN 
    tbl_blok ON tbl_daireler.blok_adi = tbl_blok.blok_id
LEFT JOIN 
    tbl_tahsilat ON tbl_maliye.maliye_id = tbl_tahsilat.maliye_id
JOIN 
    tbl_users as user_with_role_1  -- İkinci tbl_users JOIN, alias kullanılarak
    ON tbl_maliye.apartman_id = user_with_role_1.apartman_id
    AND user_with_role_1.rol = 1
WHERE 
    tbl_maliye.maliye_id = :maliye_id;
";


$stmt = $conn->prepare($sql);
$stmt->bindParam(':maliye_id', $maliye_id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$dateTime = new DateTime($result[0]['odeme_tarih']);

// Gün ve ayı al
$day = $dateTime->format('d');
$month = $dateTime->format('m');
$ftrid = $maliye_id.$month.$day;

$stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_makbuz WHERE makbuz_index = :makbuz_index");
    $stmt->bindParam(':makbuz_index', $ftrid);
    $stmt->execute();

    // Eğer makbuz_index değeri daha önce eklenmemişse veriyi ekleyin
    if ($stmt->fetchColumn() == 0) {
        $stmt = $conn->prepare("INSERT INTO tbl_makbuz (makbuz_index, maliye_id) VALUES (:makbuz_index, :maliye_id)");
        $stmt->bindParam(':makbuz_index', $ftrid);
        $stmt->bindParam(':maliye_id', $maliye_id);
        $stmt->execute();
    }




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    
    <title>Fatura</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
    
    *{
        font-family: 'DejaVu Sans' , ;
    }
    body {
        margin-top: 20px;
        background: #fff;
    }

    /*Invoice*/
    .invoice .top-left {
        font-size: 65px;
        color: #3ba0ff;
    }

    .table {
        border: 1px solid #ddd;
    }

    .invoice .top-right {
        text-align: right;
        padding-right: 20px;
    }

    .invoice .table-row {
        margin-left: -15px;
        margin-right: -15px;
        margin-top: 25px;
    }

    .invoice .payment-info {
        font-weight: 500;
    }

    .invoice .table-row .table>thead {
        border-top: 1px solid #ddd;
    }

    .invoice .table-row .table>thead>tr>th {
        border-bottom: none;
    }

    .invoice .table>tbody>tr>td {
        padding: 8px 20px;
    }

    .invoice .invoice-total {
        margin-right: -10px;
        font-size: 16px;
    }

    .invoice .last-row {
        border-bottom: 1px solid #ddd;
    }

    .invoice-ribbon {
        width: 85px;
        height: 88px;
        overflow: hidden;
        position: absolute;
        top: -1px;
        right: 14px;
    }

    .ribbon-inner {
        text-align: center;
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        -o-transform: rotate(45deg);
        position: relative;
        padding: 7px 0;
        left: -5px;
        top: 11px;
        width: 120px;
        background-color: #66c591;
        font-size: 15px;
        color: #fff;
    }

    .ribbon-inner:before,
    .ribbon-inner:after {
        content: "";
        position: absolute;
    }

    .ribbon-inner:before {
        left: 0;
    }

    .ribbon-inner:after {
        right: 0;
    }

    @media(max-width:575px) {

        .invoice .top-left,
        .invoice .top-right,
        .invoice .payment-details {
            text-align: center;
        }

        .invoice .from,
        .invoice .to,
        .invoice .payment-details {
            float: none;
            width: 100%;
            text-align: center;
            margin-bottom: 25px;
        }

        .invoice p.lead,
        .invoice .from p.lead,
        .invoice .to p.lead,
        .invoice .payment-details p.lead {
            font-size: 22px;
        }

        .invoice .btn {
            margin-top: 10px;
        }
    }
    @media print {
        .invoice {
            width: 900px;
            height: 800px;
        }
    }
    .panel {
        border: none;
    }
    .marginbottom{
        margin-bottom:0;
    }
    </style>
</head>

<body>
    <div class="container bootstrap snippets bootdeys">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default invoice" id="invoice">
                    <div class="panel-body">
                        <div class="invoice-ribbon">
                            <div class="ribbon-inner">Ödendi</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 top-left">
                                <h1>KATSIS</h1>
                            </div>
                            <div class="col-sm-6 top-right">
                                <h3 class="marginright">#<?php echo $ftrid; ?></h3>
                                <span class="marginright"><?php echo tarihDonustur($result[0]['odeme_tarih']); ?></span>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xs-4 from">
                                <p class="lead marginbottom">Apartman:</p>
                                <p><?php echo $result[0]['apartman_name']; ?></p>
                            </div>
                            <div class="col-xs-4 to">
                            </div>
                            <div class="col-xs-4  payment-details">
                         
                            
                            <p class="lead marginbottom">Daire:</p>
                                <p><?php echo $result[0]['blokAd']; echo " Blok / No: "; 
                                echo $result[0]['daire_sayisi'] ?></p>
                            </div>
                        </div>
                        <div class="row table-row">
                        <?php
$total_tutar = 0; // Initialize total_tutar variable

?>

<table class="table table-striped">
    <thead>
        <tr>
            <th class="text-center" style="width:5%">#</th>
            <th class="text-left" style="width:60%">Açıklama</th>
            <th class="text-left" style="width:20%">Kategori</th>
            <th class="text-right" style="width:20%">Fiyat</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $t = 1;
        foreach ($result as $row) {
            $total_tutar += $row['tutar'];
        ?>
            <tr>
                <td class="text-center"><?php echo $t; ?></td>
                <td><?php echo $row['aciklama']; ?></td>
                <td><?php echo $row['kategori_adi']; ?></td>
                <td class="text-right"><?php echo duzenleSayi($row['tutar']); ?></td>
            </tr>
        <?php
            $t += 1;
        }
        ?>
    </tbody>
</table>
</div>
<div class="row">
    <div class="col-xs-6 text-right pull-right invoice-total">
        <p class="lead">Toplam: <?php echo duzenleSayi($total_tutar); ?></p> <!-- Display the total_tutar -->
    </div>
</div>
<hr>
                        <div class="row">
                        <div class="col-xs-4  payment-details">
                            <p class="lead marginbottom">Yönetici:</p>
                                <p><?php echo $result[0]['user_name']; ?></p>
                            
                          
                            </div>
                            <div class="col-xs-4 to">
                            </div>
                            <div class="col-xs-4  payment-details">
                            <p class="lead marginbottom">Daire Sakini:</p>
                                <p><?php echo $result[0]['userName']; ?></p>
                            
                          
                            </div>
                        </div>


    </script>
</body>

</html>