<div class="container mt-5 mb-5">
    <h3>Könyv felvétele</h3>
    <div class="row">
        <div class="col-md-6">
            <form action="admin_funcs/add/addBook.php" method="post">
                <div class="form-group">
                    <label for="title_input">Cím</label>
                    <input type="text" class="form-control" name="title" id="title_input">
                </div>

                <div class="form-group">
                    <label for="author_select">Szerző</label>
                    <select class="form-control" name='author' id="author_select">
                        <?php
                        include 'admin_funcs/getAuthors.php';
                        while (($row = oci_fetch_array($author_cursor, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
                        ?>
                            <option value=<?php echo $row['ID'] ?>><?php echo $row['NEV'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="publisher_select">Kiadó</label>
                    <select class="form-control" name='publisher' id="publisher_select">
                        <?php
                        include 'admin_funcs/getPublishers.php';
                        while (($row = oci_fetch_array($publisher_cursor, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
                        ?>
                            <option value="<?php echo $row['ID'] ?>"><?php echo $row['NEV'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="page_count_input">Oldalszám</label>
                    <input type="number" class="form-control" name="page_count" id="page_count_input" min="1">
                </div>

                <div class="form-group">
                    <label for="desc_input">Leírás</label>
                    <input type="text" class="form-control" name="desc" id="desc_input">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="lang_input">Nyelv</label>
                    <input type="text" class="form-control" name="lang" id="lang_input">
                </div>

                <div class="form-group">
                    <label for="genre_select">Műfaj</label>
                    <select class="form-control" name='genre' id="genre_select">
                        <?php
                        include 'admin_funcs/getGenres.php';
                        while (($row = oci_fetch_array($genre_cursor, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
                        ?>
                            <option value="<?php echo $row['ID'] ?>"><?php echo $row['NEV'] . ', ' . $row['ALMUFAJ_NEV'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="price_input">Ár</label>
                    <input type="number" class="form-control" name="price" id="price_input">
                </div>

                <button type="submit" class="btn btn-success">Hozzáadás</button>
            </form>
        </div>
    </div>
</div>
