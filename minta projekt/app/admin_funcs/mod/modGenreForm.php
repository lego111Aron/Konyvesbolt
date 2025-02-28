
<?php
include "getGenresAll.php";
?>

<div class="container mt-5">
    <h3>Műfaj módosítása</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Műfaj név</th>
                <th>Alműfaj név</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while (($row = oci_fetch_array($cursor, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                ?>
                <form action="admin_funcs/mod/modGenre.php" method="post">
                    <tr>
                        <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">

                        <td><input type="text" class="form-control" name="genre_name" value="<?php echo $row['MUFAJ_NEV']; ?>"></td>

                        <td><input type="text" class="form-control" name="subgenre_name" value="<?php echo $row['ALMUFAJ_NEV']; ?>"></td>

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



<!-- <form action="admin_funcs/add/addGenre.php" method="post">
    <label for="genre_name_input"> Műfaj név </label> <br>
    <input type="text" name="genre_name" id="genre_name_input"> <br>

    <label for="subgenre_name_input"> Alműfaj név </label> <br>
    <input type="text" name="subgenre_name" id="subgenre_name_input"> <br>

    <button type="submit" class="btn btn-success">Hozzáadás</button>
</form> -->