    <?php
    // PhpSpreadsheet kütüphanesini dahil et
    session_start();
    include ("../../DB/dbconfig.php");
    require '../../vendor/autoload.php'; // PhpSpreadsheet kütüphanesi
    require_once 'class.func.php';

    use PhpOffice\PhpSpreadsheet\IOFactory;
    // Excel'den verileri yükleme işlemi
    if (isset($_FILES['excel_file']['name'])) {
        $file_name = $_FILES['excel_file']['name'];
        $file_tmp = $_FILES['excel_file']['tmp_name'];
        $file_type = $_FILES['excel_file']['type'];
        
        if ($file_type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
            $reader = IOFactory::createReader('Xlsx');
            $spreadsheet = $reader->load($file_tmp);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            
            // İlk satırı atlayın
            array_shift($sheetData);
            $lastUserId=0;
            // Excel'den okunan verileri veritabanına ekleyin
            foreach ($sheetData as $row) {
                if (empty($row['D'])) {
                    continue; // Tam ad doluysa, kayıt işlemi yapmadan sonraki adıma geç
                }
                $t = "Y";
                $rol = 3;
                $popup = 0;
                $userPass = randomPassword();
                $hashedPassword = base64_encode($userPass);
                $userNO = generateUniqueUserID($conn);

                $blok_adi = $row['A'];
                $daireNo = $row['B'];
                $durum = strtolower(trim($row['C']));
                $userName = $row['D'];
                $tc = $row['E'];
                $phoneNumber = $row['F'];
                $userEmail = $row['G'];
                $plate = $row['H'];
                $gender = $row['I'];
                $insertSql = "INSERT INTO tbl_users (durum, userStatus, rol, popup, user_no, userPass, userName, tc, phoneNumber, userEmail, plate, gender, apartman_id) VALUES 
                    (:durum, :userStatus, :rol, :popup, :user_no, :userPass, :userName, :tc, :phoneNumber, :userEmail, :plate, :gender, :apartman_id)";
                $insertStmt = $conn->prepare($insertSql);
                $insertStmt->bindParam(':durum', $durum);
                $insertStmt->bindParam(':userName', $userName);
                $insertStmt->bindParam(':tc', $tc);
                $insertStmt->bindParam(':phoneNumber', $phoneNumber);
                $insertStmt->bindParam(':userEmail', $userEmail);
                $insertStmt->bindParam(':plate', $plate);
                $insertStmt->bindParam(':gender', $gender);

                $insertStmt->bindParam(':userStatus', $t);
                $insertStmt->bindParam(':apartman_id', $_SESSION["apartID"], PDO::PARAM_INT);
                $insertStmt->bindParam(':rol', $rol);
                $insertStmt->bindParam(':popup', $popup);
                $insertStmt->bindParam(':user_no', $userNO);
                $insertStmt->bindParam(':userPass', $hashedPassword);
                $insertStmt->execute();
                        
                // Son eklenen kullanıcının ID'sini alın
                $lastUserId = $conn->lastInsertId();

                // Önce diğer tabloyu güncelleyin
                $columnName = (strtolower(trim($durum)) == "kiracı") ? "kiraciID" : "katMalikiID";
                
                $updateSql = "UPDATE tbl_daireler AS d
                INNER JOIN tbl_blok AS b ON d.blok_adi = b.blok_id
                SET d.$columnName = :userID
                WHERE d.daire_sayisi = :daire 
                  AND b.blok_adi = :blok
                  AND d.apartman_id = :apartID
                  AND d.$columnName IS NULL";

                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bindParam(':daire', $daireNo);
                $updateStmt->bindParam(':blok', $blok_adi);
                $updateStmt->bindParam(':apartID', $_SESSION["apartID"], PDO::PARAM_INT);
                $updateStmt->bindParam(':userID', $lastUserId); // Son eklenen kullanıcı ID'sini kullanın
                $updateStmt->execute();
            }
            echo $lastUserId;
            echo "Veriler başarıyla veritabanına kaydedildi.";
        } else {
            echo "Geçersiz dosya türü. Lütfen bir Excel dosyası yükleyin.";
        }
    }

    ?>
