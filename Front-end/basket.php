<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="StyleSheets/style.css">
    <link rel="stylesheet" href="StyleSheets/basket_style.css">
    <title>Kosár</title>
</head>
<body>

    <!--Fejléc és a menü-->
    <?php include "header.php"; ?>

    <div id="chart-container">
        <h1>Kosár</h1>
        <form class="chart-item" action="update_item.php" method="POST">
            <img src="../Back-end/img/9786155385674.jpg" alt="Könyv borító">
            
            <div class="chart-info">
                <h2>Egri Csillagok</h2>
                <p>ISBN: 9786155385674</p>
                <h3>Ár: 3490 Ft</h3>
            </div>
            
            <div class="chart-actions">
                <input type="hidden" name="book_id" value="9786155385674">
                <input type="number" name="quantity" value="1" min="1" max="10">
                <button type="submit">Módosít</button>
                <input type="button" value="Törlés">
            </div>
        </form>
        <hr>

        <form class="chart-item" action="update_item.php" method="POST">
            <img src="../Back-end/img/9789635983391.jpg" alt="Könyv borító">
            
            <div class="chart-info">
                <h2>Az Aratás Hajnala</h2>
                <p>ISBN: 9789635983391</p>
                <h3>Ár: 5000 Ft</h3>
            </div>
            
            <div class="chart-actions">
                <input type="hidden" name="book_id" value="9789635983391">
                <input type="number" name="quantity" value="1" min="1" max="10">
                <button type="submit">Módosít</button>
                <input type="button" value="Törlés">
            </div>
        </form>
        <hr>

    </div>

    <div id="order-container">
        <h2>Rendelés véglegesítése</h2>
        <form action="order.php" method="POST">


            <div id="price">Végösszeg: <b>8500 Ft</b></div>
            <label for="address">Szállítási cím:</label>
            <input type="text" id="address" name="address" required>
            


            <fieldset>
                <!--Kártya adatokat nem mentünk el, csak itt van, hogy élethű legyen-->
                <legend>Bankkártya adatok</legend>

                <label for="card_number">Kártyára írt név:</label>
                <input type="text" id="card_name" name="card_name" placeholder="Valami Név"  required>
                <label for="card_number">Kártya szám:</label>
                <input type="text" id="card_number" name="card_number" pattern="\d{16}" placeholder="xxxxxxxxxxxxxxxx" required>

                <div class="card-details">
                    <div class="expiration-date">
                        <label for="expiry_date">Lejárat:</label>
                        <input type="month" id="expiry_date" name="expiry_date" required>
                    </div>
                    <div class="cvv">
                        <label for="cvv">CVV:</label>
                        <input type="text" id="cvv" name="cvv" pattern="\d{3}" placeholder="XXX" required>
                    </div>
                </div>
            </fieldset>
            <br>
            <button type="submit">Rendelés leadása</button>
        </form>

    </div>


</body>
</html>