

<!-- include "../Back-end/authentication/base.php"; // sessionTest() függvény használata -->

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book25</title>
    <link rel="stylesheet" href="StyleSheets/style.css">
</head>

<body id="indexBody">

    <!--Fejléc-->
    <div class="topbar">
        <div class="logo"><a href="index.php">BOOK<span>25</span>.hu</a></div>
        <div class="login"><a href="login.php">Bejelentkezés</a></div>
    </div>

    <!--Menü-->
    <div class="navbar">
        <a href="index.php">Főoldal</a>
        <a href="#">Könyvek</a>
        <a href="#">Kiadók</a>
        <a href="#">Áruházak</a>
        <a href="#">Statisztikák</a>
    </div>
    <h1>Admin Funkciók:</h1>
    <h2><a href="admin.php">Műfajok + áruházak kezelése</a></h2>
    <h2><a href="bookregister.php">Könyvek + kiadók kezelése</a></h2>
    <!-- TODO: ezt az elemet át kell tenni a fejlécbe -->
    <h2><a href="../Back-end/authentication/logout.php">Kijelentkezés</a></h2>

    <h2><a href="../Back-end/authentication/delete_user.php" onclick="return confirm('Biztosan törölni szeretné a fiókját?')">Fiók törlése</a></h2>

    <!-- Ahhoz, hogy ez működjön át kell alakítani az oldalt php-ra -->
    <!-- Ez egy példa arra, hogy hogyan lehet megvalósítani azt, hogy a kijelentkezés gomb csak akkor jelenjen meg
     ha a felhasználó be van jelentkezve. Ez implementálható a bejelentkezési gombra is fordított logikával -->
    <!-- <?php if (sessionTest()): ?>
        <h2><a href="../Back-end/authentication/logout.php">Kijelentkezés</a></h2>
    <?php endif; ?> -->

</body>
</html>