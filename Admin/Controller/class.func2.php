<?php  
function tarihDonustur($tarih) {
    // Tarihi DateTime nesnesi olarak oluştur
    $date = DateTime::createFromFormat('Y-m-d', $tarih);
    
    // Tarihin geçerli olup olmadığını kontrol et
    if (!$date) {
        return "Geçersiz Tarih"; // Geçersiz tarih formatı veya diğer hata durumları için bir mesaj döndür
    }

    // Ayların Türkçe isimleri
    $aylar = array(
        1 => 'Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 
        'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'
    );
    
    // Gün, Ay ve Yıl değerlerini al
    $gun = $date->format('d');
    $ay = (int)$date->format('m');
    $yil = $date->format('Y');
    
    // Yeni formatta tarihi oluştur
    $yeniTarih = $gun . ' ' . $aylar[$ay] . ' ' . $yil;
    
    return $yeniTarih;
}


function duzenleSayi($sayi) {
    // Sayıda nokta veya virgül var mı kontrol et
    if (strpos($sayi, '.') !== false || strpos($sayi, ',') !== false) {
        // Nokta veya virgül varsa, onları virgül ile değiştir
        $sayi = str_replace(array('.', ','), ',', $sayi);
        
        // Sayının ondalık kısmı var mı kontrol et
        if (strpos($sayi, ',') !== false) {
            // Ondalık kısmı al
            $ondalik = explode(',', $sayi)[1];
            
            // Eğer ondalık kısmı bir haneli ise, bir sıfır ekle
            if (strlen($ondalik) == 1) {
                $sayi .= '0';
            }
        }
    } else {
        // Hiç nokta veya virgül yoksa, virgül ekle
        $sayi .= ',00';
    }
    
    return $sayi;
}


function ZamanFarki($bugun, $hedefTarih) {
    $bugunTarih = new DateTime($bugun);
    $hedefTarih = new DateTime($hedefTarih);
    
    // İki tarih arasındaki farkı hesapla
    $fark = $bugunTarih->diff($hedefTarih);
    
    // Hedef tarih bugünden önce ise
    if ($hedefTarih < $bugunTarih) {
        return $fark->days. " Gün Geçti";
    }
    // Hedef tarih bugünden sonra ise
    elseif ($hedefTarih > $bugunTarih) {
        return  $fark->days . " Gün Sonra";
    }
    // Hedef tarih bugünse
    else {
        return "Bugün";
    }
}



?>