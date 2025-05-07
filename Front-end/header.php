<!-- Front-end/header.php -->
<div class="topbar">
    <div class="logo"><a href="index.php">BOOK<span>25</span>.hu</a></div>
    <?php
        include_once __DIR__ . "/../Back-end/authentication/base.php";
        if (sessionTest()) {
            echo '<div class="login"><a href="profile.php">Profil</a></div>';
        } else {
            echo '<div class="login"><a href="login.php">Bejelentkezés</a></div>';
        }
    ?>
</div>

<div class="navbar">
    <a href="index.php">Főoldal</a>
    <a href="books.php">Könyvek</a>
    <a href="authors.php">Kiadók</a>
    <a href="shops.php">Áruházak</a>
    <a href="basket.php">Kosár</a>
    <a href="statistics.php">Statisztikák</a>
</div>
