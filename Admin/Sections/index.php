<?php
try {
    $sql = "SELECT * FROM tbl_daireler where apartman_id=198";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Sonuç kümesinin satır sayısını kontrol etme
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        echo '<table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        
                        <th>Blok Adı</th>
                        <th>Kapı No</th>
                        <th>Kiracı</th>
                        <th>Kat Maliki</th>
                        <th>Bakiye</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($result as $row) {
            echo '<tr>
                    <td>' . $row["blok_adi"] . '</td>
                    <td>' . $row["daire_sayisi"] . '</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>';
        }

        echo '</tbody>
            </table>';
    } else {
        echo "0 results";
    }
} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
?>


<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
   new DataTable('#example', {
    initComplete: function () {
        this.api()
            .columns()
            .every(function () {
                let column = this;
                let title = column.footer().textContent;

                // Create input element
                let input = document.createElement('input');
                input.placeholder = title;
                column.footer().replaceChildren(input);

                // Event listener for user input
                input.addEventListener('keyup', () => {
                    if (column.search() !== this.value) {
                        column.search(input.value).draw();
                    }
                });
            });
    }
});
</script>

