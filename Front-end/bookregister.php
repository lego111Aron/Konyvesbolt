<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book25</title>
    <link rel="stylesheet" href="StyleSheets/style.css">
    <script src="https://kit.fontawesome.com/0b5692342b.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

                                                 <!-- Áruház hozzáadása -->

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
