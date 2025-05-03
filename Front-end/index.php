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
        <?php
            include "../Back-end/authentication/base.php";
            if (sessionTest()) {
                echo '<div class="login"><a href="profile.php">Profil</a></div>';
            } else {
                echo '<div class="login"><a href="login.php">Bejelentkezés</a></div>';
            }
            
        ?>
    </div>

    <!--Menü-->
    <div class="navbar">
        <a href="index.php">Főoldal</a>
        <a href="books.php">Könyvek</a>
        <a href="authors.php">Kiadók</a>
        <a href="shops.php">Áruházak</a>
        <a href="#">Statisztikák</a>
    </div>
    
    <h2><a href="profile.php">Profil info szerkesztése oldal</a></h2>
    <h1>Admin Funkciók:</h1>
    <h2><a href="admin.php">Műfajok + áruházak kezelése</a></h2>
    <h2><a href="bookregister.php">Könyvek + kiadók kezelése</a></h2>
  
    <h2><a href="../Back-end/authentication/delete_user.php" onclick="return confirm('Biztosan törölni szeretné a fiókját?')">Fiók törlése</a></h2>


</body>
</html>