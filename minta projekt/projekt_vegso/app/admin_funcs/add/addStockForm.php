<div class="container mt-5 mb-5">
    <h3>Készlet felvétele</h3>
    <form action="admin_funcs/add/addStock.php" method="post">
        <div class="form-group">
            <label for="book_select">Könyv</label>
            <select class="form-control" name='book' id="book_select">
                <?php
                include 'admin_funcs/getBooks.php';
                while (($row = oci_fetch_array($book_cursor, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
                ?>
                    <option value=<?php echo $row['ID'] ?>><?php echo $row['CIM'] ?></option>
                <?php
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="store_select">Áruház</label>
            <select class="form-control" name='store' id="store_select">
                <?php
                include 'admin_funcs/getStores.php';
                while (($row = oci_fetch_array($store_cursor, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
                ?>
                    <option value=<?php echo $row['ID'] ?>><?php echo $row['CIM'] ?></option>
                <?php
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="amount_input">Mennyiség</label>
            <input type="number" class="form-control" name="amount" id="amount_input" min="1">
        </div>

        <button type="submit" class="btn btn-success">Hozzáadás</button>
    </form>
</div>
