
<?php 
$sql = "SELECT * FROM tbl_maliye";
$result = $conn->query($sql);

?> 




<table id="example" class="users-table">
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
                <th onclick="sortTable(1)">Ad Soyad <i id="icon-table1" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(2)">Telefon Numarası <i id="icon-table2" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(3)">Blok / Daire <i id="icon-table3" class="fa-solid fa-sort-down"></i></th>
                <th onclick="sortTable(4)">Durum <i id="icon-table4" class="fa-solid fa-sort-down"></i></th>
            </tr>
        </thead>

        <tbody>

            <?php
                    $i = 0;
                    foreach ($result as $row) {
                        $i++;
                        ?>
            <tr data-userid="<?php echo $row["userID"]; ?>" data-d="<?php echo $row["daire_id"]; ?>"
                id="tr-<?php echo $row["userID"] . '-' . $i; ?>" class="git-ac">
                <td data-title="Seç" class="check-style">
                    <!-- Checkbox id'sine $i değerini ekliyoruz -->
                    <input id="check-<?php echo $row["userID"] . '-' . $i; ?>" class="check1" type="checkbox"
                        onclick="toggleCheckbox(<?php echo $row['userID']; ?>, <?php echo $i; ?>)" />
                    <label for="check-<?php echo $row["userID"] . '-' . $i; ?>" class="check">
                        <svg width="18px" height="18px" viewBox="0 0 18 18">
                            <path
                                d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z">
                            </path>
                            <polyline points="1 9 7 14 15 4"></polyline>
                        </svg>
                    </label>
                </td>
                <td data-title="Ad Soyad" class="table_tt table_td" contenteditable="false">

                    <?php echo $row["userName"]; ?>
                </td>

                <td data-title="Telefon Numarası" class="table_tt table_td phoneNumberTable" contenteditable="false">

                    <?php echo $row["phoneNumber"]; ?>
                </td>

             

             
            </tr>

            <?php
                    }
                    ?>


        </tbody>
    </table>



    


