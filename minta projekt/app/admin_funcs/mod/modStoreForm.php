
<?php
include "getStoresAll.php";
?>

<div class="container mt-5">
    <h3>Áruház módosítása</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Cím</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while (($row = oci_fetch_array($cursor, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                ?>
                <form action="admin_funcs/mod/modStore.php" method="post">
                    <tr>
                        <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">

                        <td><input type="text" class="form-control" name="address" value="<?php echo $row['CIM']; ?>"></td>

                        <td><button type="submit" name="submit" value="mod" class="btn btn-success">Módosítás</button>

                        <button type="submit" name="submit" value="del" class="btn btn-danger">Törlés</button></td>
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