<?php
require '../../../vendor/autoload.php';


// Dompdf ad alanını referans edin
use Dompdf\Dompdf;
use Dompdf\Options;

ob_start();
require 'pdf_template1.php';
$temp =  ob_get_clean();

// Dompdf sınıfını başlatın
$options = new Options();
$options->set('isRemoteEnabled', true); // Eğer uzaktaki dosyaları kullanacaksanız bunu etkinleştirin
$dompdf = new Dompdf($options);

// HTML içeriğini yükleyin
$dompdf->loadHtml($temp);

// Kağıt boyutunu ve yönünü ayarlayın (İsteğe bağlı)
$dompdf->setPaper('A4', 'portrait');

// HTML içeriğini PDF olarak render edin
$dompdf->render();

// Oluşturulan PDF'yi tarayıcıda görüntüleyin
$dompdf->stream("out.pdf", array("Attachment" => false));
?>
