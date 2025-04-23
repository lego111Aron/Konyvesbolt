<?php
    include "../Back-end/connect.php";
    $sql = "SELECT id, mufaj_nev FROM mufaj";
    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);
    $mufajok = [];

    while ($row = oci_fetch_object($stmt)) {
        $mufajok[] = $row; 
    }

    $sql = "SELECT id, almufaj_nev FROM almufaj";
    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);
    $almufajok = [];

    while ($row = oci_fetch_object($stmt)) {
        $almufajok[] = $row; 
    }
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book25</title>
    <link rel="stylesheet" href="StyleSheets/style.css">
    <script src="https://kit.fontawesome.com/0b5692342b.js" crossorigin="anonymous"></script>
</head>

<body id="adminBody">

    <div class="topbar">
        <div class="logo"><a href="index.html">BOOK<span>25</span>.hu</a></div>
    </div>

    <div class="admin-container">

                                                 <!-- Áruház hozzáadása -->

        <div class="admin-form-box">
            <h1>Áruház hozzáadása</h1>

            <form method="post" id="shop-register-form" action="../Back-End/shop-genre/shop-register.php">

                <div class="admin-input-group">
                    <div class="input-field" >
                        <i class="fa-solid fa-location-dot"></i>
                        <input type="text" name="CIM" id="CIM" placeholder="Cím">
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="EMAIL" id="EMAIL" placeholder="E-mail cím">
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-phone"></i>
                        <input type="tel" name="TELEFON" id="TELEFON" placeholder="Telefonszám" pattern="^06\d{2}\d{3}\d{4}$">
                    </div>

                    <div class="input-field">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="VEZETO" id="VEZETO" placeholder="Áruház vezető">
                    </div>

                </div>
                <div class="admin-button-field">
                    <button type="submit">Hozzáadás</button>
                </div>
            </form>
        </div>

                                                 <!-- Műfaj hozzáadása -->

        <div class="admin-form-box">
            <h1>Műfaj hozzáadása</h1>

            <form method="post" id="genre-register-form" action="../Back-End/shop-genre/genre-add.php">

                <div class="admin-input-group">
                    <div class="input-field" >
                        <i class="fa-solid fa-font"></i>
                        <input type="text" name="MUFAJ_NEV" id="MUFAJ_NEV" placeholder="Műfaj név">
                    </div>
                </div>
                <div class="admin-button-field">
                    <button type="submit">Hozzáadás</button>
                </div>
            </form>
        </div>

                                                 <!-- Alműfaj hozzáadása -->

        <div class="admin-form-box">
            <h1>Alműfaj hozzáadása</h1>

            <form method="post" id="subgenre-register-form" action="../Back-End/shop-genre/subgenre-add.php">

                <div class="admin-input-group">
                    <div class="input-field" >
                        <i class="fa-solid fa-font"></i>
                        <input type="text" name="ALMUFAJ_NEV" id="ALMUFAJ_NEV" placeholder="Alműfaj név">
                    </div>
                </div>
                <div class="admin-button-field">
                    <button type="submit">Hozzáadás</button>
                </div>
            </form>
        </div>
    </div>
    <div class="admin_print">
        <div class="admin_print_element">
            <h1>Műfajok</h1>
            <table>
                <tr>
                    <th>Műfaj</th>
                    <th>Frissítés</th>
                    <th>Törlés</th>
                </tr>
                <?php foreach ($mufajok as $mufaj) {
                    echo "<tr>";
                    echo "<form method='POST' action='../Back-End/shop-genre/update_genre.php'>";
                    echo "<td>
                            <input type='hidden' name='id' value='" . $mufaj->ID . "'>
                            <input type='text' name='mufaj_nev' class='print_input' value='" . $mufaj->MUFAJ_NEV . "'>
                          </td>";
                    echo "<td><button type='submit'>Frissítés</button></td>";
                    echo "<td><a href='../Back-end/shop-genre/delete_genre.php?id=" . $mufaj->ID . "'>Törlés</a></td>";
                    echo "</form>";
                    echo "</tr>";
                } ?>
            </table>
        </div>

        <div class="admin_print_element">
            <h1>Alműfajok</h1>
            <table>
                <tr>
                    <th>Alműfaj</th>
                    <th>Frissítés</th>
                    <th>Törlés</th>
                </tr>
                <?php foreach ($almufajok as $almufaj) {
                    echo "<tr>";
                    echo "<form method='POST' action='../Back-End/shop-genre/update_subgenre.php'>";
                    echo "<td>
                            <input type='hidden' name='id' value='" . $almufaj->ID . "'>
                            <input type='text' name='almufaj_nev' class='print_input' value='" . $almufaj->ALMUFAJ_NEV . "'>
                          </td>";
                    echo "<td><button type='submit'>Frissítés</button></td>";
                    echo "<td><a href='../Back-end/shop-genre/delete_subgenre.php?id=" . $almufaj->ID . "'>Törlés</a></td>";
                    echo "</form>";
                    echo "</tr>";
                } ?>
            </table>
        </div>

        <div class="admin_print_element">
            <h1>Áruházak</h1>
                TODO
        </div>
    </div>
            <!-- Form-ok vége -->




<script>

    document.getElementById("shop-register-form").addEventListener("submit", function(event){
        const cim = document.getElementById("CIM").value.trim();
        const email = document.getElementById("EMAIL").value.trim();
        const telefon = document.getElementById("TELEFON").value.trim();
        const vezeto = document.getElementById("VEZETO").value.trim();

        if(!cim || !email || !telefon || !vezeto){
            alert("Kérem, töltson ki minden mezőt!");
            event.preventDefault();
        }

    });

    document.getElementById("genre-register-form").addEventListener("submit", function(event){
        const mufajNev = document.getElementById("MUFAJ_NEV").value.trim();

        if(!mufajNev){
            alert("Kérem, töltson ki minden mezőt!");
            event.preventDefault();
        }

    });

    document.getElementById("subgenre-register-form").addEventListener("submit", function(event){
        const almufajNev = document.getElementById("ALMUFAJ_NEV").value.trim();

        if(!almufajNev){
            alert("Kérem, töltson ki minden mezőt!");
            event.preventDefault();
        }

    });

</script>

    
</body>
</html>