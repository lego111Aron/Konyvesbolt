<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book25</title>
    <link rel="stylesheet" href="StyleSheets/style.css">
</head>

<body id="profileBody">

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

    <form class="profile-form-container" method="post" action="fiok.php">
        <h2>Fiók adatok</h2>

        <div class="profile-grid-container">
            <div class="profileform-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email">
            </div>

            <div class="profileform-group">
                <label for="username">Felhasználónév</label>
                <input type="text" name="username" id="username">
            </div>

            <div class="profileform-group">
                <label for="phone">Telefon</label>
                <input type="text" name="phone" id="phone">
            </div>

            <div class="profileform-group">
                <label for="address">Lakcím</label>
                <input type="text" name="address" id="address">
            </div>

        </div>

        <button type="submit">Mentés</button>
    </form>



</body>
</html>