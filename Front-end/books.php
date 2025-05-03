<?php
include "../Back-end/book_management/base.php";

$filter = [];

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $filter['search'] = trim($_GET['search']);
}

if (isset($_GET['price']) && is_numeric($_GET['price'])) {
    $filter['price'] = [0, intval($_GET['price'])];
}

// <-- IDE jön ez:
if (isset($_GET['kategoriak']) && is_array($_GET['kategoriak'])) {
    $filter['genres'] = array_map('trim', $_GET['kategoriak']);
}

$genres = fetchGenres();
$books = fetchBooks(false, $filter);

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book25</title>
    <link rel="stylesheet" href="StyleSheets/style.css">
</head>

<body id="booksBody">

    <!--Fejléc-->
    <div class="topbar">
        <div class="logo"><a href="index.php">BOOK<span>25</span>.hu</a></div>
        <div class="login"><a href="login.php">Bejelentkezés</a></div>
    </div>

    <!--Menü-->
    <div class="navbar">
        <a href="index.php">Főoldal</a>
        <a href="books.php">Könyvek</a>
        <a href="authors.php">Kiadók</a>
        <a href="shops.php">Áruházak</a>
        <a href="#">Statisztikák</a>
    </div>

    <!-- Szűrődoboz -->
    <div class="szuro-doboz">
        <form class="szuro-form" method="GET">
          
          <div class="kategoria-es-kereso">
            <div class="kategoriak">
                <?php foreach ($genres as $genre): ?>
                    <label>
                        <input 
                            type="checkbox" 
                            name="kategoriak[]" 
                            value="<?= htmlspecialchars($genre['GenreName']) ?>" 
                            <?= isset($_GET['kategoriak']) && in_array($genre['GenreName'], $_GET['kategoriak']) ? 'checked' : '' ?>
                        >
                        <span><?= htmlspecialchars($genre['GenreName']) ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
      
            <input type="text" name="search" class="kereso" placeholder="Írja be a keresett kifejezést" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
          </div>
      
          <div class="arszuro">
            <input type="range" name="price" id="ar" min="1000" max="20000" value="<?= isset($_GET['price']) ? htmlspecialchars($_GET['price']) : '20000' ?>" step="500" oninput="document.getElementById('ar-ertek').value = this.value">
            <output id="ar-ertek"><?= isset($_GET['price']) ? htmlspecialchars($_GET['price']) : '20000' ?></output>
          </div>
      
          <button type="submit" class="szures-gomb">Szűrés</button>
        </form>
    </div>

    <!-- Könyvek listázása -->
    <div class="konyvek-lista">
        <?php if (!empty($books)): ?>
            <h2>Elérhető könyvek</h2>
            <div class="konyvek">
                <?php foreach ($books as $book): ?>
                    <div class="konyv">
                        <h3><?= htmlspecialchars($book['Title']) ?></h3>
                        <p><strong>ISBN:</strong> <?= htmlspecialchars($book['ISBN']) ?></p>
                        <p><strong>Ár:</strong> <?= htmlspecialchars($book['Price']) ?> Ft</p>
                        <p><strong>Oldalak száma:</strong> <?= htmlspecialchars($book['Pages']) ?></p>
                        <p><strong>Kiadás dátuma:</strong> <?= htmlspecialchars($book['PublicationDate']) ?></p>
                        <!-- <p><strong>Műfaj:</strong> <?= htmlspecialchars($book['Genre']) ?></p> -->
                        <button type="button" class="kosarba-gomb">Kosárba</button>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Nincsenek elérhető könyvek a megadott szűrők alapján.</p>
        <?php endif; ?>
    </div>

</body>
</html>
