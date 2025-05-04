<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="StyleSheets/style.css">
    <link rel="stylesheet" href="StyleSheets/stock_style.css">
    <title>Raktárkészlet</title>
</head>
<?php
    session_start();

    if (!isset($_SESSION["username"])) {
        header("Location: index.php"); 
        exit(); 
    }

    $username = $_SESSION["username"];
    include "../Back-end/connect.php";
    $query = "SELECT * FROM FELHASZNALO WHERE FELHASZNALONEV = :username";
    $stid = oci_parse($conn, $query);
    oci_bind_by_name($stid, ':username', $username);
    oci_execute($stid);
    
    $user = oci_fetch_object($stid);
    oci_free_statement($stid);

    
    // Ha a felhasználó nem üzletvezető, irányítsuk át
    if ($user->SZEREPKOR != "uzletvezeto") {
        header("Location: index.php"); // Ha nem üzletvezető, irányítjuk az index oldalra
        exit();
    }

    $query="SELECT konyv.isbn, konyv.cim, NVL(van.keszlet, 0) AS bolt_keszlet
        FROM konyv
        LEFT JOIN (
            SELECT van.ISBN, van.keszlet
            FROM van
            JOIN aruhaz ON van.id = aruhaz.id
            WHERE aruhaz.felhasznalo = :felhasznalo_nev
        ) van ON konyv.isbn = van.ISBN
        WHERE EXISTS (
            SELECT 1
            FROM aruhaz
            WHERE aruhaz.felhasznalo = :felhasznalo_nev
        )";
    $stid = oci_parse($conn, $query);
    oci_bind_by_name($stid, ':felhasznalo_nev', $username);
    oci_execute($stid);
    $raktarkeszlet =array();
    while ($row = oci_fetch_object($stid)) {
        $raktarkeszlet[] = $row;
    }



?>
<body>
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
        <a href="stock.php">Raktárkészlet</a>
    </div>

    <div id="content">
        <h1>Raktárkészlet</h1>
        <table>
        <tr>
                <th>ISBN</th>
                <th>Cím</th>
                <th>Raktárkészlet</th>
                <th>Művelet</th>
            </tr>
        <?php foreach ($raktarkeszlet as $konyv): ?>
    
                <tr>
                    <form method="POST" action="stock_update.php">
                        <td><?= htmlspecialchars($konyv->ISBN) ?></td>
                        <td><?= htmlspecialchars($konyv->CIM) ?></td>
                        <td>
                            <input type="number" name="keszlet" value="<?= $konyv->BOLT_KESZLET ?>" min="0">
                            <input type="hidden" name="isbn" value="<?= htmlspecialchars($konyv->ISBN) ?>">
                        </td>
                        <td><button type="submit">Mentés</button></td>
                    </form>
                </tr>
          
            <?php endforeach; ?>
            </table>

    </div>

</body>
</html>