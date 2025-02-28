<div class="container mt-5 mb-5">
    <h3>Műfaj felvétele</h3>
    <form action="admin_funcs/add/addGenre.php" method="post">
        <div class="form-group">
            <label for="genre_name_input">Műfaj név</label>
            <input type="text" class="form-control" name="genre_name" id="genre_name_input">
        </div>

        <div class="form-group">
            <label for="subgenre_name_input">Alműfaj név</label>
            <input type="text" class="form-control" name="subgenre_name" id="subgenre_name_input">
        </div>

        <button type="submit" class="btn btn-success">Hozzáadás</button>
    </form>
</div>
