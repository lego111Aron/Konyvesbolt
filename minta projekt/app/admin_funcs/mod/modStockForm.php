
<?php
include "getStocksAll.php";
?>

<div class="container mt-5">
    <h3>Készlet módosítása</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Cím</th>
                <th>Könyv</th>
                <th>Mennyiség</th>
                <th colspan="2">Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while (($row = oci_fetch_array($cursor, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                ?>
                <form action="admin_funcs/mod/modStock.php" method="post">
                    <tr>
                        <input type="hidden" name="store" value="<?php echo $row['ARUHAZ_ID']; ?>">
                        <input type="hidden" name="book" value="<?php echo $row['KONYV_ID']; ?>">

                        <td>
                            <?php
                            include "admin_funcs/getStores.php";
                            while (($store_row = oci_fetch_array($store_cursor, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                                if ($store_row['ID'] == $row['ARUHAZ_ID']) echo $store_row['CIM'];
                            }
                            ?>
                        </td>

                        <td>
                            <?php
                            include "admin_funcs/getBooks.php";
                            while (($book_row = oci_fetch_array($book_cursor, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                                if ($book_row['ID'] == $row['KONYV_ID']) echo $book_row['CIM'];
                            }
                            ?>
                        </td>

                        <td><input type="number" class="form-control" name="amount" min="0" value="<?php echo $row['MENNYISEG']; ?>"></td>

                        <td><button type="submit" name="submit" value="mod" class="btn btn-success">Módosítás</button></td>

                        <td><button type="submit" name="submit" value="del" class="btn btn-danger">Törlés</button></td>
                    </tr>
                </form>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>


<!-- <form action="admin_funcs/add/addStore.php" method="post">
    <label for="address_input"> Cím </label> <br>
    <input type="text" name="address" id="adress_input"> <br>

    <button type="submit" class="btn btn-success">Hozzáadás</button>
</form> -->