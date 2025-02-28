<?php
include "scripts/connectDB.php"; 

$sql = "SELECT id, cim FROM ARUHAZ";
$stmt = oci_parse($conn, $sql);

oci_execute($stmt);

$admin = isset($_SESSION['user_id']) && $_SESSION['admin'];
?>


<div class="container mt-5">
    <h2>Áruházaink</h2>
    <table class='table table-striped'>
        <tbody>
        <?php
        while ($row = oci_fetch_assoc($stmt)) {
            echo '
                <tr>
                    <td>' .
                        $row['CIM'];

                        if ($admin){
                            echo '<br><a href="?page=stores&id=' . $row['ID'] . '#stocktable">Részletek</a>';
                        }

                    echo 
                    '</td>
                </tr>
            ';
        }
        ?>
        </tbody>
    </table>
</div>

<?php if($admin && isset($_GET['id'])): ?>
<?php include "scripts/getStockAtStore.php"; ?>
<div class="container mt-5">
    <h4 id="stocktable">Készlet <strong><?php echo '"' . $aruhaz_cim_valasztott['CIM'] . '"' ?></strong> áruházunkban:</h4>
    <table class="table table-striped mt-3" style="max-width: 50%;">
    <th>Könyv</th>
    <th>Példányszám</th>
        <?php 
            
            while($row = oci_fetch_assoc($stmt)){
                echo
                    '<tr>' .
                        '<td><a href="?page=item&id=' . $row['KONYV_ID'] . '">' . $row['KONYV_CIM'] . '</a></td>' .
                        '<td>' . $row['MENNYISEG'] . '</td>' .
                    '</tr>';
                }
                ?>
    </table>
</div>
<?php endif; ?>

<?php
oci_free_statement($stmt);
oci_close($conn);
?>
