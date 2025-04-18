<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book25</title>
    <link rel="stylesheet" href="StyleSheets/style.css">
    <script src="https://kit.fontawesome.com/0b5692342b.js" crossorigin="anonymous"></script>
</head>

<body id="bookregisterBody">

    <div class="topbar">
        <div class="logo"><a href="index.html">BOOK<span>25</span>.hu</a></div>
    </div>

    <div class="admin-container">

                                                 <!-- Áruház hozzáadása -->

        <div class="admin-form-box">
            <h1>Könyv hozzáadása</h1>

            <form action="../Back-end/add_book.php" method="POST" id="book-register-form" >

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
                        <i class="fa-solid fa-hashtag"></i>
                        <input type="text" name="szerzok" id="szerzok" placeholder="Szerző(k)">
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-hashtag"></i>
                        <select name="mufaj" id="mufaj">
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

                </div>
                <div class="admin-button-field">
                    <button type="submit">Hozzáadás</button>
                </div>
            </form>
        </div>

    </div>

    <script>

    </script>


</body>
