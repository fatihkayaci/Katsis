   <?php
  $sql = '
  SELECT d.*, b.blok_adi
  FROM tbl_daireler d
  JOIN tbl_blok b ON d.blok_adi = b.blok_id
  WHERE d.apartman_id = :apartman_id
';

// Hazırlanan ifadeyi oluştur
$stmt = $conn->prepare($sql);

// Parametreyi bağla ve sorguyu çalıştır
$stmt->execute(['apartman_id' => $idapartman]);

// Sonuçları çek
$daireler = $stmt->fetchAll();
   
   ?> 
    
    
    

    
    <div class="cener-table">
        <div class="input-group-div">

            <div class="input-group1">
                <button class="adduser btn-custom-outline bcoc1">Pop-up</button>
            </div>
            <div class="input-group1">
                <div class="search-box">
                    <i class="fas fa-search search-icon" aria-hidden="true"></i>
                    <input type="text" class="search-input" placeholder="Arama...">
                </div>
            </div>

        </div>

        <hr class="horizontal dark mb-1 w-100">

        <div class="table-overflow">
            <table id="example" class="users-table center-txt">
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
                        <th onclick="sortTable(1)">No <i id="icon-table1" class="fa-solid fa-sort-down"></i></th>
                        <th onclick="sortTable(2)">Daire <i id="icon-table2" class="fa-solid fa-sort-down"></i></th>
                        <th onclick="sortTable(3)">İlk Endeks <i id="icon-table3" class="fa-solid fa-sort-down"></i></th>
                        <th onclick="sortTable(4)"><button class="aktar-btn"><i class="fa-solid fa-left-long"></i></button></th>
                        <th onclick="sortTable(5)">Son Endeks <i id="icon-table5" class="fa-solid fa-sort-down"></i></th>
                        <th onclick="sortTable(6)">Tüketim <i id="icon-table6" class="fa-solid fa-sort-down"></i></th>
                    </tr>
                </thead>

                <tbody>

                <?php foreach($daireler as $daire ){   ?>
                    <tr data-userid="" data-d="" id="" class="git-ac">

                        <td data-title="Seç" class="check-style check-ayar1">
                            <!-- Checkbox id'sine $i değerini ekliyoruz -->
                            <input id="" class="check1" type="checkbox" onclick="toggleCheckbox()" />
                            <label for="" class="check">
                                <svg width="18px" height="18px" viewBox="0 0 18 18">
                                    <path
                                        d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z">
                                    </path>
                                    <polyline points="1 9 7 14 15 4"></polyline>
                                </svg>
                            </label>
                        </td>

                        <td class="table_tt table_td"><?php echo $daire["blok_adi"] ?></td>

                        <td class="table_tt table_td"><?php echo $daire["daire_sayisi"] ?></td>

                        <td class="table_tt table_td aktarTd"><input class="sayac-input" type="number" value="5"></td>

                        <td class="table_tt table_td aktarTd1"><p>kWH</p></td>

                        <td class="table_tt table_td aktarTd"><input class="sayac-input active" type="number" value="5"></td>

                        <td class="table_tt table_td">2</td>

                    </tr>
            <?php } ?>

                </tbody>
            </table>
        </div>

        <hr class="horizontal dark mb-1 w-100">

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
            <button class="export-btn excel-btn" id="exportButton"><i class="fa-solid fa-file-excel"></i> Excel'e
                Aktar</button>
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

<!-- ================================================ -->
<!-- Sayi secme script -->

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
            c.addEventListener("click", function (e) {
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
        a.addEventListener("click", function (e) {
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
<!-- Sayi secme script end -->
<!-- ================================================ -->



</body>
</html>