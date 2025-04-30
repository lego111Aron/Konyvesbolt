<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book25</title>
    <link rel="stylesheet" href="StyleSheets/style.css">
</head>

<body id="booksBody">

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

    <div class="szuro-doboz">
        <form class="szuro-form">
          
          <div class="kategoria-es-kereso">
            <div class="kategoriak">
              <label>
                <input type="checkbox" name="kategoriak[]" value="Horror">
                <span>Horror</span>
              </label>
              <label>
                <input type="checkbox" name="kategoriak[]" value="Romantikus">
                <span>Romantikus</span>
              </label>
              <label>
                <input type="checkbox" name="kategoriak[]" value="Krimi">
                <span>Krimi</span>
              </label>
              <label>
                <input type="checkbox" name="kategoriak[]" value="Szépirodalom">
                <span>Szépirodalom</span>
              </label>
            </div>
      
            <input type="text" class="kereso" placeholder="Írja be a keresett kifejezést">
          </div>
      
          <div class="arszuro">
            <input type="range" id="ar" min="1000" max="20000" value="1000" step="500">
            <output id="ar-ertek">1000</output>
          </div>
      
          <button type="submit" class="szures-gomb">Szűrés</button>
        </form>
      </div>

</body>
</html>