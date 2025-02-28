<?php
include_once "scripts/getAllPurchases.php";
?>

<div class="container">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Vásárlás időpontja</th>
                <th>Szállítási cím</th>
                <th>Könyv címe</th>
                <th>Mennyiség</th>
                <th>Törlés</th> <!-- Új oszlop a törlési gombnak -->
            </tr>
        </thead>
        <tbody>
            <?php
            $prevDate = null;
            while ($row = oci_fetch_assoc($stmt)) {
                $datum = $row["DATUM"];
                if ($prevDate !== $datum) {
                    echo "
                    <tr>
                        <td colspan=1><strong>" . $datum . "</strong></td>
                        <td colspan=3>" . $row['SZALLITASI_CIM'] . "</td>
                        <td></td> <!-- Üres oszlop a törlési gombnak -->
                    </tr>";

                    $prevDate = $datum;
                }
                echo "<tr>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td>" . $row['KONYV_CIM'] . ' (' . $row['SZERZO'] . ')' . "</td>";
                echo "<td>" . $row['MENNYISEG'] . "</td>";
                echo "
                    <td>
                        <form action='scripts/deletePurchase.php' method='post'>
                            <input type='hidden' name='id' value=" . $row["ID"] . ">
                            <button type='submit' class='btn btn-danger mr-3' style='width: 30px; height: 30px; padding: 0;'>
                                <svg width='30' height='30' xmlns='http://www.w3.org/2000/svg' style='padding-left: 5px;'>
                                    <image id='cart-delete' href='assets/icons/trash-solid.svg' height='30' width='20' />
                                </svg>
                            </button>
                        </form>
                    </td>
                ";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
