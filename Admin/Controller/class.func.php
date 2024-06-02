<?php
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
function formatDatetime($datetime_str) {
    // Verilen tarihi DateTime nesnesine dönüştür
    $datetime = new DateTime($datetime_str);
    
    // İstenen formata dönüştür
    $formatted_date = $datetime->format('d F Y, H:i');
    
    // Ay ismini Türkçe'ye çevir
    $turkish_months = [
        'January' => 'Ocak',
        'February' => 'Şubat',
        'March' => 'Mart',
        'April' => 'Nisan',
        'May' => 'Mayıs',
        'June' => 'Haziran',
        'July' => 'Temmuz',
        'August' => 'Ağustos',
        'September' => 'Eylül',
        'October' => 'Ekim',
        'November' => 'Kasım',
        'December' => 'Aralık'
    ];
    
    // İngilizce ay ismini Türkçe'ye çevir
    foreach ($turkish_months as $english => $turkish) {
        $formatted_date = str_replace($english, $turkish, $formatted_date);
    }
    
    return $formatted_date;
}
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



function ZamanControl($bugun, $hedefTarih) {
    $bugunTarih = new DateTime($bugun);
    $hedefTarih = new DateTime($hedefTarih);
    
    // İki tarih arasındaki farkı hesapla
    $fark = $bugunTarih->diff($hedefTarih);
    
    // Hedef tarih bugünden önce ise
    if ($hedefTarih < $bugunTarih) {
        return 1;
    }
    // Hedef tarih bugünden sonra ise
    elseif ($hedefTarih > $bugunTarih) {
        return  0;
    }
    // Hedef tarih bugünse
    else {
        return 0;
    }
}


?>