<?php 
 require_once "Controller/class.func.php"; 
$idapartman =$_SESSION["apartID"];
?>
<input type="hidden" id="hiddenDaireID2" value=<?php echo $idapartman?> />

<?php
$sql = "SELECT * FROM tbl_users WHERE apartman_id = " . $idapartman. " AND rol = 3";
$stmt = $conn->prepare($sql);
$stmt->execute();

// Sonuç kümesinin satır sayısını kontrol etme
$UserList = $stmt->fetchAll(PDO::FETCH_ASSOC);
$listt=[];
foreach($UserList as $list){
    $listt[$list['userID']] = $list['userName'];
}
try {

$sql = "SELECT * FROM tbl_blok WHERE apartman_idd = " . $idapartman;
$stmt = $conn->prepare($sql);
$stmt->execute();

$blokList=[];
$blokList = $stmt->fetchAll(PDO::FETCH_ASSOC);

}catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}

try {
    
    $sql = "SELECT * FROM tbl_grup WHERE apartman_id = " . $idapartman;
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $grupList=[];
    $grupList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    }catch (PDOException $e) {
        echo "Bağlantı hatası: " . $e->getMessage();
    }



try {
    $sql = "SELECT d.*, 
    ROUND(COALESCE(SUM(CASE WHEN mk.maliye_turu = 1 THEN mk.borc_miktar ELSE 0 END), 0), 2) AS toplam_kira_borcu,
    ROUND(COALESCE(SUM(CASE WHEN mm.maliye_turu = 1 THEN mm.borc_miktar ELSE 0 END), 0), 2) AS toplam_mal_borcu
FROM tbl_daireler AS d
LEFT JOIN (SELECT daire_id, user_id, apartman_id, SUM(borc_miktar) AS borc_miktar, maliye_turu
        FROM tbl_maliye
        WHERE maliye_turu = 1
        GROUP BY daire_id, user_id, apartman_id, maliye_turu) AS mk ON d.daire_id = mk.daire_id AND d.kiraciID = mk.user_id AND d.apartman_id = mk.apartman_id
LEFT JOIN (SELECT daire_id, user_id, apartman_id, SUM(borc_miktar) AS borc_miktar, maliye_turu
        FROM tbl_maliye
        WHERE maliye_turu = 1
        GROUP BY daire_id, user_id, apartman_id, maliye_turu) AS mm ON d.daire_id = mm.daire_id AND d.katMalikiID = mm.user_id AND d.apartman_id = mm.apartman_id
WHERE d.apartman_id = " . $idapartman . " 
GROUP BY d.daire_id
ORDER BY d.blok_adi ASC, d.daire_sayisi ASC";











    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Sonuç kümesinin satır sayısını kontrol etme
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
    ?>

<div class="cener-table">

    <div class="input-group-div">

        <div class="input-group1">
            <button class="btn-custom-outline bolumClr" onclick="openPopupBlok()">Bloklar</button>
            <button class="btn-custom-outline bolumClr" onclick="openPopupDaire()">Daire Ekle</button>

        </div>

        <div class="input-group1">
            <button class="topluGuncelle btn-custom-outline bcoc3" id="guncelleButton" style="display: none;"
                onclick="openTopluPopup()">Toplu Ekle/Güncelle</button>
            <button class="topluSil btn-custom-outline bcoc4" id="silButton"
                onclick="daireSil(<?php echo $idapartman; ?>)" style="display: none;">Sil</button>


            <div class="search-box">
                <i class="fas fa-search search-icon" aria-hidden="true"></i>
                <input type="text" id="searchValue" class="search-input bolumSrch" placeholder="Arama..." onkeyup="filtrele()">
            </div>
        </div>
    </div>






    <!-- Popup blok eklemek için-->
    <div id="popupBlokEkle" class="form-popup">

        <form id="userFormBlok" class="login-form bolumInpClr">

            <h2 class="form-signin-heading">Bloklar</h2>

            <div class="row">

                <div class="col-blok w-70">
                    <input class="input min-w mb-0" type="text" id="blokInput" maxLength="5" required="" />
                    <label for="blokInput">Blok Ekle :</label>
                </div>

                <div class="col-blok w-30">
                    <button type="button" class="btn-custom-daire bolumClr ekle-btn blok-btn" id="saveButton"
                        onclick="saveBlok()">Ekle</button>
                </div>
            </div>

            <hr class="horizontal mt-0 dark w-100">

            <table class="users-table table-blok">
                <tr class="users-table-info">
                    <th>Blok Adı </th>
                    <th>Daire Sayısı </th>
                    <th></th>
                    <th></th>
                </tr>
                <tr id="mainTr" style="display:none;">
                    <?php  
                 $blokIdMapping = [];
                foreach ($blokList as $s ){
                     $blokIdMapping[$s['blok_id']] = $s['blok_adi'];
                        echo '
                        <tr class="git-ac" id="blk-'.$s["blok_id"].'">
                            <td class="blokAdi">'.$s["blok_adi"].'</td>
                            <td>'.$s["daire_sayisi"].'</td>
                            <td>  
                                <span class="blok-ico color-red" onclick="deleteBlok('.$s["blok_id"].')"><i class="fa-solid fa-trash"></i></span>
                            </td> 
                            <td>
                                <span class="blok-ico" onclick="editBlok('.$s["blok_id"].')"><i class="fa-solid fa-pen"></i></span> 
                            </td>
                        </tr>
                        ';

                  }  ?>

                </tr>

            </table>

            <hr class="horizontal dark w-100">

            <div class="row row-btn">
                <button type="button" class="btn-custom-close w-100 me-0" onclick="closePopupBlok()">Kapat</button>
            </div>

        </form>

    </div>







    <hr class="horizontal dark mb-1 w-100">
<div class="table-overflow">
    <table id="table" class="users-table">
        <thead>
            <tr class="users-table-info">
                <th class="check-style">
                    <input id="mainCheckbox" type="checkbox" onclick="toggleAll(this)" />
                    <label for="mainCheckbox" class="check">
                        <svg width="18px" height="18px" viewBox="0 0 18 18">
                            <path
                                d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z">
                            </path>
                            <polyline points="1 9 7 14 15 4"></polyline>
                        </svg>
                    </label>
                </th>
                <th onclick="sortTable(1)">Blok Adı <i id="icon-table1" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(2)">Kapı No <i id="icon-table2" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(3)">Kiracı <i id="icon-table3" class="fa-solid fa-sort-down"></i></th>
                <th class="ayar-i" onclick="sortTable(4)"><i id="icon-table4" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(5)">Kat Maliki <i id="icon-table5" class="fa-solid fa-sort-down"></i></th>
                <th class="ayar-i" onclick="sortTable(6)"><i id="icon-table6" class="fa-solid fa-sort-down"></i></th>
                <th class="ayar-i"></th>
            </tr>
        </thead>

        <?php

        foreach ($result as $row) {

        ?>

        <tbody>

            <tr id=<?php echo $row["daire_id"]; ?> id="tr-<?php echo $row["daire_id"]; ?>" class="git-ac">

                <td data-title="Seç" class="check-style">
                    <input id="check-<?php echo $row["daire_id"]; ?>" data-userid="<?php echo $row["blok_adi"]; ?>"
                        class="check1" type="checkbox" onclick="toggleMainCheckbox(<?php echo $row['daire_id']; ?>)" />
                    <label for="check-<?php echo $row["daire_id"]; ?>" class="check">
                        <svg width="18px" height="18px" viewBox="0 0 18 18">
                            <path
                                d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z">
                            </path>
                            <polyline points="1 9 7 14 15 4"></polyline>
                        </svg>
                    </label>
                </td>

                <td data-title="Blok Adı" class="table_td"><?php echo $blokIdMapping[$row["blok_adi"]];  ?></td>

                <td data-title="Kapı No" class="table_td"><?php echo $row["daire_sayisi"]; ?></td>

                <?php
                   if($row["kiraciID"]==null) {
                  echo ' <td data-title="0"  ><button type="button" class="table-a tca1" onclick="openPopup('.$row["daire_id"].',0)">Kiracı Ekle + </button></td>';

                   }else{
                    echo ' <td data-title="0"  class="table_td">'.$listt[$row["kiraciID"]].' </td>  '; 
                   }
                   echo ' <td data-title="Bakiye"  class="table_td">'.duzenleSayi($row["toplam_kira_borcu"]).' ₺</td> ';
                   if($row["katMalikiID"]==null) {
                    echo '<td data-title="1"  ><button type="button" class="table-a tca2" onclick="openPopup('.$row["daire_id"].',1)">Kat Maliki Ekle + </button></td>
                    ';
  
                    }else{
                     echo ' <td data-title="1"  class="table_td">'.$listt[$row["katMalikiID"]].' </td>  '; 
                    }
                    echo ' <td data-title="Bakiye"  class="table_td">'.duzenleSayi($row["toplam_mal_borcu"]).' ₺</td> ';
                ?>



                <td data-title="Seçenekler">
                    <li class="nav-item dropdown pe-1 d-flex settings">
                        <a href="javascript:;" class="nav-link text-body nav-link font-weight-bold mb-0"
                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end1 ayar-1 px-1 margin-10"
                            aria-labelledby="dropdownMenuButton">
                            <li class="mb-1">
                                <a class="dropdown-item border-radius-md" href="">
                                    <div class="d-flex">
                                        <div class="my-auto">
                                            <i class="fa-solid fa-pen i-color me-3"></i>
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-normal mb-1">
                                                <span class="font-weight-bold">Düzenle</span>
                                            </h6>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="mb-0">
                                <a class="dropdown-item border-radius-md" href="">
                                    <div class="d-flex">
                                        <div class="my-auto">
                                            <i class="fa-solid fa-trash i-color me-3"></i>
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-normal mb-0">
                                                <span class="font-weight-bold">Sil</span>
                                            </h6>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>

    <hr class="horizontal dark mb-0 w-100">

    <div class="input-group-div">

        <div class="input-group1">

            <div class="custom-select">
                <select>
                    <option selected value="1">10</option>
                    <option value="2">20</option>
                    <option value="3">50</option>
                    <option value="4">100</option>
                </select>
            </div>

            <p class="adet-txt">Adet Veri Gösteriliyor</p>

        </div>

        <div class="input-group1">

            <ul class="pagination">
                <a href="#" class="pagination-arrow arrow-left">
                    <i class="fa-solid fa-angle-left"></i>
                </a>
                <a href="#" class="pagination-number">1</a>
                <a href="#" class="pagination-number">2</a>
                <a href="#" class="pagination-number current-number">3</a>
                <a href="#" class="pagination-number">4</a>
                <a href="#" class="pagination-number">5</a>
                <a href="#" class="pagination-arrow arrow-right">
                    <i class="fa-solid fa-angle-right"></i>
                </a>
            </ul>

        </div>

    </div>

</div>
<?php
    } else {
?>

<div class="cener-table">

    <div class="input-group-div">

        <div class="input-group1">
            <button class="btn-custom-outline bolumClr" onclick="openPopupBlok()">Bloklar</button>
            <button class="btn-custom-outline bolumClr" onclick="openPopupDaire()">Daire Ekle</button>

        </div>

        <div class="input-group1">
            <button class="topluGuncelle btn-custom-outline bcoc3" id="guncelleButton" style="display: none;"
                onclick="openTopluPopup()">Toplu Ekle/Güncelle</button>
            <button class="topluSil btn-custom-outline bcoc4" id="silButton"
                onclick="daireSil(<?php echo $idapartman; ?>)" style="display: none;">Sil</button>


            <div class="search-box">
                <i class="fas fa-search search-icon" aria-hidden="true"></i>
                <input type="text" id="searchValue" class="search-input bolumSrch" placeholder="Arama..." onkeyup="filtrele()">
            </div>
        </div>
    </div>






    <!-- Popup blok eklemek için-->
    <div id="popupBlokEkle" class="form-popup">

        <form id="userFormBlok" class="login-form bolumInpClr">

            <h2 class="form-signin-heading">Bloklar</h2>

            <div class="row">

                <div class="col-blok w-70">
                    <input class="input min-w mb-0" type="text" id="blokInput" maxLength="5" required="" />
                    <label for="blokInput">Blok Ekle :</label>
                </div>

                <div class="col-blok w-30">
                    <button type="button" class="btn-custom-daire bolumClr ekle-btn blok-btn" id="saveButton"
                        onclick="saveBlok()">Ekle</button>
                </div>
            </div>

            <hr class="horizontal mt-0 dark w-100">

            <table class="users-table table-blok">
                <tr class="users-table-info">
                    <th>Blok Adı </th>
                    <th>Daire Sayısı </th>
                    <th></th>
                    <th></th>
                </tr>
                <tr id="mainTr">
                    <?php  
                 $blokIdMapping = [];
                foreach ($blokList as $s ){
                     $blokIdMapping[$s['blok_id']] = $s['blok_adi'];
                        echo '
                        <tr class="git-ac" id="blk-'.$s["blok_id"].'">
                            <td class="blokAdi">'.$s["blok_adi"].'</td>
                            <td>'.$s["daire_sayisi"].'</td>
                            <td>  
                                <span class="blok-ico color-red" onclick="deleteBlok('.$s["blok_id"].')"><i class="fa-solid fa-trash"></i></span>
                            </td> 
                            <td>
                                <span class="blok-ico" onclick="editBlok('.$s["blok_id"].')"><i class="fa-solid fa-pen"></i></span> 
                            </td>
                        </tr>
                        ';

                  }  ?>

                </tr>

            </table>

            <hr class="horizontal dark w-100">

            <div class="row row-btn">
                <button type="button" class="btn-custom-close w-100 me-0" onclick="closePopupBlok()">Kapat</button>
            </div>

        </form>

    </div>







    <hr class="horizontal dark mb-1 w-100">
<div class="table-overflow">
    <table id="table" class="users-table">
        <thead>
            <tr class="users-table-info">
                <th class="check-style">

                </th>
                <th onclick="sortTable(1)">Blok Adı <i id="icon-table1" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(2)">Kapı No <i id="icon-table2" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(3)">Kiracı <i id="icon-table3" class="fa-solid fa-sort-down"></i></th>
                <th class="ayar-i" onclick="sortTable(4)"><i id="icon-table4" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(5)">Kat Maliki <i id="icon-table5" class="fa-solid fa-sort-down"></i></th>
                <th class="ayar-i" onclick="sortTable(6)"><i id="icon-table6" class="fa-solid fa-sort-down"></i></th>
                <th class="ayar-i"></th>
            </tr>
        </thead>


        <tbody>
            <tr>
                <td>Veri Bulunamamaktadır</td>
            </tr>
        </tbody>
    </table>
</div>
    <hr class="horizontal dark mb-0 w-100">

    <div class="input-group-div">

        <div class="input-group1">

            <div class="custom-select">
                <select>
                    <option selected value="1">10</option>
                    <option value="2">20</option>
                    <option value="3">50</option>
                    <option value="4">100</option>
                </select>
            </div>

            <p class="adet-txt">Adet Veri Gösteriliyor</p>

        </div>

        <div class="input-group1">

            <ul class="pagination">
                <a href="#" class="pagination-arrow arrow-left">
                    <i class="fa-solid fa-angle-left"></i>
                </a>
                <a href="#" class="pagination-number">1</a>
                <a href="#" class="pagination-number">2</a>
                <a href="#" class="pagination-number current-number">3</a>
                <a href="#" class="pagination-number">4</a>
                <a href="#" class="pagination-number">5</a>
                <a href="#" class="pagination-arrow arrow-right">
                    <i class="fa-solid fa-angle-right"></i>
                </a>
            </ul>

        </div>

    </div>

</div>

<?php
    }
} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
?>


<!-- Popup kiracı ve kat maliki eklemek için-->
<div id="popup2" class="form-popup">

    <form id="userForm" class="login-form bolumInpClr">

        <h2 class="form-signin-heading" id="pop-head"></h2>

        <input type="hidden" id="hiddenDaireID" />
        <input type="hidden" id="turDaire" />

        <div class="row">
            <div class="col-md-12 col-btn">
                <div class="select-div">


                    <div class="dropdown-nereden">
                        <div class="group">
                            <input class="search-selectx input" data-user-id="" type="text" list="Users" id="userInput"
                                required="" />
                            <label class="selectx-label" for="userInput">Kullanıcılar :</label>
                        </div>

                        <div class="dropdown-content-nereden searchInput-btn" id="userInputDP">
                            <div class="dropdown-content-inside-nereden bolumPopup">
                                <input type="text" id="searchInput3" placeholder="Ara...">

                                <?php 
                            foreach($UserList as $user){
                             echo '                                        
                                <button  data-user-id="' . $user['userID'] . '">' . $user['userName'] . '</button>';
                            }
                        ?>
                            </div>

                        </div>

                    </div>









                    <ul class="value-listx" id="userDrop">
                        <?php 
                            foreach($UserList as $user){
                             echo '                                        
                                <li class="li-select" data-user-id="' . $user['userID'] . '">' . $user['userName'] . '</li>';
                            }
                        ?>
                    </ul>










                </div>
            </div>
            <div class="col-md-12 col-btn">
                <input class="input" type="date" value="<?php echo date('Y-m-d'); ?>" id="dateInput" required="" />
                <label id="label_tarih" for="dateInput">1</label>
            </div>

        </div>

        <hr class="horizontal dark w-100">

        <div class="row row-btn">
            <button type="button" class="btn-custom-close" onclick="closePopup()">Kapat</button>
            <button type="button" class="btn-custom bcoc1" id="saveButton" onclick="save()">Kaydet</button>
        </div>

    </form>

</div>


<!-- Popup daire eklemek için-->
<div id="popupDaireEkle" class="form-popup">

    <form id="userFormDaire" class="login-form bolumInpClr">

        <h2 class="form-signin-heading">Daire Ekle</h2>

        <input type="hidden" id="DaireSaveID" value=<?php  echo $idapartman ?> />

        <div class="row">
            <div class="col-md-6 col-btn">
                <input class="input" type="text" id="daireNo" onkeypress="onlyNumberKey(event)" required="" />
                <label id="daireNoLabel" for="daireNo">No : *</label>
            </div>

            <div class="col-md-6 col">
                <input class="input" type="text" id="daireKat" onkeypress="onlyNumberKey(event)" required="" />
                <label for="daireKat">Kat :</label>
            </div>



            <div class="col-md-6 col margint">
                <div class="select-div m-0">
                    <div class="dropdown-nereden">
                        <div class="group">
                            <input class="search-selectx input" data-user-id="" type="text" list="blok" id="daireBlok"
                                required="" />
                            <label class="selectx-label" for="daireBlok">Blok: *</label>
                        </div>

                        <div class="dropdown-content-nereden searchInput-btn" id="daireBlokDP">
                            <div class="dropdown-content-inside-nereden bolumPopup">
                                <input type="text" id="searchInput" placeholder="Ara...">

                                <?php 
                            foreach($blokList as $s){
                             echo '                                        
                                <button data-user-id="' . $s['blok_id'] . '">' . $s['blok_adi'] . '</button>';
                            }
                        ?>
                            </div>

                        </div>

                    </div>
                </div>
            </div>










            <div class="col-md-6 col margint">
                <div class="select-div m-0">
                    <div class="dropdown-nereden">
                        <div class="group">
                            <input class="search-selectx input" data-user-id="" type="text" list="dairegrup"
                                id="daireGrup" required="" />
                            <label class="selectx-label" for="daireGrup">Daire Grubu: *</label>
                        </div>

                        <div class="dropdown-content-nereden searchInput-btn" id="daireGrupDP">
                            <div class="dropdown-content-inside-nereden bolumPopup">
                                <input type="text" id="searchInput2" placeholder="Ara...">

                                <?php 
                            foreach($grupList as $s){
                             echo '                                        
                                <button data-user-id="' . $s['grup_id'] . '">' . $s['grup_adi'] . '</button>';
                            }
                        ?>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-6 col">
                <input class="input" type="text" id="daireBrut" onkeypress="onlyNumberKey(event)" required="" />
                <label for="daireBrut">Brüt m² :</label>
            </div>
            <div class="col-md-6 col">
                <input class="input" type="text" id="daireNet" onkeypress="onlyNumberKey(event)" required="" />
                <label for="daireNet">Net m² :</label>
            </div>
            <div class="col-md-6 col">
                <input class="input" type="text" id="dairePay" onkeypress="onlyNumberKey(event)" required="" />
                <label for="dairePay">Arsa Payı :</label>
            </div>

        </div>

        <hr class="horizontal dark w-100">

        <div class="row row-btn">
            <button type="button" class="btn-custom-close" onclick="closePopupDaire()">Kapat</button>
            <button type="button" class="btn-custom bcoc1" id="saveButton" onclick="SaveDaire()">Kaydet</button>
        </div>

    </form>

</div>


<!-- Toplu bilgi eklemek için-->
<div id="popupTopluEkle" class="form-popup">

    <form id="userFormToplu" class="login-form bolumInpClr">

        <h2 class="form-signin-heading">Toplu Ekle/Güncelle</h2>

        <input type="hidden" id="DaireSaveID" value=<?php  echo $idapartman ?> />

        <div class="row">


            <div class="col-md-6 col">
                <input class="input" type="text" id="daireKat1" onkeypress="onlyNumberKey(event)" required="" />
                <label for="daireKat1">Kat :</label>
            </div>
            <div class="col-md-6 col">
                <div class="dropdown-nereden">
                    <div class="group">
                        <input class="search-selectx input" data-user-id="" type="text" list="Users" id="daireBlok1"
                            required="" />
                        <label class="selectx-label" for="daireBlok1">Blok :</label>
                    </div>

                    <div class="dropdown-content-nereden searchInput-btn" id="daireBlok1DP">
                        <div class="dropdown-content-inside-nereden bolumPopup">
                            <input type="text" id="searchInput-daireBlok1" placeholder="Ara...">

                            <?php 
                        foreach($blokList as $s){
                         echo '                                        
                            <button  data-user-id="' . $s['blok_id'] . '">' . $s['blok_adi'] . '</button>';
                        }
                    ?>
                        </div>

                    </div>

                </div>
            </div>

            <div class="col-md-6 col">
                <div class="dropdown-nereden">
                    <div class="group">
                        <input class="search-selectx input" data-user-id="" type="text" list="Users" id="daireGrup1"
                            required="" />
                        <label class="selectx-label" for="daireGrup1">Daire Grubu :</label>
                    </div>

                    <div class="dropdown-content-nereden searchInput-btn" id="daireGrup1DP">
                        <div class="dropdown-content-inside-nereden bolumPopup">
                            <input type="text" id="searchInput-daireGrup1" placeholder="Ara...">

                            <?php 
                        foreach ($grupList as $s ){
                         echo '                                        
                            <button  data-user-id="' . $s['grup_id'] . '">' . $s['grup_adi'] . '</button>';
                        }
                    ?>
                        </div>

                    </div>

                </div>
            </div>
            <div class="col-md-6 col">
                <input class="input" type="text" id="daireBrut1" onkeypress="onlyNumberKey(event)" required="" />
                <label for="daireBrut1">Brüt m² :</label>
            </div>
            <div class="col-md-6 col">
                <input class="input" type="text" id="daireNet1" onkeypress="onlyNumberKey(event)" required="" />
                <label for="daireNet1">Net m² :</label>
            </div>
            <div class="col-md-6 col">
                <input class="input" type="text" id="dairePay1" onkeypress="onlyNumberKey(event)" required="" />
                <label for="dairePay1">Arsa Payı :</label>
            </div>

        </div>

        <p class="form-note"><span style="color: #ff0000;"> * </span> <strong> Not: </strong> Lütfen sadece güncellemek
            istediğiniz alanlara veri giriniz. Diğer alanları doldurmanız zorunlu değildir. Sadece veri girişi yapılan
            alanlar güncellenecektir.</p>

        <hr class="horizontal dark w-100">

        <div class="row row-btn">
            <button type="button" class="btn-custom-close" onclick="closePopupToplu()">Kapat</button>
            <button type="button" class="btn-custom bcoc1" id="saveButton"
                onclick="daireGuncel(<?php echo $idapartman; ?>)">Kaydet</button>
        </div>

    </form>

</div>






<!-- =============================== -->
<script>
    window.onload = function() {
        var popupBlokEkle = document.getElementById('popupBlokEkle');
        var popupDaireEkle = document.getElementById('popupDaireEkle');
        // ESC tuşuna basıldığında popup'ı kapat
        window.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                if (popupBlokEkle.style.display === 'flex') {
                    closePopupBlok();
                } else if(popupDaireEkle.style.display === 'flex'){
                    closePopupDaire();
                }
            }
        });
    };
</script>

<!-- select input start -->

<script>
var x, i, j, l, ll, selElmnt, a, b, c;
x = document.getElementsByClassName("custom-select");
l = x.length;
for (i = 0; i < l; i++) {
    selElmnt = x[i].getElementsByTagName("select")[0];
    ll = selElmnt.length;
    a = document.createElement("DIV");
    a.setAttribute("class", "select-selected");
    a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
    x[i].appendChild(a);
    b = document.createElement("DIV");
    b.setAttribute("class", "select-items select-hide");
    for (j = 0; j < ll; j++) {
        c = document.createElement("DIV");
        c.innerHTML = selElmnt.options[j].innerHTML;
        c.addEventListener("click", function(e) {
            var y, i, k, s, h, sl, yl;
            s = this.parentNode.parentNode.getElementsByTagName("select")[0];
            sl = s.length;
            h = this.parentNode.previousSibling;
            for (i = 0; i < sl; i++) {
                if (s.options[i].innerHTML == this.innerHTML) {
                    s.selectedIndex = i;
                    h.innerHTML = this.innerHTML;
                    y = this.parentNode.getElementsByClassName("same-as-selected");
                    yl = y.length;
                    for (k = 0; k < yl; k++) {
                        y[k].removeAttribute("class");
                    }
                    this.setAttribute("class", "same-as-selected");
                    break;
                }
            }
            h.click();
        });
        b.appendChild(c);
    }
    x[i].appendChild(b);
    a.addEventListener("click", function(e) {
        e.stopPropagation();
        closeAllSelect(this);
        this.nextSibling.classList.toggle("select-hide");
        this.classList.toggle("select-arrow-active");
    });
}

function closeAllSelect(elmnt) {
    var x, y, i, xl, yl, arrNo = [];
    x = document.getElementsByClassName("select-items");
    y = document.getElementsByClassName("select-selected");
    xl = x.length;
    yl = y.length;
    for (i = 0; i < yl; i++) {
        if (elmnt == y[i]) {
            arrNo.push(i)
        } else {
            y[i].classList.remove("select-arrow-active");
        }
    }
    for (i = 0; i < xl; i++) {
        if (arrNo.indexOf(i) === -1) {
            x[i].classList.add("select-hide");
        }
    }
}
document.addEventListener("click", closeAllSelect);
</script>

<!-- select input end -->
<!-- =============================== -->

<script>
function sortTable(columnIndex) {
    const table = document.getElementById("table");
    const rows = Array.from(table.rows).slice(1);

    let isAscending = table.getAttribute('data-sort-dir') === 'desc';
    const sortedRows = rows.sort((rowA, rowB) => {
        const cellA = getCellValue(rowA.cells[columnIndex]);
        const cellB = getCellValue(rowB.cells[columnIndex]);

        if (cellA < cellB) return isAscending ? -1 : 1;
        if (cellA > cellB) return isAscending ? 1 : -1;
        return 0;
    });

    sortedRows.forEach(row => table.appendChild(row));

    table.setAttribute('data-sort-dir', isAscending ? 'asc' : 'desc');

    // Clear all icon states
    for (let i = 1; i <= 4; i++) {
        $(`#icon-table${i}`).removeClass("rotate opacity");
    }

    // Update the sorted column's icon state
    $(`#icon-table${columnIndex}`).toggleClass("rotate", !isAscending);
    $(`#icon-table${columnIndex}`).addClass("opacity");
}

function getCellValue(cell) {
    const cellValue = cell.innerText.trim();
    return isNaN(cellValue) ? cellValue.toLowerCase() : parseFloat(cellValue);
}
</script>



<script>
closePopup();

function openPopup(daire_id, tur) {
    // Belirli bir ID'ye sahip <tr> elementini seç
    var trElement = document.getElementById(daire_id);
    var label_tarih = document.getElementById("label_tarih");


    // <td> elemanlarını seç
    var tdElements = trElement.getElementsByTagName('td');

    document.getElementById("hiddenDaireID").value = daire_id;
    document.getElementById("turDaire").value = tur;


    // İlgili <td> elemanlarının içeriğini al
    var blokName = tdElements[1].innerText; // A
    var No = tdElements[2].innerText; // 1

    var head = " " + blokName + " Blok / No: " + No;
    if (tur == 0) {
        head += " (Kiracı)";
        $('#label_tarih').html("Taşınma Tarihi :");
    } else if (tur == 1) {
        head += " (Kat Maliki)";
        $('#label_tarih').html("Satın Alma Tarihi :");
    }

    $('#pop-head').html(head);


    $('#popup2').show().css('display', 'flex').delay(100).queue(function(next) {
        $('body').css('overflow', 'hidden');
        $('#popup2').css('opacity', '1');
        $('#userForm').css('opacity', '1');
        $('#userForm').css('transform', 'translateY(0)');
        next();
    });

}


function closePopup() {
    document.getElementById("userInput").value = "";
    $('#userInput').css('border-color', '#000000');
    $('#userInput').focus(function() {
        $(this).css('border-color', '#8E44AD');
    });

    $('#userForm').css('opacity', '0').css('transform', 'translateY(-180px)').delay(100).queue(function(next) {
        $('#popup2').css('opacity', '0').delay(300).queue(function(nextInner) {
            $(this).hide().css('display', 'none');
            nextInner();
            $('body').css('overflow', 'auto');
        });
        next();
    });
}

function openTopluPopup() {
    $('body').css('overflow', 'hidden');

    $('#popupTopluEkle').show().css('display', 'flex').delay(100).queue(function(next) {
        $('#popupTopluEkle').css('opacity', '1');
        $('#userFormToplu').css('opacity', '1');
        $('#userFormToplu').css('transform', 'translateY(0)');
        next();
    });

}

function openPopupDaire() {



    $('body').css('overflow', 'hidden');

    $('#popupDaireEkle').show().css('display', 'flex').delay(100).queue(function(next) {
        $('#popupDaireEkle').css('opacity', '1');
        $('#userFormDaire').css('opacity', '1');
        $('#userFormDaire').css('transform', 'translateY(0)');
        next();
    });
}

function openPopupBlok() {
    $('body').css('overflow', 'hidden');

    $('#popupBlokEkle').show().css('display', 'flex').delay(100).queue(function(next) {
        $('#popupBlokEkle').css('opacity', '1');
        $('#userFormBlok').css('opacity', '1');
        $('#userFormBlok').css('transform', 'translateY(0)');
        next();
    });
}
$('#blokInput').focus(function() {
    $(this).css('border-color', '#8E44AD');
});
var degisim = false;

function closePopupBlok() {
    $('#blokInput').css('border-color', '#000000');

    $('#userFormBlok').css('opacity', '0').css('transform', 'translateY(-180px)').delay(100).queue(function(next) {
        $('#popupBlokEkle').css('opacity', '0').delay(300).queue(function(nextInner) {
            $(this).hide().css('display', 'none');
            nextInner();
            $('body').css('overflow', 'auto');
        });
        next();
    });
    if (degisim) {
        location.reload();
    }

}

function closePopupDaire() {

    $('#userFormDaire').css('opacity', '0').css('transform', 'translateY(-180px)').delay(100).queue(function(next) {
        $('#popupDaireEkle').css('opacity', '0').delay(300).queue(function(nextInner) {
            $(this).hide().css('display', 'none');
            nextInner();
            $('body').css('overflow', 'auto');
        });
        next();
    });

}

function closePopupToplu() {

    $('#userFormToplu').css('opacity', '0').css('transform', 'translateY(-180px)').delay(100).queue(function(next) {
        $('#popupTopluEkle').css('opacity', '0').delay(300).queue(function(nextInner) {
            $(this).hide().css('display', 'none');
            nextInner();
            $('body').css('overflow', 'auto');
        });
        next();
    });
}


let selectedValue;

document.getElementById('userInput').addEventListener('input', function() {
    selectedValue = this.value;
});
</script>



<script>
function getSelectedOption(inputElement) {
    var value = inputElement.value.toLowerCase();
    var options = inputElement.list.options;

    for (var i = 0; i < options.length; i++) {
        if (options[i].value.toLowerCase() === value) {
            return options[i];
        }
    }

    return null;
}


function save() {
    var userr = document.getElementById('userInput').value;
    var turr = document.getElementById("turDaire").value;
    var kTarih = document.getElementById("dateInput").value;
    var daireID = document.getElementById("hiddenDaireID").value;
    var apartId = document.getElementById('hiddenDaireID2').value;
    var selectedUserID = document.getElementById('userInput').dataset.userId;
    if (userr === null || userr === "") {
        $('#userInput').css('border-color', 'red');
    } else {

        $.ajax({

            url: 'Controller/user_assignment.php',
            type: 'POST',
            dataType: 'json',
            data: {
                userID1: selectedUserID,
                kTarih: kTarih,
                daireID: daireID,
                turr: turr,
                userr: userr,
                apartId: apartId,

            },
            success: function(response) {

                closePopup();
                var trElement = document.getElementById(daireID);

                // <td> elemanlarını seç
                var tdElements = trElement.getElementsByTagName('td');

                if (turr == 0) {
                    tdElements[3].innerText = "";
                    tdElements[3].innerText = response.userName;
                } else if (turr == 1) {
                    tdElements[5].innerText = "";
                    tdElements[5].innerText = response.userName;
                }

                if (response.refres) {
                    location.reload();
                }

            },
            error: function(xhr, status, error) {
                var errorMessage = xhr.status + ': ' + xhr.statusText + '\n' + error.responseText;
                alert(errorMessage);
            }

        });
    }

}


function saveBlok() {
    var blokInput = document.getElementById('blokInput').value;
    var t = document.getElementById('hiddenDaireID2').value;
    blokInput = blokInput.replace(/\s/g, "");
    if (blokInput == null || blokInput === "") {
        $('#blokInput').css('border-color', 'red');
    } else {
        var tableCells = document.querySelectorAll('.blokAdi');
        var p = true;
        // Her bir hücreyi dolaşarak içeriklerini alert kutusuyla göster
        for (var i = 0; i < tableCells.length; i++) {
            if (tableCells[i].innerHTML.toLowerCase() === blokInput.toLowerCase()) {
                p = false;
                break;
            }
        }

        if (p) {
            $.ajax({
                url: 'Controller/blok_add.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    blokValue: blokInput,
                    id: t,
                },
                success: function(response) {
                    if (response.status == 1) {
                        var mainTr = document.getElementById("mainTr");
                        var td1 = document.createElement("td");
                        var td2 = document.createElement("td");
                        var td3 = document.createElement("td");
                        var td4 = document.createElement("td");

                        // Burada her bir td elementinin içeriğini doldurabilirsiniz, örneğin:
                        td1.textContent = blokInput;
                        td2.textContent = "0";
                        // td3'e bir buton ekleyelim
                        td3.innerHTML = "<span class='blok-ico color-red' onclick=\"deleteBlok('" + response
                            .blok_id + "')\" ><i class='fa-solid fa-trash'></i></span>";

                        // td4'e bir buton ekleyelim
                        td4.innerHTML = "<span  class='blok-ico' onclick=\"editBlok('" + response.blok_id +
                            "')\" ><i class='fa-solid fa-pen'></i></span>";

                        // Yeni td elemanlarını tr içine ekleyin
                        var newTr = document.createElement("tr");
                        newTr.setAttribute("id", "blk-" + response.blok_id);
                        newTr.setAttribute("class", "git-ac");
                        newTr.appendChild(td1);
                        newTr.appendChild(td2);
                        newTr.appendChild(td3);
                        newTr.appendChild(td4);

                        // Tabloya yeni tr'yi en sona ekle
                        mainTr.parentNode.appendChild(newTr);
                        document.getElementById('blokInput').value = "";
                        degisim = true;
                    }
                },
                error: function(error) {
                    alert("hata: Müşteri temsilciniz ile iletişime geçiniz.");
                }
            });
        } else {
            alert("Zaten Bu İsimde Blok Mevcut");
        }
    }
}


function deleteBlok(id) {
    if (confirm("Bloğu silmek istediğinizden emin misiniz?")) {

        $.ajax({

            url: 'Controller/blok_delete.php',
            type: 'POST',
            dataType: 'json',
            data: {

                id: id,
            },
            success: function(response) {
                if (response.sts == 1) {
                    var trr = document.getElementById('blk-' + id);
                    trr.remove();
                    degisim = true;
                }
                alert(response.msg);

            },
            error: function(error) {
                alert(error);
            }

        });
    }

}


function editBlok(id) {
    $('#blk-' + id).addClass('active');

    $('#blk-' + id).find('td:eq(2) span').css('display', 'none');
    var trashIcon = $('<i class="fa-solid fa-xmark xmark1"></i>');
    var newSpan = $('<span>').addClass('blok-ico').append(trashIcon);
    $('#blk-' + id).find('td:eq(2)').append(newSpan);


    $('#blk-' + id).find('td:eq(3) span').css('display', 'none');
    var trashIcon = $('<i class="fa-solid fa-check check1"></i>');
    var newSpan1 = $('<span>').addClass('blok-ico').append(trashIcon);
    $('#blk-' + id).find('td:eq(3)').append(newSpan1);


    var temp = $('#blk-' + id).find('td:eq(0)').text();

    $('#blk-' + id).find('td:eq(0)').attr('contenteditable', true);
    $('#blk-' + id).find('td:eq(0)').on('input', function() {
        if (this.textContent.length > 5) {
            this.textContent = this.textContent.slice(0, 5);
        }
    });

    newSpan.click(function() {
        reeditBlok(id);
        $('#blk-' + id).find('td:eq(0)').text(temp);
    });

    newSpan1.click(function() {
        var temp1 = $('#blk-' + id).find('td:eq(0)').text();
        $.ajax({

            url: 'Controller/blok_update.php',
            type: 'POST',
            dataType: 'json',
            data: {

                id: id,
                temp1: temp1,
            },
            success: function(response) {
                degisim = true;

            },
            error: function(error) {
                degisim = true;
            }

        });


        reeditBlok(id);

    });

}


function reeditBlok(id) {
    $('#blk-' + id).find('td:eq(3) span:eq(1)').remove();
    $('#blk-' + id).find('td:eq(2) span:eq(1)').remove();

    $('#blk-' + id).find('td:eq(3) span:eq(0)').css('display', 'block');
    $('#blk-' + id).find('td:eq(2) span:eq(0)').css('display', 'block');

    $('#blk-' + id).removeClass('active');
    $('#blk-' + id).find('td:eq(0)').attr('contenteditable', false);
}





////////////////////// Daire   işlemleri //////////////////////
function SaveDaire() {
    var daireNo = document.getElementById("daireNo").value;
    var daireKat = document.getElementById("daireKat").value;
    var daireBlok = document.getElementById("daireBlok").dataset.userId;
    var daireGrup = document.getElementById("daireGrup").dataset.userId;
    var daireBrut = document.getElementById("daireBrut").value;
    var daireNet = document.getElementById("daireNet").value;
    var dairePay = document.getElementById("dairePay").value;
    var id = document.getElementById("DaireSaveID").value;
    var f = true;

    if (daireNo == "") {
        $('#daireNo').css('border-color', '#ff0000');
        $('#daireNoLabel').css('color', '#ff0000');
        f = false;
    }
    if (daireBlok == "") {
        $('#daireBlok').css('border-color', '#ff0000');
        $('#daireBlokLabel').css('color', '#ff0000');
        f = false;
    }

    if (f) {
        $.ajax({
            url: 'Controller/daire_add.php',
            type: 'POST',
            dataType: 'json',
            data: {
                daireNo: daireNo,
                daireKat: daireKat,
                daireBlok: daireBlok,
                daireGrup: daireGrup,
                daireBrut: daireBrut,
                daireNet: daireNet,
                dairePay: dairePay,
                id: id // id değeri burada belirtilmelidir
            },
            success: function(response) {
                if (response.status == 1) {
                    closePopupDaire();
                    alert(response.msg);
                    location.reload();
                } else if (response.status == 0) {
                    alert(response.error);
                }

            },
            error: function(error) {

            }
        });


    }

}



$('#daireNo').blur(function() {
    $('#daireNo').css('border-color', '#0d0c22');
    $('#daireNoLabel').css('color', '#0d0c22');
});

$('#daireNo').focus(function() {
    $('#daireNo').css('border-color', '#8E44AD');
    $('#daireNoLabel').css('color', '#8E44AD');
});

$('#daireBlok').blur(function() {
    $('#daireBlok').css('border-color', '#0d0c22');
    $('#daireBlokLabel').css('color', '#0d0c22');
});

$('#daireBlok').focus(function() {
    $('#daireBlok').css('border-color', '#8E44AD');
    $('#daireBlokLabel').css('color', '#8E44AD');
});





// checkbox işlemi 
function toggleAll(masterCheckbox) {


    var checkboxes = document.getElementsByClassName('check1');

    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = masterCheckbox.checked;
    }
    if (masterCheckbox.checked) {
        $('#guncelleButton').css('display', 'inline-block');
        $('#silButton').css('display', 'inline-block');

        $('.git-ac').addClass('git-ac-color');
    } else if (!masterCheckbox.checked) {
        $('#guncelleButton').css('display', 'none');
        $('#silButton').css('display', 'none');
        $('.git-ac').removeClass('git-ac-color');
    }
}


function toggleMainCheckbox(id) {

    var checkboxes = document.querySelectorAll('.check1'); // Tüm checkboxları al
    var guncelleButton = document.getElementById('guncelleButton');
    var silButton = document.getElementById('silButton');
    var enAzBirSecili = false;

    checkboxes.forEach(function(checkbox) {
        if (checkbox.checked) {
            enAzBirSecili = true;
        }
    });

    if (enAzBirSecili) {
        guncelleButton.style.display = 'inline-block';
        silButton.style.display = 'inline-block';
    } else {
        guncelleButton.style.display = 'none';
        silButton.style.display = 'none';
    }



    var checkbox2 = document.getElementById('check-' + id);

    if (checkbox2.checked) {
        $('#' + id).addClass('git-ac-color');
    } else {

        $('#' + id).removeClass('git-ac-color');
    }




}




// Herhangi bir alt checkbox işaret kaldırıldığında, "Hepsini Seç" kutusunu kaldırır
var checkboxes = document.getElementsByClassName('check1');
for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].addEventListener('change', function() {
        var allChecked = true;
        for (var j = 0; j < checkboxes.length; j++) {
            if (!checkboxes[j].checked) {
                allChecked = false;
                break;
            }
        }
        document.getElementById('mainCheckbox').checked = allChecked;
    });
}



// arama filtreleme

function filtrele() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchValue");
    filter = input.value.toUpperCase();
    table = document.getElementById("table");
    tr = table.getElementsByTagName("tr");

    // Her satırı kontrol et
    for (i = 0; i < tr.length; i++) {
        // İlk satır başlıksa atla
        if (tr[i].getElementsByTagName("th").length > 0) {
            continue;
        }
        // Her hücreyi kontrol et
        var display = false;
        td = tr[i].getElementsByTagName("td");
        for (var j = 0; j < td.length; j++) {
            if (td[j]) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    display = true;
                    break;
                }
            }
        }
        // Eğer filtre metni herhangi bir hücrede bulunuyorsa, satırı göster; aksi takdirde gizle
        if (display) {
            tr[i].style.display = "";
            tr[i].querySelector('.check-style input[type="checkbox"]').classList.add('check1');


        } else {
            tr[i].style.display = "none";
            tr[i].querySelector('.check-style input[type="checkbox"]').classList.remove('check1');


        }
    }
}




// Her bir td elemanının içindeki butonları kontrol et
function checkForButton(tdElements) {
    for (var i = 0; i < tdElements.length; i++) {
        var buttons = tdElements[i].querySelectorAll('button');
        if (buttons.length > 0) {
            return true;
        }
    }
    return false; // Döngü tamamlandıktan sonra buton bulunamazsa false döndür
}

function daireSil(id) {
    var checkedDaireIDs = [];
    var checkedBlokIDs = [];
    var checkboxes = document.querySelectorAll('.check1:checked');
    var f = false;
    var temp;

    checkboxes.forEach(function(checkbox) {
        var tr = checkbox.closest('tr');
        var td3 = tr.querySelectorAll('td:nth-child(4)');
        var td5 = tr.querySelectorAll('td:nth-child(6)');

        if (checkForButton(td3) && checkForButton(td5)) {
            var daireID = checkbox.id.replace('check-', '');
            var blokID = checkbox.getAttribute("data-userid");
            checkedBlokIDs.push(blokID);
            checkedDaireIDs.push(daireID);
        }
    });

    checkboxes.forEach(function(checkbox) {
        var tr = checkbox.closest('tr');
        var td32 = tr.querySelectorAll('td:nth-child(4)');
        var td54 = tr.querySelectorAll('td:nth-child(6)');

        if (!(checkForButton(td32) && checkForButton(td54))) {
            f = true;
        }
    });

    if (f) {
        temp =
            "Bu daireyi / daireleri silmek istediğinize emin misiniz?   (Seçilen daireler arasında kullanıcılar ile ilişkili daireler bulunmaktadır. İlişkisi bulunan daireler silinmeyecektir)";
    } else {
        temp = "Bu daireyi silmek istediğinize emin misiniz?";
    }



    if (confirm(temp)) {
        $.ajax({
            url: 'Controller/daire_delete.php',
            type: 'POST',
            dataType: 'json',
            data: {
                checkedDaireIDs: checkedDaireIDs,
                checkedBlokIDs: checkedBlokIDs,
                id: id,
            },
            success: function(response) {

                if (response.sts) {

                    if (response.str == undefined) {
                        alert("Silmeye Uygun Bir Daire Bulunamadı. Seçimlerinizi Gözden Geçiriniz.");
                    } else {
                        alert(response.msg);
                    }

                    location.reload();

                }

            },
            error: function(xhr, status, error) {
                var errorMessage = xhr.status + ': ' + xhr.statusText;
                alert('Hata alındı: ' + errorMessage);
            }
        });

    }


}

function daireGuncel(id) {
    var checkedDaireIDs = [];
    var daireKat = document.getElementById("daireKat1").value;
    var daireBlok = document.getElementById("daireBlok1").value;
    var daireGrup = document.getElementById("daireGrup1").value;
    var daireBrut = document.getElementById("daireBrut1").value;
    var daireNet = document.getElementById("daireNet1").value;
    var dairePay = document.getElementById("dairePay1").value;
    var checkboxes = document.querySelectorAll('.check1:checked');


    checkboxes.forEach(function(checkbox) {
        var daireID = checkbox.id.replace('check-', '');
        checkedDaireIDs.push(daireID);
    });


    $.ajax({
        url: 'Controller/daire_toplu_update.php',
        type: 'POST',
        dataType: 'json',
        data: {
            checkedDaireIDs: checkedDaireIDs,
            id: id,
            daireKat: daireKat,
            daireBlok: daireBlok,
            daireGrup: daireGrup,
            daireBrut: daireBrut,
            daireNet: daireNet,
            dairePay: dairePay,
        },
        success: function(response) {

            if (response.sts) {
                alert(response.msg);
                location.reload();
            }

        },
        error: function(xhr, status, error) {
            var errorMessage = xhr.status + ': ' + xhr.statusText;
            alert('Hata alındı: ' + errorMessage);
        }
    });




}

function onlyNumberKey(evt) {
    // Klavyeden girilen karakterin ASCII değerini al
    var charCode = (evt.which) ? evt.which : evt.keyCode;

    // ASCII değerlerine göre, sadece sayı ve bazı kontrol karakterlerine izin ver
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        evt.preventDefault();
    }
}


// tablo üzerine tıklandığında ilgili dairenin ayrıntı sayfasına yönlendiriyor.

var tableTdElements = document.querySelectorAll('.table_td');


tableTdElements.forEach(function(element) {
    element.addEventListener('click', function() {


        var trId = element.parentElement.getAttribute('id');
        var d = "daire";
        $.ajax({
            url: 'Controller/create_session.php',
            type: 'POST',
            data: {

                id: trId,
                d: d,

            },
            success: function(response) {


                if (response) {
                    window.location.href = "index.php?parametre=detail";
                }



            },
            error: function(xhr, status, error) {
                var errorMessage = xhr.status + ': ' + xhr.statusText;
                alert('Hata alındı: ' + errorMessage);
            }
        });


    });
});
</script>


<script src="assets/js/mycode/dropdown.js"></script>
<script>
dropDownn('daireBlok', 'daireBlokDP', 'searchInput');
dropDownn('daireGrup', 'daireGrupDP', 'searchInput2');
dropDownn('userInput', 'userInputDP', 'searchInput3');
dropDownn('daireBlok1', 'daireBlok1DP', 'searchInput-daireBlok1');
dropDownn('daireGrup1', 'daireGrup1DP', 'searchInput-daireGrup1');
</script>