<?php
    include "../Back-end/connect.php";

    $sql = "SELECT ISBN, KIADAS, CIM, OLDALAK_SZAMA, AR FROM KONYV";
    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);
    $konyvek = [];
    while ($row = oci_fetch_object($stmt)) {
        $konyvek[] = $row;
    } 

    $sql = "SELECT * FROM KIADO";
    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);
    $kiadok = [];
    while ($row = oci_fetch_object($stmt)) {
        $kiadok[] = $row;
    } 
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book25</title>
    <script src="https://kit.fontawesome.com/0b5692342b.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="StyleSheets/style.css">

    <script>
        $(document).ready(function() {
            console.log("Select2 init...");
            $('.subgenres-select').select2({
                placeholder: "Válassz alműfajokat"
            });

            $('#book-register-form').on('submit', function(e) {
                const valasztott = $('.subgenres-select').val();
                console.log("Kiválasztott alműfajok:", valasztott);
            });
        });
    </script>
</head>

<body id="bookregisterBody">

    <div class="topbar">
        <div class="logo"><a href="index.html">BOOK<span>25</span>.hu</a></div>
    </div>

    <div class="admin-container">
        <div class="admin-form-box">
            <h1>Könyv hozzáadása</h1>

            <form action="../Back-end/add_book.php" method="POST" id="book-register-form" enctype="multipart/form-data">

                <div class="admin-input-group">

                    <div class="input-field" >
                        <i class="fa-solid fa-barcode"></i>
                        <input type="text" name="ISBN" id="ISBN" placeholder="ISBN azonosító">
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-calendar"></i>
                        <input type="date" name="KIADAS" id="KIADAS" placeholder="Kiadás">
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-font"></i>
                        <input type="text" name="CIM" id="CIM" placeholder="Cím">
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-book"></i>
                        <input type="number" name="OLDALAK_SZAMA" id="OLDALAK_SZAMA" placeholder="Oldalak száma">
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-tag"></i>
                        <input type="number" name="AR" id="AR" placeholder="Ár">
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-hashtag"></i>
                        
                        <input type="number" name="ADOSZAM" id="ADOSZAM" placeholder="Kiadó adószáma">
                    </div>

                    <div class="input-field">
                        <i class="fa-solid fa-pencil"></i>
                        <input type="text" name="szerzok" id="szerzok" placeholder="Szerző(k)">
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-list"></i>
                        <select name="mufaj" id="mufaj">
                            <option value="" disabled selected>Műfaj</option>
                        <?php
                            include '../Back-end/connect.php';
                            $sql = "SELECT id, mufaj_nev FROM mufaj";
                            $stmt = oci_parse($conn, $sql);
                            oci_execute($stmt);
                            $found = false;

                            while ($row = oci_fetch_assoc($stmt)) {
                                $found = true;
                                echo "<option value='" . $row['ID'] . "'>" . $row['MUFAJ_NEV'] . "</option>";
                            }

                            if (!$found) {
                                echo "<option value=''>Nincs elérhető műfaj</option>";
                            }

                            oci_free_statement($stmt);
                            oci_close($conn);
                        ?>
                        </select>
                    </div>
                    <div class="input-field">
                        <select class="subgenres-select" name="almufajok[]" multiple="multiple" style="width: 300px;">
                        <?php
                            include '../Back-end/connect.php';
                            $sql = "SELECT id, almufaj_nev FROM almufaj";
                            $stmt = oci_parse($conn, $sql);
                            oci_execute($stmt);
                            $found = false;

                            while ($row = oci_fetch_assoc($stmt)) {
                                $found = true;
                                echo "<option value='" . $row['ID'] . "'>" . $row['ALMUFAJ_NEV'] . "</option>";
                            }

                            if (!$found) {
                                echo "<option value=''>Nincs elérhető alműfaj</option>";
                            }

                            oci_free_statement($stmt);
                            oci_close($conn);
                        ?>
                        </select>

                    </div>
                    <div class="input-field">
                        <input type="file" name="kep" id="kep">
                    </div>
                    <div class="admin-button-field">
                        <button type="submit">Hozzáadás</button>
                    </div>
            </form>
        </div>
    </div>

    <div class="admin-form-box">
        <h1>Kiadó hozzáadása</h1>

        <form action="../Back-end/add_publisher.php" method="post" id="publisher-register-form">

            <div class="admin-input-group">
                <div class="input-field" >
                    <i class="fa-solid fa-hashtag"></i>
                    <input type="number" name="ADOSZAM" id="CREATE_ADOSZAM" placeholder="Adószám">
                </div>

                <div class="input-field" >
                    <i class="fa-solid fa-font"></i>
                    <input type="text" name="NEV" id="KIADO_NEV" placeholder="Kiadó neve">
                </div>

                <div class="input-field" >
                    <i class="fa-solid fa-location-dot"></i>
                    <input type="text" name="SZEKHELY" id="SZEKHELY" placeholder="Kiadó székhelye">
                </div>

            </div>
            <div class="admin-button-field">
                <button type="submit">Hozzáadás</button>
            </div>
        </form>
    </div>

    </div>
    <div class="admin_print_element">
            <h1>Könyvek</h1>
            <table id="book-table">
                <tr>
                    <th>ISBN</th>
                    <th>Cím</th>
                    <th>Kiadás</th>
                    <th>Oldalak száma</th>
                    <th>Ár</th>
                    <th>Frissítés</th>
                    <th>Törlés</th>
                </tr>
                <?php foreach ($konyvek as $konyv): ?>
                    <tr>
                        <form action="../Back-end/update_book.php" method="post">
                            <td><?php echo $konyv->ISBN; ?></td>
                            <td><input class="print_input" type="text" name="cim" value="<?php echo $konyv->CIM; ?>"></td>
                            <td><?php echo $konyv->KIADAS; ?></td>
                            <td><input class="print_input" type="number" name="oldalak_szama" value="<?php echo $konyv->OLDALAK_SZAMA; ?>"></td>
                            <td><input class="print_input" type="number" step="0.01" name="ar" value="<?php echo $konyv->AR; ?>"></td>
                            <input type="hidden" name="isbn" value="<?php echo $konyv->ISBN; ?>">

                            <td><button type="submit">Frissítés</button></td>
                        </form>
                        <td><a href="../Back-end/delete_book.php?isbn=<?php echo $konyv->ISBN; ?>" onclick="return confirm('Biztosan törlöd ezt a könyvet?')">Törlés</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>


        <div class="admin_print_element">
            <h1>Kiadók</h1>
            <table id="publisher-table">
                <tr>
                    <th>Adószám</th>
                    <th>Név</th>
                    <th>Székhely</th>
                    <th>Frissítés</th>
                </tr>
                <?php foreach ($kiadok as $kiado): ?>
                    <tr>
                        <form action="../Back-end/update_publisher.php" method="post">
                            <td><?php echo $kiado->ADOSZAM; ?></td>
                            <td><input class="print_input" type="text" name="nev" value="<?php echo $kiado->NEV; ?>"></td>
                            <td><input class="print_input" type="text" name="szekhely" value="<?php echo $kiado->SZEKHELY; ?>"></td>
                            <input type="hidden" name="adoszam" value="<?php echo $kiado->ADOSZAM; ?>">

                            <td><button type="submit">Frissítés</button></td>
                        </form>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>




    <script>

    document.getElementById("book-register-form").addEventListener("submit", function(event){
        const isbn = document.getElementById("ISBN").value.trim();
        const kiadas = document.getElementById("KIADAS").value.trim();
        const cim = document.getElementById("CIM").value.trim();
        const oldalak_szama = document.getElementById("OLDALAK_SZAMA").value.trim();
        const ar = document.getElementById("AR").value.trim();
        const adoszam = document.getElementById("ADOSZAM").value.trim();
        const szerzo_nev = document.getElementById("szerzok").value.trim();
        


        if(!isbn || !kiadas || !cim || !oldalak_szama || !ar || !adoszam || !szerzo_nev){
            alert("Kérem, töltson ki minden mezőt!");
            event.preventDefault();
        }

        if(ar < 0){
            alert("Az ár nem lehet negatív érték!");
            event.preventDefault();
        }
        if(oldalak_szama && oldalak_szama <= 0){
            alert("Az oldalak száma nem lehet 0 vagy annál kisebb!")
            event.preventDefault();
        }

    });

    document.getElementById("publisher-register-form").addEventListener("submit", function(event){

        const create_adoszam = document.getElementById("CREATE_ADOSZAM").value.trim();   
        const kiado_nev = document.getElementById("KIADO_NEV").value.trim();   
        const szekhely = document.getElementById("SZEKHELY").value.trim();

        if(!create_adoszam || !kiado_nev || !szekhely){
            alert("Kérem, töltsön ki minden mezőt!");
            event.preventDefault();
        }

    });

    </script>


</body>