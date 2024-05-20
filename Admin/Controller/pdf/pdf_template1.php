<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    
    <title>Fatura</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
    
    *{
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    body {
        margin-top: 20px;
        background: #fff;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
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
                                <h3 class="marginright">FATURA-1234578</h3>
                                <span class="marginright">14 Eylül 2014</span>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xs-4 from">
                                <p class="lead marginbottom">Kimden :</p>
                                <p>Katsis İşletme A.Ş.</p>
                            </div>
                            <div class="col-xs-4 to">
                            </div>
                            <div class="col-xs-4  payment-details">
                            <p class="lead marginbottom">Kime :</p>
                                <p>Celal Yılmaz</p>
                            </div>
                        </div>
                        <div class="row table-row">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width:5%">#</th>
                                        <th class="text-left" style="width:75%">Açıklama</th>
                                        <th class="text-right" style="width:25%">Fiyat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td>Flatter Theme</td>
                                        <td class="text-right">180 TL</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">2</td>
                                        <td>Flat Icons</td>
                                        <td class="text-right">254 TL</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">3</td>
                                        <td>Wordpress version</td>
                                        <td class="text-right">285 TL</td>
                                    </tr>
                                    <tr class="last-row">
                                        <td class="text-center">4</td>
                                        <td>Server Deployment</td>
                                        <td class="text-right">300 TL</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 margintop">
                                <p class="lead marginbottom">Durum : ÖDENDİ</p>
                            </div>
                            <div class="col-xs-6 text-right pull-right invoice-total">
                                
                                <p>Toplam : $991 </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    


    </script>
</body>

</html>