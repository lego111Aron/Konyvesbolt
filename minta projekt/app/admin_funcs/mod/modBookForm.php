<?php
include "getBooksAll.php"; 
?>

<div class="m-3 mt-5">
    <h3>Könyv módosítása</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Cím</th>
                <th>Szerző</th>
                <th>Kiadó</th>
                <th>Oldalszám</th>
                <th>Leírás</th>
                <th>Nyelv</th>
                <th>Műfaj</th>
                <th>Ár</th>
                <th colspan="2">Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while (($row = oci_fetch_array($cursor, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                ?>
                <form action="admin_funcs/mod/modBook.php" method="post">
                    <tr>
                        <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">

                        <td><input type="text" class="form-control" name="title" value="<?php echo $row['CIM']; ?>"></td>

                        <td>
                            <select class="form-control" name='author'>
                                <?php
                                include "admin_funcs/getAuthors.php";
                                while (($author_row = oci_fetch_array($author_cursor, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                                    ?>
                                    <option value="<?php echo $author_row['ID']; ?>" <?php if ($author_row['ID'] == $row['SZERZO_ID']) echo 'selected = "selected"'; ?>><?php echo $author_row['NEV']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>

                        <td>
                            <select class="form-control" name='publisher'>
                                <?php
                                include "admin_funcs/getPublishers.php";
                                while (($publisher_row = oci_fetch_array($publisher_cursor, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                                    ?>
                                    <option value="<?php echo $publisher_row['ID']; ?>" <?php if ($publisher_row['ID'] == $row['KIADO_ID']) echo 'selected = "selected"'; ?>><?php echo $publisher_row['NEV']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>

                        <td><input type="number" class="form-control" style="width: 7em" name="page_count" value="<?php echo $row['OLDALSZAM']; ?>"></td>

                        <td><input type="text" class="form-control" size="50" name="desc" value="<?php echo $row['LEIRAS']; ?>"></td>

                        <td><input type="text" class="form-control" style="width: 7em" name="lang" value="<?php echo $row['NYELV']; ?>"></td>

                        <td>
                            <select class="form-control" name='genre'>
                                <?php
                                include "admin_funcs/getGenres.php";
                                while (($genre_row = oci_fetch_array($genre_cursor, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                                    ?>
                                    <option value="<?php echo $genre_row['ID']; ?>" <?php if ($genre_row['ID'] == $row['MUFAJ_ID']) echo 'selected = "selected"'; ?>><?php echo $genre_row['NEV'] . ', ' . $genre_row['ALMUFAJ_NEV']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>

                        <td><input type="number" class="form-control" style="width: 7em" name="price" value="<?php echo $row['AR']; ?>" min="0"></td>

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