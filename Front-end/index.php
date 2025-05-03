<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book25</title>
    <link rel="stylesheet" href="StyleSheets/style.css">
</head>

<body id="indexBody">

    <!--Fejléc és a menü-->
    <?php include "header.php"; ?>

    <h2><a href="profile.php">Profil info szerkesztése oldal</a></h2>
    <h1>Admin Funkciók:</h1>
    <h2><a href="admin.php">Műfajok + áruházak kezelése</a></h2>
    <h2><a href="bookregister.php">Könyvek + kiadók kezelése</a></h2>
    
    <h2><a href="../Back-end/authentication/logout.php">Kijelentkezés</a></h2>
    <h2><a href="../Back-end/authentication/delete_user.php" onclick="return confirm('Biztosan törölni szeretné a fiókját?')">Fiók törlése</a></h2>


</body>
</html>