
    <?php
try {
   
    
    //$sql = "SELECT * FROM tbl_users WHERE apartman_id = " .$_SESSION["apartID"]."AND userID=".$userID ;
    $sql = "SELECT tbl_daireler.*, tbl_blok.blok_adi, tbl_grup.grup_adi,
    kiraci.userName AS kiraci_adi, kiraci.userID AS kiraci_id,
    katMaliki.userID AS kat_maliki_id, katMaliki.userName AS kat_maliki_adi
FROM tbl_daireler 
LEFT JOIN tbl_blok ON tbl_daireler.blok_adi = tbl_blok.blok_id
LEFT JOIN tbl_users AS kiraci ON tbl_daireler.kiraciID = kiraci.userID
LEFT JOIN tbl_users AS katMaliki ON tbl_daireler.katMalikiID = katMaliki.userID
LEFT JOIN tbl_grup ON tbl_daireler.dGrubu = tbl_grup.grup_id
WHERE tbl_daireler.apartman_id = " . $_SESSION["apartID"] . " 
AND tbl_daireler.daire_id = " . $_SESSION['daireSayfa'];



    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    // Sonuç kümesinin satır sayısını kontrol etme
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $row= $result;
  
        
            echo "Kiracı ID: " . $row["kiraci_id"] . "<br>";
            echo "Kiracı: " . $row["kiraci_adi"] . "<br>";
            echo "Kat Malikisi ID: " . $row["kat_maliki_id"] . "<br>";
            echo "Kat Malikisi: " . $row["kat_maliki_adi"] . "<br>";
    ?>

<div class="emp-profile row">



    <div class="col-xl-5 col-lg-8 col-md-12 col-sm-12 col-12">
        <div class="h-100">	
            <div class="contact-form">                

        	    <form id="" method="post" action="">

        	    	<div class="row">
        	    		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        	    			<h6 class="mb-2">Daire Bilgileri</h6>
        	    		</div>

                        <hr class="horizontal dark mt-3">
                        
        	    		<div class="bilgi-p col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
        	    			<p class="bilgi-p">Daire :</p>
        	    		</div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <p class="bilgi-p"><?php  echo  $row['blok_adi'] ." Blok / No: ".$row['daire_sayisi'] ;    ?></p>
        	    		</div>

                        <hr class="horizontal dark mt-0">

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <p class="bilgi-p">Kat Maliki</p>
        	    		</div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <p class="bilgi-p" ><?php echo isset($row["kat_maliki_adi"]) && ($row["kat_maliki_adi"] !== null && $row["kat_maliki_adi"] !== 0) ? $row["kat_maliki_adi"] : '<button type="button" class="table-a tca2" onclick="openPopup('.$row["daire_id"].',1)">Kat Maliki Ekle + </button>'; ?>
 </p>
        	    		</div>

                        <hr class="horizontal dark mt-0">

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <p class="bilgi-p">Kiracı</p>
        	    		</div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <p class="bilgi-p"><?php echo isset($row["kiraci_adi"]) && ($row["kiraci_adi"] !== null && $row["kiraci_adi"] !== 0) ? $row["kiraci_adi"] : '<button type="button" class="table-a tca1" onclick="openPopup('.$row["daire_id"].',0)">Kiracı Ekle + </button>'; ?>
</p>
        	    		</div>

                        <hr class="horizontal dark mt-0">

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <p class="bilgi-p">Daire Grubu</p>
        	    		</div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <p class="bilgi-p"><?php  echo  $row["grup_adi"] ;    ?></p>
        	    		</div>

                        <hr class="horizontal dark mt-0">

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <p class="bilgi-p">Kat</p>
        	    		</div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <p class="bilgi-p"><?php  echo  $row["kat"] ;    ?></p>
        	    		</div>

                        <hr class="horizontal dark mt-0">

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <p class="bilgi-p">Brüt m²</p>
        	    		</div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <p class="bilgi-p"><?php  echo  $row["brut"] ;    ?></p>
        	    		</div>

                        <hr class="horizontal dark mt-0">

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <p class="bilgi-p">Net m²</p>
        	    		</div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <p class="bilgi-p"><?php  echo  $row["net"] ;    ?></p>
        	    		</div>

                        <hr class="horizontal dark mt-0">

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <p class="bilgi-p">Arsa Payı</p>
        	    		</div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <p class="bilgi-p"><?php  echo  $row["pay"] ;    ?></p>
        	    		</div>
                    </div>
        	    	
        	    </form>

        	</div>
        </div> 
    </div>

    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="h-100">
        	<div class="contact-form">
        		<div class="account-settings">

                    <div class="btn-box-users">
                        <button class="btn-box-outline">Düzenle</button>
                        <div>
                        <button class="btn-box-outline">Borç</button>
                        <button class="btn-box-outline">Tahsilat</button>
                        </div>
                    </div>

                    <div class="borc-box">
                        <a href="">
                            <p class="borc">borç yazar burda be</p>
                            <p class="para">30 TL</p>
                        </a>

                        <a href="">
                            <p class="borc">borç yazar burda be</p>
                            <p class="para">30 TL</p>
                        </a>

                        <a href="">
                            <p class="borc">borç yazar burda be</p>
                            <p class="para">30 TL</p>
                        </a>

                        <a href="">
                            <p class="borc">borç yazar burda be</p>
                            <p class="para">30 TL</p>
                        </a>
                    </div>                        

        		</div>
        	</div>
        </div>
    </div>
    
</div>
  
    <?php
    
    
} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
?>

    <body>
      
        <script type="text/javascript">
       

        </script>
